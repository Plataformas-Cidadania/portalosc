<?php

namespace App\Dao;

use App\Dao\Dao;

class SearchDao extends Dao
{
	private $queriesLista = array(
		"osc" => ["SELECT * FROM portal.buscar_osc_lista(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
        "municipio" => ["SELECT * FROM portal.buscar_osc_municipio_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
        "estado" => ["SELECT * FROM portal.buscar_osc_estado_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
        "regiao" => ["SELECT * FROM portal.buscar_osc_regiao_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false]
    );

	private $queriesAutocomplete = array(
		"oscid" => ["SELECT id_osc,  tx_nome_osc||' ('||cd_identificador_osc||')' as tx_nome_osc FROM portal.buscar_osc(?::TEXT);", false],
		//"oscid" => ["SELECT id_osc,  tx_nome_osc||' ('||cd_identificador_osc||')' as tx_nome_osc FROM portal.buscar_osc_por_cnpj(?::NUMERIC);", false],
		"osc" => ["SELECT * FROM portal.buscar_osc_autocomplete(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
		"municipio" => ["SELECT * FROM portal.buscar_osc_municipio_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"estado" => ["SELECT * FROM portal.buscar_osc_estado_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"regiao" => ["SELECT * FROM portal.buscar_osc_regiao_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false]
	);

	private $queriesGeo = array(
		"osc" => ["SELECT * FROM portal.buscar_osc_geo(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
		"municipio" => ["SELECT * FROM portal.buscar_osc_municipio_geo(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"estado" => ["SELECT * FROM portal.buscar_osc_estado_geo(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"regiao" => ["SELECT * FROM portal.buscar_osc_regiao_geo(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false]
	);

	private function configResultGeo($result){
		$json = [[]];

		for ($i = 0; $i<count($result); $i++) {
			//print_r($result[$i]->geo_lat);
			$json[$result[$i]->id_osc][0] = $result[$i]->geo_lat;//lat
			$json[$result[$i]->id_osc][1] = $result[$i]->geo_lng;//lng
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
			//$json[$result[$i]->id_osc][4] = $result[$i]->imagemOsc;
		}

		return $json;
	}

    public function searchOsc($type_search, $type_result, $param = null)
    {
    	$queries = array();

		if(!$param[0]){
			if($type_result == 'lista'){
				$query_var = 'vw_busca_resultado.id_osc, vw_busca_resultado.tx_nome_osc, vw_busca_resultado.cd_identificador_osc, vw_busca_resultado.tx_natureza_juridica_osc, vw_busca_resultado.tx_endereco_osc, vw_busca_resultado.tx_nome_atividade_economica ';
				$query_ext = 'ORDER BY vw_busca_resultado.tx_nome_osc ';
			}
			else if($type_result == 'autocomplete'){
				$query_var = 'LOWER(vw_busca_resultado.tx_nome_osc) AS tx_nome_osc ';
				$query_ext = 'ORDER BY tx_nome_osc ';
			}
			else if($type_result == 'geo'){
				$query_var = 'vw_busca_resultado.id_osc, vw_busca_resultado.geo_lat, vw_busca_resultado.geo_lng ';
				$query_ext = 'GROUP BY LOWER(vw_busca_resultado.tx_nome_osc) ';
			}

			$query = 'SELECT ' . $query_var . 'FROM portal.vw_busca_resultado ' . $query_ext;

			if($param[2] > 0){
				$query_limit = 'LIMIT ' . $param[1] . ' OFFSET ' . $param[2] . ';';
			}
			else if($param[1] > 0){
				$query_limit = 'LIMIT ' . $param[1] . ';';
			}
			else{
				$query_limit = ';';
			}

			$query .= $query_limit;
			$result = $this->executeQuery($query, false);
		}
		else{
	    	if($type_result == 'lista'){
				$queries = $this->queriesLista;
	    	}
	    	else if($type_result == 'autocomplete'){
	    		$queries = $this->queriesAutocomplete;
	    	}
	    	else if($type_result == 'geo'){
		    	$queries = $this->queriesGeo;
	    	}

			if(array_key_exists($type_search, $queries)){
				$query_info = $queries[$type_search];
				$query = $query_info[0];
				$unique = $query_info[1];

				$result = $this->executeQuery($query, $unique, $param);
			}
			else{
				$result = null;
			}

			if($type_result == 'lista'){
				$result = $this->configResultLista($result);
			}
			if($type_result == 'geo'){
				$result = $this->configResultGeo($result);
			}
		}

    	return $result;
	}
}
