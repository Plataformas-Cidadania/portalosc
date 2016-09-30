<?php

namespace App\Dao;

use App\Dao\Dao;

class UserDao extends Dao
{
    public function getUser($id)
	{
	    $query = "SELECT * FROM portal.get_user(?::INTEGER);";
        $result = json_decode($this->executeSelectQuery($query, false, [$id]));
        return $result;
    }

    public function createUser($params)
	{
    	$params[5] = '{'.implode(', ', $params[5]).'}';
        $query = 'SELECT portal.create_user(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?, ?::TEXT);';
        $result_query = $this->executeQuery($query, true, $params);
        $result = json_encode(explode(",", substr(json_decode($result_query)->create_user, 1, -1)));
        return $result;
    }

    public function updateUser($params)
	{
        $query = 'SELECT portal.update_user(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }

    public function activateUser($params)
	{
        $query = 'SELECT portal.activate_user(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?::INTEGER, ?::TEXT);';
        $result = $this->executeQuery($query, true, $params);
        return $result;
    }
}
