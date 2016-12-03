<?php

namespace App\Dao;

use App\Dao\Dao;

class HistoryDao extends Dao
{
	public function insertLogUpdateData($params)
	{
		$query = 'INSERT INTO log.tb_log_alteracao(tx_nome_tabela, tx_nome_campo, id_tabela, id_usuario, dt_alteracao, tx_dado_anterior, tx_dado_posterior)
					VALUES (?::TEXT, ?::TEXT, ?::INTEGER, ?::INTEGER, ?::DATE, ?::TEXT, ?::TEXT);';
		$result = $this->executeQuery($query, true, $params);
		return $result;
	}
}
