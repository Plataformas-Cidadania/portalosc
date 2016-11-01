<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dao\UserDao;


class UserController extends Controller
{
	private $dao;
	private $email;

	public function __construct()
	{
		$this->dao = new UserDao();
		$this->email = new EmailController();
	}

    public function getUser(Request $request, $id)
    {
		$id = trim($id);
        $resultDao = $this->dao->getUser($id);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function createUser(Request $request)
    {
        $email = $request->input('tx_email_usuario');
    	$senha = $request->input('tx_senha_usuario');
    	$nome = $request->input('tx_nome_usuario');
    	$cpf = $request->input('nr_cpf_usuario');
    	$lista_email = $request->input('bo_lista_email');
    	$representacao = $request->input('representacao');
        $token = md5($cpf.time());
        
		$params = [$email, $senha, $nome, $cpf, $lista_email, $representacao, $token];
		$resultDao = json_decode($this->dao->createUser($params));
		
		if($resultDao->status){
			foreach($representacao as $value) {
				$id_osc = $value['id_osc'];
				/*
				$params_osc = [$id_osc];
				$json = json_decode($this->dao->getOscEmail($params_osc));
				$nomeOsc = $json->tx_razao_social_osc;
				$emailOsc = $json->tx_email;
				$user = ["nome"=>$nome, "email"=>$email, "cpf"=>$cpf];
				$emailIpea = "mapaosc@ipea.gov.br";
				
				if($emailOsc == null){
					$emailOsc = "Esta Organização não possui email para contato.";
					$osc = ["nomeOsc"=>$nomeOsc, "emailOsc"=>$emailOsc];
// 					$message = $this->email->informationIpea($user, $osc);
// 					$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das OSCs", $message);
				}else{
// 					$message = $this->email->informationOSC($user, $nomeOsc);
// 					$this->email->send($emailOsc, "Notificação de cadastro no Mapa das Organizações da Sociedade Civil", $message);
					$osc = ["nomeOsc"=>$nomeOsc, "emailOsc"=>$emailOsc];
// 					$message = $this->email->informationIpea($user, $osc);
// 					$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das OSCs", $message);
				}
				*/
				$result = ['msg' => $resultDao->mensagem];
				$this->configResponse($result, 200);
			}
		}else{
			$result = ['msg' => $resultDao->mensagem];
			$this->configResponse($result, 400);
		}
// 		$message = $this->email->confirmation($nome, $token);
// 		$this->email->send($email, "Confirmação de Cadastro Mapa das Organizações da Sociedade Civil", $message);
        return $this->response();
    }

    public function updateUser(Request $request)
    {
    	$id_osc = $request->input('id_usuario');
        $email = $request->input('tx_email_usuario');
    	$senha = $request->input('tx_senha_usuario');
    	$nome = $request->input('tx_nome_usuario');
    	$cpf = $request->input('nr_cpf_usuario');
    	$lista_email = $request->input('bo_lista_email');
    	$representacao = $request->input('representacao');

		$params = [$id_osc, $email, $senha, $nome, $cpf, $lista_email, $representacao];
    	$resultDao = json_decode($this->dao->updateUser($params));
		if($resultDao->nova_representacao){
			foreach($resultDao->nova_representacao as $key=>$value) {
				$id_osc = $resultDao->nova_representacao[$key]->id_osc;
				$params_osc = [$id_osc];
				$json = json_decode($this->dao->getOscEmail($params_osc));
				$nomeOsc = $json->tx_razao_social_osc;
				$emailOsc = $json->tx_email;
				$user = ["nome"=>$nome, "email"=>$email, "cpf"=>$cpf];
				$emailIpea = "mapaosc@ipea.gov.br";
				if($emailOsc == null){
					$emailOsc = "Esta Organização não possui email para contato.";
					$osc = ["nomeOsc"=>$nomeOsc, "emailOsc"=>$emailOsc];
// 					$message = $this->email->informationIpea($user, $osc);
// 					$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das OSCs", $message);
				}else{
// 					$message = $this->email->informationOSC($user, $nomeOsc);
// 					$this->email->send($emailOsc, "Notificação de cadastro no Mapa das Organizações da Sociedade Civil", $message);
					$osc = ["nomeOsc"=>$nomeOsc, "emailOsc"=>$emailOsc];
// 					$message = $this->email->informationIpea($user, $osc);
// 					$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das OSCs", $message);
				}
			}
		}

    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

    public function loginUser(Request $request)
    {
        $email = $request->input('tx_email_usuario');
    	$senha = $request->input('tx_senha_usuario');

		$params = [$email, $senha];
        $resultDao = $this->dao->loginUser($params);

        if($resultDao){
			$tx_nome_usuario = json_decode($resultDao)->tx_nome_usuario;
			$id_usuario = json_decode($resultDao)->id_usuario;
			$time_expires = strtotime('+15 minutes');
			$token = openssl_encrypt($id_usuario.':'.$time_expires, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));

			$params = [$id_usuario, $token];
			$result = ['id_usuario' => $id_usuario,
						'tx_nome_usuario' => $tx_nome_usuario,
						'access_token' => $token,
						'token_type' => 'Bearer',
						'expires_in' => $time_expires];
        }else{
			$result = null;
		}
    	$this->configResponse($result);
        return $this->response();
    }

    public function logoutUser($id)
    {
		$id = trim(urldecode($id));
		$params = [$id];
        $resultDao = $this->dao->deleteToken($params);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function activateUser($id, $token)
    {
    	$result = $this->validateToken($id, $token);
    	if($result){
    		$params = [$id];
	    	$resultDao = $this->dao->activateUser($params);
	    	$this->configResponse($resultDao);
	    	echo "Usuario ativado com sucesso!\n";

    		$this->deleteToken($id);
    		$params_user = [$id];
    		$json = json_decode($this->dao->getUserEmail($params_user));
    		$nome = $json->tx_nome_usuario;
    		$email = $json->tx_email_usuario;
//     		$message = $this->email->welcome($nome);
// 			$this->email->send($email, "Cadastro Confirmado!", $message);
    	}else{
    		echo "Usuario ou token invalido!\n";
    	}
    }

    public function validateToken($id, $token)
    {
    	$params = [$id, $token];
    	$resultDao = $this->dao->validateToken($params);
    	$result = json_decode($resultDao)->result;
    	return $result;
    }

    public function deleteToken($id)
    {
    	$params = [$id];
    	$resultDao = $this->dao->deleteToken($params);
    	$this->configResponse($resultDao);
    	echo "Token Excluido!\n";
    }

    public function updatePassword(Request $request, $id)
    {
    	$senha = $request->input('tx_senha_usuario');
    	$params = [$id, $senha];
    	$resultDao = $this->dao->updatePassword($params);
    	$result = json_decode($resultDao)->mensagem;
    	if(json_decode($resultDao)->status){
    		$this->deleteToken($id);
    	}
    	return $result;
    }

    public function forgotPassword(Request $request)
    {
    	$email = $request->input('tx_email_usuario');
    	$params = [$email];
    	$resultDao = $this->dao->getUserChangePassword($params);
    	if($resultDao != null){
    		if(json_decode($resultDao)->bo_ativo){
		    	$id_user = json_decode($resultDao)->id_usuario;
		    	$cpf = json_decode($resultDao)->nr_cpf_usuario;
		    	$nome = json_decode($resultDao)->tx_nome_usuario;
		    	$token = md5($cpf.time());
		    	$date = date("Y-m-d H:i:s");
		    	$params_token = [$id_user, $token, $date];
		    	$result_token = $this->dao->createToken($params_token);
		    	if(json_decode($result_token)->inserir_token_representante){
	//     			$message = $this->email->changePassword($nome, $token);
	//     			$this->email->send($email, "Alterar Senha!", $message);
		    	}else{
		    		echo "Email invalido!";
		    	}
    		}else{
    			echo "Ative seu cadastro!";
    		}
    	}else{
    		echo "Email invalido!";
    	}
    }

    public function contato(Request $request)
    {
    	$assunto = $request->input('assunto');
    	$nome = $request->input('nome');
    	$email = $request->input('email');
    	$texto = $request->input('mensagem');
    	$message = $this->email->contato($nome, $texto);
    	$emailIpea = "mapaosc@ipea.gov.br";
    	$this->email->send($emailIpea, $assunto, $message);
    }
}
