<?php

namespace App\Dao;

use App\Dao\Dao;

class DictionaryDao extends Dao{
	public $queriesRegion = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
        "regiao" => ["SELECT * FROM portal.get_dictionary_regiao(?::TEXT);", false],
        "estado" => ["SELECT * FROM portal.get_dictionary_estado(?::TEXT);", false],
        "municipio" => ["SELECT * FROM portal.get_dictionary_municipio(?::TEXT);", false]
    );

    public function getDictionaryRegion($region, $param){
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
