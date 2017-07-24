<?php

namespace App\Components\Usuario\Services;

use App\Components\Service;
use App\Components\Usuario\DAO\User\UsuarioDAO;

use App\Util\CheckRequestUtil;

class EditarUsuarioEstatalService extends Service
{
	private function check($object)
	{
		$checkRequestUtil = new CheckRequestUtil();
		
		$requiredData = ['id_usuario', 'tx_email_usuario', 'tx_nome_usuario', 'tx_senha_usuario'];
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
		$dao = new UsuarioDAO();
		
		$resultDao = $dao->run($object);
		
		if($resultDao->status){
			$time_expires = strtotime('+15 minutes');
			
			$token = $object['id_usuario'].'_'.$object['cd_tipo_usuario'].'_'.$object['cd_localidade'].'_'.$time_expires;
			$token = openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
			
			$content['id_usuario'] = $object['id_usuario'];
			$content['tx_nome_usuario'] = $object['tx_nome_usuario'];
			$content['cd_tipo_usuario'] = $object['cd_tipo_usuario'];
			$content['cd_localidade'] = $object['cd_localidade'];
			$content['access_token'] = $token;
			$content['token_type'] = 'Bearer';
			$content['expires_in'] = $time_expires;
			
			$this->response->updateContent($content);
		}else{
			$content['msg'] = $resultDao->mensagem;
			$this->response->setResponse($content, 400);
		}
	}
	
	public function run($object = [])
	{
		$content['msg'] = 'Usuário atualizado com sucesso.';
		$this->response->setResponse($content, 200);
		
		$this->check($object);
		if($this->response->getFlag()){
			$this->execute($object);
		}
		
		return $this->response;
	}
}