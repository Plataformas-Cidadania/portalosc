<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Dao\UsuarioDao;
use App\Util\CheckRequestUtil;

class EditarRepresentanteGovernoService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'id_usuario' => ['apelidos' => NomenclaturaAtributoEnum::ID_USUARIO, 'obrigatorio' => true, 'tipo' => 'numeric'],
	        'tx_email_usuario' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'email'],
	        'tx_senha_usuario' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'string'],
	        'tx_nome_usuario' => ['apelidos' => NomenclaturaAtributoEnum::NOME_USUARIO, 'obrigatorio' => true, 'tipo' => 'string'],
	        'localidade' => ['apelidos' => NomenclaturaAtributoEnum::REPRESENTACAO, 'obrigatorio' => true, 'tipo' => 'arrayArray']
	    ];
	    
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