<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class DescricaoDao extends DaoPostgres{
    public function obterDescricao($param){
    	$result = array();
    	
        $query = 'SELECT * FROM portal.obter_osc_descricao(?::TEXT);';
        $result = $this->executarQuery($query, true, [$param]);
        
        return $result;
    }
	
    public function editarDescricao($identificador, $modelo){
    	$fonte = 'Representante de OSC';
		$tipoIdentificador = 'id_osc';
    	$json = json_encode($modelo);
		$nullValido = true;
    	$erroLog = true;
		$idCarga = null;
		
		$query = 'SELECT * FROM portal.atualizar_descricao_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER)';
		$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $erroLog, $idCarga];
		$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
    }
}