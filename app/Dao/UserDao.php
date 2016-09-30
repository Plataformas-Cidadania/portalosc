<?php

namespace App\Dao;

use App\Dao\Dao;

class UserDao extends Dao
{
    public function getUser($id)
	{
    	$result = array();
    	
	    $query = "SELECT * FROM portal.obter_usuario(?::INTEGER);";
        $result_query = $this->executeQuery($query, true, [$id]);
        foreach(json_decode($result_query) as $key => $value){
        	$result = array_merge($result, [$key => $value]);
        }
    	
        $query = "select * from portal.obter_representacao(?::INTEGER);";
        $result_query = $this->executeQuery($query, false, [$id]);
    	$result = array_merge($result, ["representacao" => json_decode($result_query)]);
    	
        return $result;
    }

    public function createUser($params)
	{
    	$params[5] = '{'.implode(', ', $params[5]).'}';
        $query = 'SELECT portal.criar_usuario(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?, ?::TEXT);';
        $result_query = $this->executeQuery($query, true, $params);
        $list_id = array();
        foreach(explode(",", substr(json_decode($result_query)->create_user, 1, -1)) as $id_osc){
        	array_push($list_id, ["id_osc" => $id_osc]);
        };
        return json_encode(["nova_representacao" => $list_id]);
    }

    public function updateUser($params)
	{
        $query = 'SELECT portal.atualizar_usuario(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }

    public function activateUser($params)
	{
        $query = 'SELECT portal.ativar_usuario(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?::INTEGER, ?::TEXT);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }
}
