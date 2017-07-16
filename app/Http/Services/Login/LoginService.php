<?php

namespace App\Http\Services\Login;

use App\Http\Services\Service;
use App\Http\Util\CheckRequestUtil;
use App\Http\Dao\Login\LoginDao;

class LoginService extends Service
{
	private function check($object)
	{
		$checkRequestUtil = new CheckRequestUtil();
		
		$requiredData = ['tx_email_usuario', 'tx_senha_usuario'];
		$msgCheckData = $checkRequestUtil->checkRequiredData($requiredData, $object);
		
		if($msgCheckData){
			$content['msg'] = $msgCheckData;
			$this->response->setResponse($content, 400);
		}else{
			$msgCheckData = $checkRequestUtil->checkData($object);
			
			if($msgCheckData){
				$content['msg'] = $msgCheckData;
				$this->response->setResponse($content, 400);
			}
		}
	}
	
	private function execute($object)
	{
		$dao = new LoginDao();
		
		$resultDao = $dao->run($object);
		
		if($resultDao){
			if($resultDao['bo_ativo']){
				$expires = strtotime('+15 minutes');
				
				if($resultDao['cd_tipo_usuario'] == 1){
					$string_token = $resultDao['id_usuario']. '_' . $resultDao['cd_tipo_usuario'] . '_' . $expires;
				}else if($resultDao['representacao'] != null){
					$result['tipo_usuario'] = 2;
					$result['representacao'] = '[' . $resultDao['representacao'] . ']';
					$string_token = $resultDao['id_usuario']. '_' . $resultDao['cd_tipo_usuario'] . '_' . $resultDao['representacao'] . '_' . $expires;
				}else if($resultDao['cd_municipio'] != null){
					$result['tipo_usuario'] = 3;
					$result['localidade'] = $resultDao['cd_municipio'];
					$string_token = $resultDao['id_usuario']. '_' . $resultDao['cd_tipo_usuario'] . '_' . $resultDao['cd_municipio'] . '_' . $expires;
				}else if($resultDao['cd_uf'] != null){
					$result['tipo_usuario'] = 4;
					$result['localidade'] = $resultDao['cd_uf'];
					$string_token = $resultDao['id_usuario']. '_' . $resultDao['cd_tipo_usuario'] . '_' . $resultDao['cd_uf'] . '_' . $expires;
				}
				
				$content['token_type'] = 'Bearer';
				$content['expires_in'] = $expires;
				$content['id_usuario'] = $resultDao['id_usuario'];
				$content['tx_nome_usuario'] = $resultDao['tx_nome_usuario'];
				$content['cd_tipo_usuario'] = $resultDao['cd_tipo_usuario'];
				$content['access_token'] = openssl_encrypt($string_token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
				
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
	
	public function run($object = [])
	{
		$content['msg'] = 'Login realizado com sucesso.';
		$this->response->setResponse($content, 200);
		
		$this->check($object);
		if($this->response->getFlag()){
			$this->execute($object);
		}
		
		return $this->response;
	}
}