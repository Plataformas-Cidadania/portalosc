<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dao\UserDao;

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
        $token = sha1($cpf.time());
        
		$params = [$email, $senha, $nome, $cpf, $lista_email, $representacao, $token];
		$resultDao = json_decode($this->dao->createUser($params));
		if($resultDao->nova_representacao){
			foreach($resultDao->nova_representacao as $key=>$value) {
				$id = $resultDao->nova_representacao[$key]->id_osc;
				// Mandar email para $id
			}
		}
		
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
    	$resultDao = json_decode($this->dao->updateUser($params));
		if($resultDao->nova_representacao){
			foreach($resultDao->nova_representacao as $key=>$value) {
				$id = $resultDao->nova_representacao[$key]->id_osc;
				// Mandar email para $id
			}
		}
		
    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

    public function loginUser(Request $request){
        return ['message' => 'loginUser'];
        /*
        $email = $request->input('tx_email_usuario');
    	$senha = $request->input('tx_senha_usuario');
        $resultQuery = DB::select('SELECT id_usuario, tx_nome_usuario FROM portal.tb_usuario WHERE tx_email_usuario = ?::TEXT AND tx_senha_usuario = ?::TEXT;', [$email, $senha]);
        if($resultQuery){

        }
        return $resultQuery;
        */
    }

    public function logoutUser(){
        return ['message' => 'logoutUser'];
    }
}
