<?php

namespace App\Dao;

use App\Dao\Dao;

class LogDao extends Dao
{

	public function insertLogOsc($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior)
	{
		$dt_alteracao = date("Y-m-d H:i:s");
		$tx_nome_tabela = 'osc.tb_osc';

		$params = [$dt_alteracao, $tx_nome_tabela, $tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior];

		$this->insertLog($params);
	}

	public function insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior)
	{
		$dt_alteracao = date("Y-m-d H:i:s");
		$tx_nome_tabela = 'osc.tb_dados_gerais';

		$params = [$dt_alteracao, $tx_nome_tabela, $tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior];

		$this->insertLog($params);
	}

	public function insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior)
	{
		$dt_alteracao = date("Y-m-d H:i:s");
		$tx_nome_tabela = 'osc.tb_contato';

		$params = [$dt_alteracao, $tx_nome_tabela, $tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior];

		$this->insertLog($params);
	}

	public function insertLog($params)
	{
		$query = 'INSERT INTO log.tb_log_alteracao2(tx_nome_tabela, id_tabela, id_usuario, dt_alteracao, tx_dado_anterior, tx_dado_posterior)
				  VALUES (?::TEXT, ?::INTEGER, ?::INTEGER, ?::DATE, ?::JSON, ?::JSON);';
		$result = $this->executeQuery($query, true, $params);
		return $result;
	}
}