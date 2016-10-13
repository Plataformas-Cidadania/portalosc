<?php

namespace App\Dao;

use App\Dao\Dao;

class UserDao extends Dao{
    public function getUser($id){
    	$result = array();

	    $query = "SELECT * FROM portal.obter_usuario(?::INTEGER);";
        $result_query = $this->executeQuery($query, true, [$id]);
        foreach(json_decode($result_query) as $key => $value){
        	$result = array_merge($result, [$key => $value]);
        }

        $query = "SELECT * FROM portal.obter_representacao(?::INTEGER);";
        $result_query = $this->executeQuery($query, false, [$id]);
    	$result = array_merge($result, ["representacao" => json_decode($result_query)]);

        return $result;
    }

    public function createUser($params){
    	$list_osc = array();
    	foreach($params[5] as $key=>$value) {
    		$id_osc = json_decode((json_encode($params[5][$key])))->id_osc;
    		array_push($list_osc, intval($id_osc));
    	}
    	$params[5] = '{'.implode(', ', $list_osc).'}';

        $query = 'SELECT * FROM portal.criar_usuario(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?, ?::TEXT);';
        $result_query = json_decode($this->executeQuery($query, true, $params));
        $nova_representacao = array();
       	if($result_query->nova_representacao){
	        foreach(explode(",", substr($result_query->nova_representacao, 1, -1)) as $id_osc){
	        	array_push($nova_representacao, ["id_osc" => $id_osc]);
	        };
	        $result_query->nova_representacao = $nova_representacao;
       	}
        return json_encode($result_query);
    }

    public function updateUser($params){
		$list_osc = array();
		foreach($params[6] as $key=>$value) {
			$id_osc = json_decode((json_encode($params[6][$key])))->id_osc;
			array_push($list_osc, intval($id_osc));
		}
        $params[6] = '{'.implode(', ', $list_osc).'}';

        $query = 'SELECT * FROM portal.atualizar_usuario(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?);';
        $result_query = json_decode($this->executeQuery($query, true, $params));
       	$nova_representacao = array();
       	if($result_query->nova_representacao){
	        foreach(explode(",", substr($result_query->nova_representacao, 1, -1)) as $id_osc){
	        	array_push($nova_representacao, ["id_osc" => $id_osc]);
	        };
	        $result_query->nova_representacao = $nova_representacao;
       	}
        return json_encode($result_query);
    }

    public function activateUser($params){
        $query = 'SELECT * FROM portal.ativar_usuario(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?::INTEGER, ?::TEXT);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }

    public function loginUser($params){
        $query = 'SELECT id_usuario, tx_nome_usuario FROM portal.tb_usuario WHERE tx_email_usuario = ?::TEXT AND tx_senha_usuario = ?::TEXT;';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }

    public function insertToken($params){
        $query = 'SELECT * FROM portal.inserir_token_usuario(?::INTEGER, ?::TEXT, 3);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }

    public function deleteToken($params){
        $query = 'DELETE FROM portal.tb_token WHERE id_usuario = ?::TEXT;';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }
}
