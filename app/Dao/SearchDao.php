<?php

namespace App\Dao;

use App\Dao\Dao;

class SearchDao extends Dao
{
	private $queriesLista = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
		"osc" => ["SELECT * FROM portal.buscar_osc_lista(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
        "municipio" => ["SELECT * FROM portal.buscar_osc_municipio_lista(?::NUMERIC);", false],
        "estado" => ["SELECT * FROM portal.buscar_osc_estado_lista(?::NUMERIC);", false],
        "regiao" => ["SELECT * FROM portal.buscar_osc_regiao_lista(?::NUMERIC);", false]
    );

	private $queriesAutocomplete = array(
			/* Estrutura: nome_componente => [query_sql, is_unique] */
			"osc" => ["SELECT * FROM portal.buscar_osc_autocomplete(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
			"municipio" => ["SELECT * FROM portal.buscar_osc_municipio_autocomplete(?::NUMERIC);", false],
			"estado" => ["SELECT * FROM portal.buscar_osc_estado_autocomplete(?::NUMERIC);", false],
			"regiao" => ["SELECT * FROM portal.buscar_osc_regiao_autocomplete(?::NUMERIC);", false]
	);

	private $queriesGeo = array(
			/* Estrutura: nome_componente => [query_sql, is_unique] */
			"osc" => ["SELECT * FROM portal.buscar_osc_geo(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
			"municipio" => ["SELECT * FROM portal.buscar_osc_municipio_geo(?::NUMERIC);", false],
			"estado" => ["SELECT * FROM portal.buscar_osc_estado_geo(?::NUMERIC);", false],
			"regiao" => ["SELECT * FROM portal.buscar_osc_regiao_geo(?::NUMERIC);", false]
	);

	private function configResultGeo($result){
		$result_ajusted = '{';
		foreach (json_decode($result) as $value) {
			$result_ajusted = $result_ajusted . $value->geo_posiciao_osc . ', ';
		}
		$result_ajusted = substr($result_ajusted, 0, -2);
		$result_ajusted = $result_ajusted . '}';

		return $result_ajusted;
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

		if($type_result == 'geo'){
			$result = $this->configResultGeo($result);
		}

        return $result;
    }
}
