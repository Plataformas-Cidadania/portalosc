<?php

namespace App\Dao;

use App\Dao\Dao;

class SearchDao extends Dao{
	public $queriesRegion = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
        "regiao" => ["SELECT * FROM portal.buscar_regiao(?::TEXT);", false],
        "estado" => ["SELECT * FROM portal.buscar_estado(?::TEXT);", false],
        "municipio" => ["SELECT * FROM portal.buscar_municipio(?::TEXT);", false]
    );

    public function searchOsc($param){
        $query = "SELECT * FROM portal.buscar_osc(?::TEXT);";
        $result = json_decode($this->executeQuery($query, false, [$param]));
        return $result;
    }

    public function searchRegion($region, $param){
        if(array_key_exists($region, $this->queriesRegion)){
            $query_info = $this->queriesRegion[$region];
            $query = $query_info[0];
            $unique = $query_info[1];

            $result = json_decode($this->executeQuery($query, $unique, [$param]));
        }else{
            $result = null;
        }
        return $result;
    }
}
