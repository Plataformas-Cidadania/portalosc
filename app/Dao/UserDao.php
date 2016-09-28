<?php

namespace App\Dao;

use App\Dao\Dao;

class UserDao extends Dao
{
    public function getUser($id)
	{
	    $query = "SELECT * FROM portal.get_usuario(?::INTEGER);";
        $result = json_decode($this->executeSelectQuery($query, false, [$id]));
        return $result;
    }
}
