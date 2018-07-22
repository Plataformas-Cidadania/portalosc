<?php

namespace App\Dao\Projeto;

use App\Dao\DaoPostgres;

class ProjetoDao extends DaoPostgres{
	public function obterProjetos($modelo){
    	$tipoResultado = 1;
    	
		$query = 'SELECT * FROM portal.obter_osc_projetos(?::TEXT, ?::INTEGER);';
		$params = [$modelo->id_osc, $tipoResultado];
    	$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
	}

	public function obterProjetosAbreviados($modelo){
    	$tipoResultado = 2;
    	
		$query = 'SELECT * FROM portal.obter_osc_projetos(?::TEXT, ?::INTEGER);';
		$params = [$modelo->id_osc, $tipoResultado];
    	$result = $this->executarQuery($query, true, $params);
    	
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
    	print_r($params);
    	return $result;
	}

    public function deletarProjeto($fonte, $identificador, $id){
    	$tipoIdentificador = 'id_osc';
    	$json = json_encode($id);
    	$erroLog = true;
    	$idCarga = null;
    	
    	$params = [$fonte, $identificador, $tipoIdentificador, $id, $erroLog, $idCarga];
    	$query = 'SELECT * FROM portal.deletar_projeto(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::INTEGER, ?::BOOLEAN, ?::INTEGER)';
    	$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
	}
}