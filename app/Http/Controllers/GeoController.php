<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class GeoController extends Controller{
	private $queriesRegion = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
        "regiao" => ["SELECT * FROM portal.get_geo_osc_region(?::SMALLINT);", false],
        "estado" => ["SELECT * FROM portal.get_geo_osc_state(?::SMALLINT);", false],
        "municipio" => ["SELECT * FROM portal.get_geo_osc_city(?::NUMERIC);", false]
    );

    public function getOscRegion($region, $id){
        if(array_key_exists($region, $this->queriesRegion)){
        	$query_info = $this->queriesRegion[$region];
	    	$query = $query_info[0];
	    	$unique = $query_info[1];
	    	if(($region == 'regiao' && intval($id) <= 5) || ($region == 'estado' && intval($id) <= 53) || ($region == 'municipio' && strlen($id) <= 7)){
        		$result = json_decode($this->executeSelectQuery($query, $unique, [$id]));
	    	}else{
	    		$result = null;
	    	}
        }
        return $this->configResponse($result);
    }

    public function getOscCountry(){
	    $query = "SELECT * FROM portal.get_geo_osc_country();";
        $result = json_decode($this->executeSelectQuery($query, false, null));
        return $this->configResponse($result);
    }
}
