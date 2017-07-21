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

        if($result_query){
            foreach($result_query as $key => $value){
            	$result = array_merge($result, [$key => $value]);
            }

            $query = "SELECT * FROM portal.obter_representacao(?::INTEGER);";
            $result_query = $this->executeQuery($query, false, [$param]);
        	$result = array_merge($result, ["representacao" => $result_query]);
        }

        return $result;
    }

    public function createUserOsc($params)
    {
    	if($params[5] != null){
    		$list_osc = array();
	        foreach($params[5] as $key => $value) {
	        	$id_osc = $value['id_osc'];
	        	array_push($list_osc, intval($id_osc));
	        }
	    	$params[5] = '{'.implode(', ', $list_osc).'}';
    	}else{
    		$params[5] = '{}';
    	}

        $query = 'SELECT * FROM portal.inserir_representante(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?::INTEGER[], ?::TEXT);';
        $result_query = $this->executeQuery($query, true, $params);

        return $result_query;
    }
	
    public function createUserGov($object)
    {
    	$params = [$object['tipo_usuario'], $object['email'], $object['senha'], $object['nome'], $object['cpf'], $object['localidade'], $object['lista_email'], $object['token']];
    	
        $query = 'SELECT * FROM portal.inserir_representante_governo(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::INTEGER, ?::BOOLEAN, ?::TEXT);';
        $result_query = $this->executeQuery($query, true, $params);
		
        return $result_query;
    }
	
    public function updateUser($params)
    {
        $list_osc = array();
		
        foreach($params[4] as $key => $value) {
        	$id_osc = $value['id_osc'];
        	array_push($list_osc, intval($id_osc));
        }
        
        $params[4] = '{'.implode(',', $list_osc).'}';
        
        $query = 'SELECT * FROM portal.atualizar_representante(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?);';
        $result_query = $this->executeQuery($query, true, $params);
		
       	$nova_representacao = array();
       	if($result_query->nova_representacao){
	        foreach(explode(",", substr($result_query->nova_representacao, 1, -1)) as $id_osc){
	        	array_push($nova_representacao, ["id_osc" => $id_osc]);
	        };
	        $result_query->nova_representacao = $nova_representacao;
       	}
		
        return $result_query;
    }
	
    public function activateUser($params)
    {
        $query = 'SELECT * FROM portal.ativar_representante(?::INTEGER);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }
    
    public function activateUserGov($params)
    {
    	$query = 'SELECT * FROM portal.ativar_representante_governo(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
	
    public function loginUser($params)
    {
        $result = array();
		
        $query = 'SELECT 
						tb_usuario.id_usuario, 
						tb_usuario.cd_tipo_usuario, 
						tb_usuario.tx_nome_usuario, 
        				tb_usuario.cd_municipio, 
        				tb_usuario.cd_uf, 
						tb_usuario.bo_ativo 
					FROM 
						portal.tb_usuario 
					WHERE 
						tx_email_usuario = ?::TEXT AND 
						tx_senha_usuario = ?::TEXT;';
        $result_query = $this->executeQuery($query, true, $params);
		
        if($result_query){
            foreach($result_query as $key => $value){
                $result = array_merge($result, [$key => $value]);
            }
			
            $representacao = ['representacao' => null];
            if($result_query->cd_tipo_usuario == 2){
                $query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
                $result_query = $this->executeQuery($query, false, [$result['id_usuario']]);
				
                $string_representacao = '';
                foreach($result_query as $value){
                    $string_representacao = $string_representacao.$value->id_osc.',';
                }
                $string_representacao = rtrim($string_representacao, ",");
                $representacao = ['representacao' => $string_representacao];
            }
            $result = array_merge($result, $representacao);
        }
		
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

    public function obterIdToken($params)
    {
    	$query = 'SELECT * FROM portal.tb_token WHERE tx_token = ?::TEXT;';
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
    	$query = 'SELECT id_usuario, nr_cpf_usuario, tx_nome_usuario, bo_ativo FROM portal.tb_usuario WHERE tx_email_usuario = (?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
	
    public function createToken($params)
    {
    	$query = 'SELECT * FROM portal.inserir_token_usuario(?::INTEGER, ?::TEXT, ?::DATE);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
	
    public function getOscEmail($params)
    {
    	$query = 'SELECT tx_razao_social_osc, tx_email FROM portal.obter_osc_dados_gerais(?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
	
    public function getUserEmail($params)
    {
    	$query = 'SELECT tx_nome_usuario, tx_email_usuario FROM portal.obter_representante(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
	
    public function getUserCpf($params)
    {
    	$query = 'SELECT nr_cpf_usuario FROM portal.obter_representante(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
	
    public function createSubscriber($params){
        $query = 'SELECT * FROM portal.inserir_assinante(?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
}