<?php

namespace App\Http\Dao\User;

use App\Http\Dao\Dao;

class GetUserGovDao extends Dao
{	
	public function run($object)
	{
		$result = array();
		
		$query = 'SELECT * FROM portal.tb_usuario WHERE id_usuario = ?::INTEGER AND (cd_tipo_usuario = 3 OR cd_tipo_usuario = 4);';
		$params = [$object['id_usuario']];
		$resultQuery = $this->execute($query, true, $params);
		
		return $result;
	}
}