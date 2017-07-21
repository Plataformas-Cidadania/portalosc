<?php

namespace App\Dao;

use App\Dao\Dao;

class EditalDao extends Dao
{
	public function getEditais()
	{
		$result = array();
		
		$query = 'SELECT * FROM portal.obter_editais_ativos();';
		$result_query = $this->executeQuery($query, false, "");
		$result = array_merge($result, ["ativos" => $result_query]);
		
		$query = 'SELECT * FROM portal.obter_editais_encerrados();';
		$result_query = $this->executeQuery($query, false, "");
		$result = array_merge($result, ["encerrados" => $result_query]);

		return $result;
	}
	
	public function createEdital($params)
	{
		$query = 'SELECT * FROM portal.inserir_edital(?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::TEXT);';
		$result = $this->executeQuery($query, true, $params);
		return $result;
	}
}
