<?php

namespace App\Dao\Projeto;

use App\Dao\DaoPostgres;

class ProjetoDao extends DaoPostgres{
	public function obterProjetos($modelo){
		$modelo->tipo_identificador = 'id_' . $modelo->tipo_identificador;
    	
		$query = 'SELECT * FROM portal.obter_osc_projetos(?::TEXT, ?::TEXT, ?::INTEGER);';
		$params = [$modelo->id, $modelo->tipo_identificador, $modelo->tipo_resultado];
    	$result = $this->executarQuery($query, true, $params);
		
		if($modelo->tipo_identificador === 'id_projeto'){
			$result->resultado = '{"projeto": [' . $result->resultado . ']}';
		}

    	return $result;
	}

    public function editarProjetos($fonte, $identificador, $objeto){
    	$tipoIdentificador = 'id_osc';
    	$json = json_encode($objeto);
    	$nullValido = true;
    	$deleteValido = false;
    	$erroLog = true;
    	$idCarga = null;
    	$tipoBusca = 1;

    	$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $deleteValido, $erroLog, $idCarga, $tipoBusca];
    	$query = 'SELECT * FROM portal.atualizar_projetos_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER, ?::INTEGER)';
    	$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
	}

    public function deletarProjeto($identificador, $id_projeto){
		$fonte = 'Representante de OSC';
    	$tipoIdentificador = 'id_osc';
    	$erroLog = true;
    	$idCarga = null;
    	
    	$params = [$fonte, $identificador, $tipoIdentificador, $id_projeto, $erroLog, $idCarga];
    	$query = 'SELECT * FROM portal.deletar_projeto(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::INTEGER, ?::BOOLEAN, ?::INTEGER)';
    	$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
	}
}