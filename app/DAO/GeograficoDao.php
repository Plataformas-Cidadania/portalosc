<?php

namespace App\Dao;

use App\Dao\Dao;

class GeograficoDao extends Dao
{
    public function carregarMunicipio($requisicao)
    {
        $result = array();
        
        $query = 'SELECT edmu_cd_municipio AS cd_municipio, edmu_nm_municipio FROM spat.ed_municipio WHERE edmu_cd_municipio = ?::NUMERIC;';
        $params = [$requisicao->cd_municipio];
        $resposta = $this->executarQuery($query, true, $params);
        
        return $resposta;
    }
    
    public function carregarEstado($requisicao)
    {
        $result = array();
        
        $query = 'SELECT eduf_cd_uf AS cd_uf, eduf_nm_uf, eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf = ?::NUMERIC;';
        $params = [$requisicao->cd_uf];
        $resposta = $this->executarQuery($query, true, $params);
        
        return $resposta;
    }
}
