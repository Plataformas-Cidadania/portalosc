<?php

namespace App\Dao;

use App\Dao\Dao;

class GeograficoDao extends Dao
{
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
    
    public function obterGeolocalizacaoOsc($idOsc)
    {
        $query = 'SELECT * FROM portal.obter_geolocalizacao_osc(?::INTEGER);';
        $params = [$idOsc];
        return $this->executarQuery($query, false, $params);
    }
}
