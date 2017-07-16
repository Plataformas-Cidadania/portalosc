<?php

namespace App\Http\Services\User;

use App\Http\Services\Service;
use App\Http\Util\CheckRequestUtil;
use App\Http\Dao\User\LoginDao;

class GetUserService extends Service
{
	private $dao;
	
	public function check($object)
	{
		$checkRequestUtil = new CheckRequestUtil();
		
		$requiredData = ['tx_email_usuario', 'tx_senha_usuario'];
		$msgCheckData = $checkRequestUtil->checkRequiredData($requiredData, $object);
		
		if($msgCheckData){
			$content = ['msg' => $msgCheckData];
			$this->result->setResult($content, 400);
		}else{
			$msgCheckData = $checkRequestUtil->checkData($object);
			
			if($msgCheckData){
				$content = ['msg' => $msgCheckData];
				$this->result->setResult($content, 400);
			}
		}
		
		return $this->result;
	}
	
	public function execute($object)
	{
		$this->dao = new LoginDao();
		
		$resultDao = $this->dao->loginUser($object);
		
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
				
				$content['msg'] = 'Usuário autorizado.';
				$content['token_type'] = 'Bearer';
				$content['expires_in'] = $expires;
				$content['id_usuario'] = $resultDao['id_usuario'];
				$content['tx_nome_usuario'] = $resultDao['tx_nome_usuario'];
				$content['cd_tipo_usuario'] = $resultDao['cd_tipo_usuario'];
				$content['access_token'] = openssl_encrypt($string_token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
				
				$this->result->setResult($content, 200);
			}else{
				$content['msg'] = 'Usuário não ativado.';
				$this->result->setResult($content, 403);
			}
		}else{
			$this->result->setResult(['msg' => 'Usuário inválido.'], 401);
		}
		
		return $this->result;
	}
}