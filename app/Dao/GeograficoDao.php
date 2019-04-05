<?php

namespace App\Dao;

use App\Enums\TipoRegiaoEnum;
use App\Dao\DaoPostgres;

class GeograficoDao extends DaoPostgres
{
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
    
    public function obterMunicipio($cd_municipio)
    {
        $query = 'SELECT edmu_cd_municipio AS cd_municipio, edmu_nm_municipio, (SELECT eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf = SUBSTRING(?::TEXT from 0 for 3)::NUMERIC) as eduf_sg_uf FROM spat.ed_municipio WHERE edmu_cd_municipio = ?::NUMERIC;';
        $params = [$cd_municipio, $cd_municipio];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterEstado($cd_uf)
    {
        $query = 'SELECT eduf_cd_uf AS cd_uf, eduf_nm_uf, eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf = ?::NUMERIC;';
        $params = [$cd_uf];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterRegiao($cd_regiao)
    {
        $query = 'SELECT edre_cd_regiao AS cd_regiao, edre_nm_regiao FROM spat.vw_spat_regiao WHERE edre_cd_regiao = ?::NUMERIC;';
        $params = [$cd_regiao];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterGeolocalizacaoOsc($idOsc)
    {
        $query = 'SELECT * FROM portal.obter_geolocalizacao_osc(?::INTEGER);';
        $params = [$idOsc];
        return $this->executarQuery($query, false, $params);
    }
    
    public function obterGeolocalizacaoOscs()
    {
        $query = 'SELECT * FROM portal.obter_geolocalizacao_oscs();';
        return $this->executarQuery($query, false);
    }
    
    public function obterGeolocalizacaoOscsRegiao($tipoRegiao, $idRegiao)
    {
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
    
    public function obterGeolocalizacaoOscsArea($norte, $sul, $leste, $oeste)
    {
        $query = 'SELECT 
                        vw_geo_osc.id_osc, vw_geo_osc.geo_lat, vw_geo_osc.geo_lng
				    FROM 
                        osc.vw_geo_osc
					WHERE 
                        ST_MakePoint(vw_geo_osc.geo_lng, vw_geo_osc.geo_lat) && ST_MakeEnvelope(?::DOUBLE PRECISION, ?::DOUBLE PRECISION, ?::DOUBLE PRECISION, ?::DOUBLE PRECISION, 4674);';
        $params = [$oeste, $sul, $leste, $norte];
        return $this->executarQuery($query, false, $params);
    }
    
    public function obterCluster($tipoRegiao, $idRegiao)
    {
        $result = null;
        
        if(!is_int($tipoRegiao)){
            if($tipoRegiao == 'regiao'){
                $tipoRegiao = TipoRegiaoEnum::REGIAO;
            }elseif($tipoRegiao == 'estado'){
                $tipoRegiao = TipoRegiaoEnum::ESTADO;
            }elseif($tipoRegiao == 'municipio'){
                $tipoRegiao = TipoRegiaoEnum::MUNICIPIO;
            }
        }
        
        if($idRegiao == null){
            $idRegiao = 0;
        }
        
        $query = 'SELECT * FROM portal.obter_geo_cluster(?::INTEGER, ?::INTEGER);';
        $result = $this->executarQuery($query, false, [$tipoRegiao, $idRegiao]);
        
        return $result;
    }
    
    public function obterNomeLocalidade($tipoRegiao, $latitude, $longitude)
    {
        $query = 'SELECT * FROM portal.buscar_nome_localidade(?::TEXT, ?::DOUBLE PRECISION, ?::DOUBLE PRECISION);';
        $params = [$tipoRegiao, $latitude, $longitude];
        return $this->executarQuery($query, false, $params);
    }
}
