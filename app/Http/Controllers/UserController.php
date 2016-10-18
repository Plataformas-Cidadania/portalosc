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
		$id = trim(urldecode($id));
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
		$message = $this->email->confirmation($nome, $token);
		$this->email->send($email, $nome, "Confirmação de Cadastro Mapa das Organizações da Sociedade Civil", $message);

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
			if($this->dao->insertToken([$id_usuario, $token])){
				$result = ['id_usuario' => $id_usuario,
							'tx_nome_usuario' => $tx_nome_usuario,
							'access_token' => $token,
							'token_type' => 'Bearer',
							'expires_in' => $time_expires];
			}
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
}
