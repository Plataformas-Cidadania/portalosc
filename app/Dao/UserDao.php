<?php

namespace App\Dao;

use App\Dao\Dao;

class UserDao extends Dao
{
    public function getUser($id)
	{
        echo $id;
	    $query = "SELECT * FROM portal.get_user(?::INTEGER);";
        $result = json_decode($this->executeSelectQuery($query, false, [$id]));
        return $result;
    }

    public function createUser($params)
	{
        $query = 'SELECT portal.create_user(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?::INTEGER, ?::TEXT);';
        $this->executeInsertQuery($query, $params);
        return $result;
    }

    public function updateUser($params)
	{
        $query = 'SELECT portal.update_user(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN);';
        $this->executeInsertQuery($query, $params);

        $query = 'SELECT portal.update_user_representation(?::INTEGER, ?::INTEGER);';
        $this->executeInsertQuery($query, $params);

        return $result;
    }

    public function activateUser($params)
	{
        $query = 'SELECT portal.activate_user(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?::INTEGER, ?::TEXT);';
        $this->executeInsertQuery($query, $params);
        return $result;
    }
}
