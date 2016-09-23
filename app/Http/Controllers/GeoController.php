<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class GeoController extends Controller{
	private $queriesRegion = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
        "regiao" => ["SELECT * FROM portal.get_geo_osc_country(?::SMALLINT);", false],
        "estado" => ["SELECT * FROM portal.get_geo_osc_state(?::INTEGER);", false],
        "municipio" => ["SELECT * FROM portal.get_geo_osc_city(?::NUMERIC);", false]
    );

    public function getOscRegion($region, $id){
        if(array_key_exists($region, $this->componentQueries)){
        	$query_info = $this->componentQueries[$region];
	    	$query = $query_info[0];
	    	$unique = $query_info[1];

        	$result = $this->executeQuery($query, $unique, $id);
        }
        return $this->configResponse($result);
    }

    public function getOscCountry(){
	    $query = "SELECT * FROM portal.get_geo_osc_country();";
        $result = $this->executeQuery($query, false, null);
        return $this->configResponse($result);
    }
}
