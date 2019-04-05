<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class CertificadoDao extends DaoPostgres{
    public function obterCertificados($modelo){
		$result = array();
		
		$query = "SELECT * FROM portal.obter_osc_certificado(?::TEXT);";
		$params = [$modelo->id_osc];
        $result = $this->executarQuery($query, true, $params);
        
        return $result;
    }
	
    public function editarCertificado($identificador, $modelo){
    	$fonte = 'Representante de OSC';
    	$tipoIdentificador = 'id_osc';
    	$json = json_encode($modelo);
    	$nullValido = true;
    	$deleteValido = true;
    	$erroLog = true;
    	$idCarga = null;
    	$tipoBusca = 3;
    	
		$query = 'SELECT * FROM portal.atualizar_certificado_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER, ?::INTEGER)';
		$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $deleteValido, $erroLog, $idCarga, $tipoBusca];
    	$result = $this->executarQuery($query, true, $params);
		
    	return $result;
    }
}