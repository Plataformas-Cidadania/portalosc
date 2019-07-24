<?php

namespace App\Dao\Analises;

use App\Dao\DaoPostgres;
//use Illuminate\Support\Facades\DB;

class DadosGeograficosIDHDao extends DaoPostgres {

    public function obterDadosGeograficosIDHDao($modelo){

        $result = array();
        
        $id = $modelo->id;

        $query = 'SELECT * FROM ipeadata.obter_dados_geograficos_idh_municipio(?::INTEGER);';
        $params = [$id];

        $result = $this->executarQuery($query, true, $params);

        return $result;

    	/*
        $result =  DB::table('ipeadata.vw_dados_geograficos_idh_municipio')->select(DB::Raw('edmu_cd_municipio, edmu_nm_municipio, nr_valor, ST_AsGeoJSON(edmu_geometry)::json As geometry'))->get();

        $areas = [];
        $areas['type'] = 'FeatureCollection';
        $areas['features'] = [];
        foreach($result as $index => $valor){
            $areas['features'][$index]['type'] = 'Feature';
            $areas['features'][$index]['id'] = $index;
            $areas['features'][$index]['properties']['edmu_cd_municipio'] = $valor->edmu_cd_municipio;
            $areas['features'][$index]['properties']['edmu_nm_municipio'] = $valor->edmu_nm_municipio;
            $areas['features'][$index]['properties']['nr_valor'] = $valor->nr_valor;
            $areas['features'][$index]['geometry'] = json_decode($valor->geometry);


            //$areas['features'][$index]['centro'] = $valor->centro_de_tudo;
        }

        $areas['bounding_box_total'] = [];
        $areas['bounding_box_total']['type'] = 'FeatureCollection';
        $areas['bounding_box_total']['features'] = [];

        return $areas;
    	*/
    }
}