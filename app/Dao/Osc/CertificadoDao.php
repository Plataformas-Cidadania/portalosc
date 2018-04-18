<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class CertificadoDao extends DaoPostgres{
    public function obterCertificados($modelo){
		$result = array();
		
		$query = "SELECT * FROM portal.obter_osc_certificado(?::TEXT);";
		$params = [$modelo->id_osc];
    	$result_query = $this->executarQuery($query, false, $params);
    	$nao_possui = false;
    	$json = array(); 
		
    	if($result_query){
	    	foreach($result_query as $key => $value){
	    		$cd_certificado = $value->cd_certificado;
	    		if($cd_certificado == 9){
	    			$nao_possui = true;
	    		}else{
	    			array_push($json, $result_query[$key]);
	    		}
	    	}
	    	
	    	if(count($json) == 0){
	    		$result = array_merge($result, ["certificado" => null, "bo_nao_possui_certificacoes" => $nao_possui]);
	    	}else{
	    		$nao_possui = false;
	    		$result = array_merge($result, ["certificado" => $json, "bo_nao_possui_certificacoes" => $nao_possui]);
	    	}
    	}
    	
        if(count($result) == 0){
            $result = null;
		}
		
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
    	$tipoBusca = 2;
    	
		$query = 'SELECT * FROM portal.atualizar_certificado_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER, ?::INTEGER)';
		$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $deleteValido, $erroLog, $idCarga, $tipoBusca];
    	$result = $this->executarQuery($query, true, $params);
		
    	return $result;
    }
}