<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class CertificadoOscDao extends DaoPostgres
{
    public function obterCertificado($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_certificado(?::TEXT);";
    	$result_query = $this->executarQuery($query, false, [$param]);
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
            return null;
        }else{
            return $result;
        }
    }
	
    public function editarCertificado($identificador, $modelo)
    {
    	$modeloDao = array();
    	
    	foreach($modelo as $certificado){
    		$certificadoDao['cd_certificado'] = isset($certificado->certificado) ? $certificado->certificado : null;
    		$certificadoDao['dt_inicio_certificado'] = isset($certificado->dataInicio) ? $certificado->dataInicio : null;
    		$certificadoDao['dt_fim_certificado'] = isset($certificado->dataFim) ? $certificado->dataFim : null;
    		$certificadoDao['cd_municipio'] = isset($certificado->municipio) ? $certificado->municipio : null;
    		$certificadoDao['cd_uf'] = isset($certificado->estado) ? $certificado->estado : null;
    		
    		array_push($modeloDao, $certificadoDao);
    	}
    	
    	$fonte = 'Representante de OSC';
    	$tipoIdentificador = 'id_osc';
    	$json = json_encode($modeloDao);
    	$nullValido = true;
    	$deleteValido = true;
    	$erroLog = true;
    	$idCarga = null;
    	$tipoBusca = 2;
    	
    	$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $deleteValido, $erroLog, $idCarga, $tipoBusca];
    	$query = 'SELECT * FROM portal.atualizar_certificado_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER, ?::INTEGER)';
    	$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
    }
}