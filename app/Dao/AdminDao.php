<?php

namespace App\Dao;

use App\Dao\Dao;

class AdminDao extends Dao
{
	public function createEdital($params)
	{
		$query = 'SELECT * FROM portal.inserir_edital(?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::TEXT);';
		$result = $this->executeQuery($query, true, $params);
		return $result;
	}
}