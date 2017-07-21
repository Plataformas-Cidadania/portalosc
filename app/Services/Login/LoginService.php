<?php

namespace App\Services\Login;

use App\Services\Service;
use App\Dao\Login\LoginDao;
use App\Enums\UserTypeEnum;

class LoginService extends Service
{
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
	
	public function execute($contentRequest, $user = null)
	{
		$attributes['tx_email_usuario'] = ['required' => true, 'type' => 'string'];
		$attributes['tx_senha_usuario'] = ['required' => true, 'type' => 'string'];
		$this->request->setRequest($attributes, $contentRequest);
		
		if($this->request->getFlag()){
			$dao = new LoginDao();
			$resultDao = $dao->execute($this->request->getContent());
			
			if($resultDao){
				if($resultDao['bo_ativo']){
					$this->response->setResponse(['msg' => 'Login realizado com sucesso.'], 200);
					$this->response->updateContent($this->configContent($resultDao));
				}else{
					$this->response->setResponse(['msg' => 'Usuário não ativado.'], 403);
				}
			}else{
				$this->response->setResponse(['msg' => 'Usuário inválido.'], 401);
			}
		}else{
			$this->response->setResponse(['msg' => $this->request->getMessage()], 400);
		}
		
		return $this->response;
	}
}
