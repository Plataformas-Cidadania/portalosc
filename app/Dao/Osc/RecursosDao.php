<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class RecursosDao extends DaoPostgres{
    public function obterRecursos($modelo){
    	$result = array();
        
		$idOsc = $modelo->id_osc;
		
    	$query = 'SELECT * FROM portal.obter_osc_recursos(?::TEXT)';
		$params = [$idOsc];
		$result = $this->executarQuery($query, true, $params);
		
    	return $result;
    }
	
    public function editarRecursos($identificador, $modelo){
    	$fonte = 'Representante de OSC';
    	$tipoIdentificador = 'id_osc';
    	$json = json_encode($modelo);
    	$nullValido = true;
    	$deleteValido = true;
    	$erroLog = true;
    	$idCarga = null;
    	$tipoBusca = 2;
    	
    	$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $deleteValido, $erroLog, $idCarga, $tipoBusca];
    	
    	$query = 'SELECT * FROM portal.atualizar_recursos_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER, ?::INTEGER)';
    	$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
    }
}