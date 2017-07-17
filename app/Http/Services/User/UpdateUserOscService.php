<?php

namespace App\Http\Services\User;

use App\Http\Services\Service;
use App\Http\Util\CheckRequestUtil;
use App\Http\Dao\User\UpdateUserOscDao;

class UpdateUserOscService extends Service
{
	private function check($object)
	{
		$result = null;
		
		$checkRequestUtil = new CheckRequestUtil();
		
		$requiredData = ['id_usuario', 'tx_email_usuario', 'tx_nome_usuario', 'tx_senha_usuario', 'representacao'];
		$result = $checkRequestUtil->checkRequiredData($requiredData, $object);
		
		if(!$result){
			$result = $checkRequestUtil->checkData($object);
		}
		
		return $result;
	}
	
	private function configContent($object){
		$cd_tipo_usuario = 2;
		$time_expires = strtotime('+15 minutes');
		
		$representacaoString = array();
		foreach($object['representacao'] as $key => $value){
			array_push($representacaoString, $value['id_osc']);
		}
		$representacaoString = str_replace(' ', '', implode(',', $representacaoString));
		
		$token = $object['id_usuario'].'_'.$cd_tipo_usuario.'_'.$representacaoString.'_'.$time_expires;
		$token = openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
		
		$content['id_usuario'] = $object['id_usuario'];
		$content['tx_nome_usuario'] = $object['tx_nome_usuario'];
		$content['cd_tipo_usuario'] = $cd_tipo_usuario;
		$content['representacao'] = '['.$representacaoString.']';
		$content['access_token'] = $token;
		$content['token_type'] = 'Bearer';
		$content['expires_in'] = $time_expires;
		
		return $content;
	}
	
	public function execute($object)
	{
		$content['msg'] = 'Usuário atualizado com sucesso.';
		$this->response->setResponse($content, 200);
		
		$resultCheck = $this->check($object);
		if($resultCheck){
			$content['msg'] = $resultCheck;
			$this->response->setResponse($content, 400);
		}else{
			$dao = new UpdateUserOscDao();
			
			$resultDao = $dao->execute($object);
			
			if($resultDao['status']){
				if($resultDao['nova_representacao']){
					foreach($resultDao['nova_representacao'] as $value) {
						$params_osc = [$value['id_osc']];
						
						$osc = ['nomeOsc' => $value['tx_razao_social_osc'], 'emailOsc' => $value['tx_email']];
						$user = ['nome' => $object['tx_nome_usuario'], 'email' => $object['tx_email_usuario'], 'cpf' => $resultDao['nr_cpf_usuario']];
						$emailIpea = "mapaosc@ipea.gov.br";
						
						if($value['tx_email'] == null){
							#$message = $this->email->informationIpea($user, $osc);
							#$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil", $message);
						}else{
							#$message = $this->email->informationOSC($user, $nomeOsc);
							#$this->email->send($emailOsc, "Notificação de cadastro no Mapa das Organizações da Sociedade Civil", $message);
							
							#$message = $this->email->informationIpea($user, $osc);
							#$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil", $message);
						}
					}
				}
				
				$content = $this->configContent($object);
				
				$this->response->updateContent($content);
			}else{
				$content['msg'] = $resultDao->mensagem;
				$this->response->setResponse($content, 400);
			}
		}
		
		return $this->response;
	}
}