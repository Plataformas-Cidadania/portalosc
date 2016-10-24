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

	private $queriesMapa = array(
			/* Estrutura: nome_componente => [query_sql, is_unique] */
			"osc" => ["SELECT * FROM portal.buscar_osc_geo(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
			"municipio" => ["SELECT * FROM portal.buscar_osc_municipio_geo(?::NUMERIC);", false],
			"estado" => ["SELECT * FROM portal.buscar_osc_estado_geo(?::NUMERIC);", false],
			"regiao" => ["SELECT * FROM portal.buscar_osc_regiao_geo(?::NUMERIC);", false]
	);

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
    		$queries = $this->queriesMapa;
    	}

        if(array_key_exists($type_search, $queries)){
            $query_info = $queries[$type_search];
            $query = $query_info[0];
            $unique = $query_info[1];
            echo $query;
            $result = $this->executeQuery($query, $unique, $param);
        }else{
            $result = null;
        }

        return $result;
    }
}
