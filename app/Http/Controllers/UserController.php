<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dao\UserDao;
use Mail;

class UserController extends Controller{
	private $dao;

	public function __construct() {
		$this->dao = new UserDao();
	}

    public function getUser($id){
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
		// Mandar email para usuario

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

        $paramsHeader = [];

        if($resultDao){
			$id_usuario = json_decode($resultDao)->id_usuario;
			$token = sha1($id_usuario.time());

			$params = [$id_usuario, $token];
			if($this->dao->insertToken([$id_usuario, $token])){
				$paramsHeader = ['Api-Token' => $token, 'User' => $id_usuario];
			}else{
				$resultDao = 'Ocorreu um erro';
			}
        }else{
			$resultDao = 'E-mail e/ou senha inválido';
		}
    	$this->configResponse($resultDao);
        return $this->response($paramsHeader);
    }

    public function logoutUser($id){
		$params = [$id];
        $resultDao = $this->dao->deleteToken($params);
		$this->configResponse($resultDao);
        return $this->response();
    }
}
