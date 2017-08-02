<?php

namespace App\Dao;

use App\Dao\Dao;

class GeograficoDao extends Dao
{
    public function obterMunicipio()
    {
        $query = 'SELECT edmu_cd_municipio AS cd_municipio, edmu_nm_municipio FROM spat.ed_municipio WHERE edmu_cd_municipio = ?::NUMERIC;';
        $params = [$this->requisicao->cd_municipio];
        $this->resposta = $this->executarQuery($query, true, $params);
    }
    
    public function obterEstado()
    {
        $query = 'SELECT eduf_cd_uf AS cd_uf, eduf_nm_uf, eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf = ?::NUMERIC;';
        $params = [$this->requisicao->cd_uf];
        $this->resposta = $this->executarQuery($query, true, $params);
    }
}
