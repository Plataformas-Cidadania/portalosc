<?php

namespace App\Dao\Edital;

use App\Dao\DaoPostgres;

class EditalDao extends DaoPostgres
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
		$params = [$edital->tx_orgao, $edital->tx_programa, $edital->tx_area_interesse, $edital->dt_data_vencimento, $edital->tx_link, $edital->tx_numero_chamada];
		return $this->executarQuery($query, true, $params);
	}
}
