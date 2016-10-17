<?php

namespace App\Dao;

use App\Dao\Dao;

class SearchDao extends Dao{
	public $queries = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
		"osc" => ["SELECT * FROM portal.buscar_osc(?::TEXT);", false],
        "regiao" => ["SELECT * FROM portal.buscar_osc_regiao(?::NUMERIC);", false],
        "estado" => ["SELECT * FROM portal.buscar_osc_estado(?::NUMERIC);", false],
        "municipio" => ["SELECT * FROM portal.buscar_osc_municipio(?::NUMERIC);", false]
    );

    public function searchOsc($type, $param){
        if(array_key_exists($type, $this->queries)){
            $query_info = $this->queries[$type];
            $query = $query_info[0];
            $unique = $query_info[1];
			
            $result = json_decode($this->executeQuery($query, $unique, $param));
        }else{
            $result = null;
        }
        return $result;
    }
}
