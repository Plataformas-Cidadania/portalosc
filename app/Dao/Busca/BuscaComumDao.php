<?php

namespace App\Dao\Busca;

use App\Dao\DaoPostgres;

class BuscaComumDao extends DaoPostgres{
    private function configResultGeo($result){
		$json = [[]];
		
		for ($i = 0; $i<count($result); $i++) {
			$json[$result[$i]->id_osc][0] = $result[$i]->geo_lat;
			$json[$result[$i]->id_osc][1] = $result[$i]->geo_lng;
		}
		
		return $json;
	}
	
	private function configResultLista($result){
		$json = [[]];
		
		for ($i = 0; $i<count($result); $i++) {
			$json[$result[$i]->id_osc][0] = $result[$i]->tx_nome_osc;
			$json[$result[$i]->id_osc][1] = $result[$i]->cd_identificador_osc;
			$json[$result[$i]->id_osc][2] = $result[$i]->tx_natureza_juridica_osc;
			$json[$result[$i]->id_osc][3] = $result[$i]->tx_endereco_osc;
			$json[$result[$i]->id_osc][4] = $result[$i]->im_logo;
		}
		
		return $json;
    }
    
    public function obterBusca($modelo){
    	$result = array();
        
        $queries = array();
        if($modelo->tipoResultado == 'lista'){
			$queries = [
                'osc' => ['SELECT * FROM portal.buscar_osc_lista(?::TEXT, ?::INTEGER, ?::INTEGER, ?::INTEGER);', false],
                'municipio' => ['SELECT * FROM portal.buscar_osc_municipio_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);', false],
                'estado' => ['SELECT * FROM portal.buscar_osc_estado_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);', false],
                'regiao' => ['SELECT * FROM portal.buscar_osc_regiao_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);', false]
            ];
		}else if($modelo->tipoResultado == 'autocomplete'){
			$queries = [
                'cnpj' => ['SELECT * FROM portal.buscar_osc_cnpj(?::TEXT, ?::INTEGER, ?::INTEGER);', false],
                'osc' => ['SELECT * FROM portal.buscar_osc_autocomplete(?::TEXT, ?::INTEGER, ?::INTEGER, ?::INTEGER);', false],
                'municipio' => ['SELECT * FROM portal.buscar_osc_municipio_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);', false],
                'estado' => ['SELECT * FROM portal.buscar_osc_estado_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);', false],
                'regiao' => ['SELECT * FROM portal.buscar_osc_regiao_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);', false],
                'atividade_economica' => ['SELECT * FROM portal.obter_atividade_economica(?::TEXT, ?::INTEGER, ?::INTEGER);', false]
            ];
		}else if($modelo->tipoResultado == 'geo'){
			$queries = [
                'osc' => ['SELECT * FROM portal.buscar_osc_geo(?::TEXT, ?::INTEGER, ?::INTEGER, ?::INTEGER);', false],
                'municipio' => ['SELECT * FROM portal.buscar_osc_municipio_geo(?::NUMERIC, ?::INTEGER, ?::INTEGER);', false],
                'estado' => ['SELECT * FROM portal.buscar_osc_estado_geo(?::NUMERIC, ?::INTEGER, ?::INTEGER);', false],
                'regiao' => ['SELECT * FROM portal.buscar_osc_regiao_geo(?::NUMERIC, ?::INTEGER, ?::INTEGER);', false]
            ];
        }
        
        if(array_key_exists($modelo->recurso, $queries)){
			$parametrosQuery = $queries[$modelo->recurso];
			$query = $parametrosQuery[0];
			$unique = $parametrosQuery[1];
            
            $parametros = [$modelo->parametro, $modelo->limite, $modelo->deslocamento, $modelo->tipoBusca];
            $result = $this->executarQuery($query, $unique, $parametros);
            
            if($modelo->tipoResultado  == 'lista'){
                $result = $this->configResultLista($result);
            }else if($modelo->tipoResultado  == 'geo'){
                $result = $this->configResultGeo($result);
            }
		}
        
        return $result;
    }
}