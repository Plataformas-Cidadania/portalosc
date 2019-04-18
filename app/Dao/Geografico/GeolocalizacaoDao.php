<?php

namespace App\Dao\Geografico;

use App\Enums\TipoRegiaoEnum;
use App\Dao\DaoPostgres;

class GeolocalizacaoDao extends DaoPostgres{
    private $queriesGeografico = array(
        'municipio' => [
            'query' => 'SELECT id_osc, geo_lat, geo_lng FROM osc.vw_geo_osc WHERE cd_municipio::TEXT = ?::TEXT OR tx_nome_municipio::TEXT = ?::TEXT;',
            'unique' => false
        ],
        'estado' => [
            'query' => 'SELECT id_osc, geo_lat, geo_lng FROM osc.vw_geo_osc WHERE cd_estado::TEXT = ?::TEXT OR tx_nome_estado::TEXT = ?::TEXT OR tx_sigla_estado::TEXT = ?::TEXT;',
            'unique' => false
        ],
        'regiao' => [
            'query' => 'SELECT id_osc, geo_lat, geo_lng FROM osc.vw_geo_osc WHERE cd_regiao::TEXT = ?::TEXT OR tx_nome_regiao::TEXT = ?::TEXT;',
            'unique' => false
        ]
    );
    
    public function obterGeolocalizacaoOsc($idOsc){
        $query = 'SELECT * FROM portal.obter_geolocalizacao_osc(?::INTEGER);';
        $params = [$idOsc];
        return $this->executarQuery($query, false, $params);
    }
    
    public function obterGeolocalizacaoOscs(){
        $query = 'SELECT * FROM portal.obter_geolocalizacao_oscs();';
        return $this->executarQuery($query, false);
    }
    
    public function obterGeolocalizacaoOscsRegiao($tipoRegiao, $idRegiao){
        $resultado = null;
        
        if(array_key_exists($tipoRegiao, $this->queriesGeografico)){
            $queryList = $this->queriesGeografico[$tipoRegiao];
            $query = $queryList['query'];
            $unique = $queryList['unique'];
            
            if($tipoRegiao == 'estado'){
                $params = [$idRegiao, $idRegiao, $idRegiao];
            }else{
                $params = [$idRegiao, $idRegiao];
            }
            
            $resultado = $this->executarQuery($query, $unique, $params);
        }
        
        return $resultado;
    }
    
    public function obterGeolocalizacaoOscsArea($norte, $sul, $leste, $oeste){
        $query = 'SELECT vw_geo_osc.id_osc, vw_geo_osc.geo_lat, vw_geo_osc.geo_lng FROM osc.vw_geo_osc WHERE ST_MakePoint(vw_geo_osc.geo_lng, vw_geo_osc.geo_lat) && ST_MakeEnvelope(?::DOUBLE PRECISION, ?::DOUBLE PRECISION, ?::DOUBLE PRECISION, ?::DOUBLE PRECISION, 4674);';
        $params = [$oeste, $sul, $leste, $norte];
        return $this->executarQuery($query, false, $params);
    }
}