<?php

namespace App\Dao;

use App\Dao\Dao;

class EditalDao extends Dao
{
	public function obterEditaisAbertos()
	{
		$query = 'SELECT * FROM portal.obter_editais_ativos();';
		return $this->executarQuery($query, false, null);
	}
	
	public function obterEditaisEncerrados()
	{
		$query = 'SELECT * FROM portal.obter_editais_encerrados();';
		return $this->executarQuery($query, false, null);
	}
	
	public function criarEdital($edital)
	{
		$query = 'SELECT * FROM portal.inserir_edital(?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::TEXT);';
		$params = [$edital->tx_orgao, $edital->tx_programa, $edital->tx_area_interesse_edital, $edital->dt_vencimento, $edital->tx_link_edital, $edital->tx_numero_chamada];
		return $this->executarQuery($query, true, $params);
	}
}