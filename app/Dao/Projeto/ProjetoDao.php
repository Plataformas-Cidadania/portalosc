<?php

namespace App\Dao\Projeto;

use App\Dao\DaoPostgres;

class ProjetoDao extends DaoPostgres
{
    public function editarProjetos($fonte, $identificador, $objeto)
    {
    	$tipoIdentificador = 'id_osc';
    	$json = json_encode($objeto);
    	$nullValido = true;
    	$deleteValido = true;
    	$erroLog = true;
    	$idCarga = null;
    	$tipoBusca = 1;
    	
    	$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $deleteValido, $erroLog, $idCarga, $tipoBusca];
    	$query = 'SELECT * FROM portal.atualizar_projetos_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER, ?::INTEGER)';
    	$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
    }
}