<?php

namespace App\Http\Services\Login;

use App\Http\Services\Service;
use App\Http\Util\CheckRequestUtil;
use App\Http\Dao\Login\LoginDao;
use App\Http\Enums\UserTypeEnum;

class LoginService extends Service
{
	private function check($object)
	{
		$result = null;
		
		$checkRequestUtil = new CheckRequestUtil();
		
		$requiredData = ['tx_email_usuario', 'tx_senha_usuario'];
		$result = $checkRequestUtil->checkRequiredData($requiredData, $object);
		
		if(!$result){
			$result = $checkRequestUtil->checkData($object);
		}
		
		return $result;
	}
	
	private function configContent($resultDao){
		$expires = strtotime('+15 minutes');
		
		$content['id_usuario'] = $resultDao['id_usuario'];
		$content['tx_nome_usuario'] = $resultDao['tx_nome_usuario'];
		$content['cd_tipo_usuario'] = $resultDao['cd_tipo_usuario'];
		
		if($resultDao['cd_tipo_usuario'] == UserTypeEnum::Admin){
			$token = $resultDao['id_usuario']. '_' . $resultDao['cd_tipo_usuario'] . '_' . $expires;
		}else if($resultDao['cd_tipo_usuario'] == UserTypeEnum::OSC){
			$content['representacao'] = $resultDao['representacao'];
			$token = $resultDao['id_usuario']. '_' . $resultDao['cd_tipo_usuario'] . '_' . $resultDao['representacao'] . '_' . $expires;
		}else if($resultDao['cd_tipo_usuario'] == UserTypeEnum::GovCity){
			$content['localidade'] = $resultDao['cd_municipio'];
			$token = $resultDao['id_usuario']. '_' . $resultDao['cd_tipo_usuario'] . '_' . $resultDao['cd_municipio'] . '_' . $expires;
		}else if($resultDao['cd_tipo_usuario'] == UserTypeEnum::GovState){
			$content['localidade'] = $resultDao['cd_uf'];
			$token = $resultDao['id_usuario']. '_' . $resultDao['cd_tipo_usuario'] . '_' . $resultDao['cd_uf'] . '_' . $expires;
		}
		
		$content['access_token'] = openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
		$content['token_type'] = 'Bearer';
		$content['expires_in'] = $expires;
		
		return $content;
	}
	
	public function execute($object)
	{
		$content['msg'] = 'Login realizado com sucesso.';
		$this->response->setResponse($content, 200);
		
		$resultCheck = $this->check($object);
		if($resultCheck){
			$content['msg'] = $resultCheck;
			$this->response->setResponse($content, 400);
		}else{		
			$dao = new LoginDao();
			$resultDao = $dao->execute($object);
			
			if($resultDao){
				if($resultDao['bo_ativo']){
					$content = $this->configContent($resultDao);
					$this->response->updateContent($content);
				}else{
					$content['msg'] = 'Usuário não ativado.';
					$this->response->setResponse($content, 403);
				}
			}else{
				$content['msg'] = 'Usuário inválido.';
				$this->response->setResponse($content, 401);
			}
		}
		
		return $this->response;
	}
}
