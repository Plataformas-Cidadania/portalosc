<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class DadosGeraisOscDao extends DaoPostgres
{
    public function obterDadosGerais($param)
    {
    	$result = array();
    	
        $query = "SELECT * FROM portal.obter_osc_dados_gerais(?::TEXT);";
        $result = $this->executarQuery($query, true, [$param]);
        
        $query = "SELECT id_objetivo_osc, cd_objetivo_osc, tx_nome_objetivo_osc, cd_meta_osc, tx_nome_meta_osc, ft_objetivo_osc 
        			FROM portal.vw_osc_objetivo_osc WHERE id_osc = ?::INTEGER;";
        $objetivos = $this->executarQuery($query, false, [$param]);
        
        $result = array_merge((array) $result, ['objetivo_metas' => $objetivos]);
        
        return $result;
    }
	
    public function editarDadosGerais($identificador, $modelo)
    {
    	$fonte = 'Representante de OSC';
		$tipoIdentificador = 'id_osc';
    	$json = json_encode($modelo);
		$nullValido = true;
		$deleteValido = true;
    	$erroLog = true;
		$idCarga = null;
		$tipoBusca = 2;
		
		$query = 'SELECT * FROM portal.atualizar_dados_gerais_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER, ?::INTEGER)';
		$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $deleteValido, $erroLog, $idCarga, $tipoBusca];
		$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
    }
}
