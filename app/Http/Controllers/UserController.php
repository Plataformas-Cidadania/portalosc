<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dao\UserDao;


class UserController extends Controller{
	private $dao;
	private $email;

	public function __construct() {
		$this->dao = new UserDao();
		$this->email = new EmailController();
	}

    public function getUser(Request $request, $id){
		$id = trim($id);
        $resultDao = $this->dao->getUser($id);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function createUser(Request $request){
        $email = $request->input('tx_email_usuario');
    	$senha = $request->input('tx_senha_usuario');
    	$nome = $request->input('tx_nome_usuario');
    	$cpf = $request->input('nr_cpf_usuario');
    	$lista_email = $request->input('bo_lista_email');
    	$representacao = $request->input('representacao');
        $token = md5($cpf.time());

		$params = [$email, $senha, $nome, $cpf, $lista_email, $representacao, $token];
		$resultDao = json_decode($this->dao->createUser($params));
		if($resultDao->nova_representacao){
			foreach($resultDao->nova_representacao as $key=>$value) {
				$id_osc = $resultDao->nova_representacao[$key]->id_osc;
				// Mandar email para OSC
			}
		}
		#$message = $this->email->confirmation($nome, $token);
		#$this->email->send($email, $nome, "Confirmação de Cadastro Mapa das Organizações da Sociedade Civil", $message);

		$result = ['msg' => $resultDao->mensagem];
		$this->configResponse($result);
        return $this->response();
    }

    public function updateUser(Request $request){
    	$id_osc = $request->input('id_osc');
        $email = $request->input('tx_email_usuario');
    	$senha = $request->input('tx_senha_usuario');
    	$nome = $request->input('tx_nome_usuario');
    	$cpf = $request->input('nr_cpf_usuario');
    	$lista_email = $request->input('bo_lista_email');
    	$representacao = $request->input('representacao');

		$params = [$id_osc, $email, $senha, $nome, $cpf, $lista_email, $representacao];
    	$resultDao = json_decode($this->dao->loginUser($params));
		if($resultDao->nova_representacao){
			foreach($resultDao->nova_representacao as $key=>$value) {
				$id_osc = $resultDao->nova_representacao[$key]->id_osc;
				// Mandar email para OSC
			}
		}

    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

    public function loginUser(Request $request){
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

    public function logoutUser($id){
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
    		//Mandar email de Boas Vindas
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
	    	$id_user = json_decode($resultDao)->id_usuario;
	    	$cpf = json_decode($resultDao)->nr_cpf_usuario;
	    	$token = md5($cpf.time());
	    	$date = date("Y-m-d H:i:s");
	    	$params_token = [$id_user, $token, $date];
	    	$result_token = $this->dao->createToken($params_token);
	    	if(json_decode($result_token)->inserir_token_representante){
	    		//Mandar email Trocar Senha
	    		echo "Mandar email Trocar Senha";
	    	}else{
	    		echo "Email invalido!";
	    	}
    	}else{
    		echo "Email invalido!";
    	}
    }
    
    public function getEditais(){
    	$resultDao = $this->dao->getEditais();
    	$this->configResponse($resultDao);
    	return $this->response();
    }
}
