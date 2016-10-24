<?php

namespace App\Dao;

use App\Dao\Dao;

class UserDao extends Dao
{
    public function getUser($param)
    {
    	$result = array();

	    $query = "SELECT * FROM portal.obter_representante(?::INTEGER);";
        $result_query = $this->executeQuery($query, true, [$param]);
        foreach(json_decode($result_query) as $key => $value){
        	$result = array_merge($result, [$key => $value]);
        }

        $query = "SELECT * FROM portal.obter_representacao(?::INTEGER);";
        $result_query = $this->executeQuery($query, false, [$param]);
    	$result = array_merge($result, ["representacao" => json_decode($result_query)]);

        return $result;
    }

    public function createUser($params)
    {
    	$list_osc = array();
    	foreach($params[5] as $key=>$value) {
    		$id_osc = json_decode((json_encode($params[5][$key])))->id_osc;
    		array_push($list_osc, intval($id_osc));
    	}
    	$params[5] = '{'.implode(', ', $list_osc).'}';

        $query = 'SELECT * FROM portal.criar_representante(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?, ?::TEXT);';
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

    public function updateUser($params)
    {
		$list_osc = array();
		foreach($params[6] as $key=>$value) {
			$id_osc = json_decode((json_encode($params[6][$key])))->id_osc;
			array_push($list_osc, intval($id_osc));
		}
        $params[6] = '{'.implode(', ', $list_osc).'}';

        $query = 'SELECT * FROM portal.atualizar_representante(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?);';
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

    public function activateUser($params)
    {
        $query = 'SELECT * FROM portal.ativar_representante(?::INTEGER);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }

    public function loginUser($params)
    {
        $query = 'SELECT * FROM portal.logar_representante(?::TEXT, ?::TEXT);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }

    public function insertToken($params)
    {
        $query = 'SELECT * FROM portal.inserir_token_representante(?::INTEGER, ?::TEXT, 3);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }

    public function deleteToken($params)
    {
        $query = 'SELECT * FROM portal.excluir_token_representante(?::INTEGER);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }
    
    public function validateToken($params)
    {
    	$query = 'SELECT * FROM portal.obter_token_representante(?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
    
    public function updatePassword($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_senha(?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
    
    public function getUserChangePassword($params)
    {
    	$query = 'SELECT id_usuario, nr_cpf_usuario FROM portal.tb_usuario WHERE tx_email_usuario = ?::TEXT;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
    
    public function createToken($params)
    {
    	$query = 'SELECT * FROM portal.inserir_token_representante(?::INTEGER, ?::TEXT, ?::DATE);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
    
    public function getEditais()
    {
    	$result = array();
    	
    	$query = 'SELECT * FROM portal.obter_editais_ativos();';
    	$result_query = $this->executeQuery($query, false, "");
    	$result = array_merge($result, ["ativos" => json_decode($result_query)]);
    	
    	$query = 'SELECT * FROM portal.obter_editais_encerrados();';
    	$result_query = $this->executeQuery($query, false, "");
    	$result = array_merge($result, ["encerrados" => json_decode($result_query)]);
    	
    	return $result;
    }
    
    public function getOscEmail($params)
    {
    	$query = 'SELECT tx_razao_social_osc, tx_email FROM portal.vw_osc_dados_gerais WHERE id_osc = (?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
}
