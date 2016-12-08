<?php

namespace App\Dao;

use App\Dao\Dao;

class SearchDao extends Dao
{
	private $queriesLista = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
		    "osc" => ["SELECT * FROM portal.buscar_osc_lista(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
        "municipio" => ["SELECT * FROM portal.buscar_osc_municipio_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
        "estado" => ["SELECT * FROM portal.buscar_osc_estado_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
        "regiao" => ["SELECT * FROM portal.buscar_osc_regiao_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false]
    );

	private $queriesAutocomplete = array(
			/* Estrutura: nome_componente => [query_sql, is_unique] */
			"oscid" => ["SELECT id_osc,  tx_nome_osc||' ('||cd_identificador_osc||')' as tx_nome_osc FROM portal.buscar_osc(?::TEXT);", false],
			"osc" => ["SELECT * FROM portal.buscar_osc_autocomplete(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
			"municipio" => ["SELECT * FROM portal.buscar_osc_municipio_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
			"estado" => ["SELECT * FROM portal.buscar_osc_estado_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
			"regiao" => ["SELECT * FROM portal.buscar_osc_regiao_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false]
	);

	private $queriesGeo = array(
			/* Estrutura: nome_componente => [query_sql, is_unique] */
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
      }else{
          $result = null;
      }

			if($type_result == 'lista'){
				$result = $this->configResultLista($result);
			}
			if($type_result == 'geo'){
				$result = $this->configResultGeo($result);
			}

        return $result;
    }
}
