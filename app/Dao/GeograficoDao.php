<?php

namespace App\Dao;

use App\Dao\Dao;

class GeograficoDao extends Dao
{
    private $queriesGeografico = array(
        'municipio' => [
            'query' => 'SELECT id_osc, geo_lat, geo_lng osc.vw_geo_osc WHERE cd_municipio::TEXT = ?::TEXT OR tx_nome_municipio::TEXT = ?::TEXT;',
            'unique' => false
        ],
        'estado' => [
            'query' => 'SELECT id_osc, geo_lat, geo_lng osc.vw_geo_osc WHERE cd_estado::TEXT = ?::TEXT OR tx_nome_estado::TEXT = ?::TEXT OR tx_sigla_estado::TEXT = ?::TEXT;',
            'unique' => false
        ],
        'regiao' => [
            'query' => 'SELECT id_osc, geo_lat, geo_lng osc.vw_geo_osc WHERE cd_regiao::TEXT = ?::TEXT OR tx_nome_regiao::TEXT = ?::TEXT;',
            'unique' => false
        ]
    );
    
    public function obterMunicipio($cd_municipio)
    {
        $query = 'SELECT edmu_cd_municipio AS cd_municipio, edmu_nm_municipio FROM spat.ed_municipio WHERE edmu_cd_municipio = ?::NUMERIC;';
        $params = [$cd_municipio];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterEstado($cd_uf)
    {
        $query = 'SELECT eduf_cd_uf AS cd_uf, eduf_nm_uf, eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf = ?::NUMERIC;';
        $params = [$cd_uf];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterGeolocalizacaoOscs()
    {
        $query = 'SELECT * FROM portal.obter_geolocalizacao_oscs();';
        return $this->executarQuery($query, false);
    }
    
    public function obterGeolocalizacaoOsc($tipoRegiao, $idRegiao)
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
}
