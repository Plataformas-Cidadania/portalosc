<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dao\UserDao;

class UserController extends Controller
{
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
    	$result = '';
    	
        $email = $request->input('tx_email_usuario');
    	$senha = $request->input('tx_senha_usuario');
    	$nome = $request->input('tx_nome_usuario');
    	$cpf = $request->input('nr_cpf_usuario');
    	$lista_email = $request->input('bo_lista_email');
    	$representacao = $request->input('representacao');
    	
    	$list_osc = array();
    	foreach($representacao as $key=>$value) {
    		$id_osc = json_decode((json_encode($representacao[$key])))->id_osc;
    		array_push($list_osc, intval($id_osc));
    	}
        
        $token = sha1($cpf.time());
        
		$params = [$email, $senha, $nome, $cpf, $lista_email, $list_osc, $token];
		
		$resultDao = $this->dao->createUser($params);
		if($resultDao){
			$nova_representacao = json_decode($resultDao)->nova_representacao;
			foreach($nova_representacao as $key=>$value) {
				$id = $nova_representacao[$key]->id_osc;
				// Mandar email para $id
			}
			$result = ['msg' => 'Usuário criado'];
		}
		$this->configResponse($result);
        return $this->response();
    }

    public function updateUser(Request $request, $id){
        $email = $request->input('tx_email_usuario');
    	$senha = $request->input('tx_senha_usuario');
    	$nome = $request->input('tx_nome_usuario');
    	$cpf = $request->input('nr_cpf_usuario');
    	$lista_email = $request->input('bo_lista_email');
    	$query = 'SELECT portal.update_usuario(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN);';
        $this->executeInsertQuery($query, [$id, $email, $senha, $nome, $cpf, $lista_email]);
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
