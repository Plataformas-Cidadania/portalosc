<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller{
    public function getUser($id){
        $query = "SELECT * FROM portal.get_usuario(?::INTEGER);";
        $result = $this->executeQuery($query, true, $id);
        return $this->configResponse($result);
    }

    public function createUser($id){
        $email = $request->input('tx_email_usuario');
    	$senha = $request->input('tx_senha_usuario');
    	$nome = $request->input('tx_nome_usuario');
    	$cpf = $request->input('nr_cpf_usuario');
    	$lista_email = $request->input('bo_lista_email');
    	DB::insert('SELECT create_usuario(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN);', [$email, $senha, $nome, $cpf, $lista_email]);
    }

    public function updateUser(Request $request, $id){
        $email = $request->input('tx_email_usuario');
    	$senha = $request->input('tx_senha_usuario');
    	$nome = $request->input('tx_nome_usuario');
    	$cpf = $request->input('nr_cpf_usuario');
    	$lista_email = $request->input('bo_lista_email');
    	DB::insert('SELECT update_usuario(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN);', [$id, $email, $senha, $nome, $cpf, $lista_email]);
    }

    public function loginUser(Request $request)
    {
        return ['message' => 'ola mundo'];
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
