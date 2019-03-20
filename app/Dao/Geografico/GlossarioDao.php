<?php

namespace App\Dao\Geografico;

use App\Enums\TipoRegiaoEnum;
use App\Dao\DaoPostgres;

class GlossarioDao extends DaoPostgres{
    public function obterMunicipio($cd_municipio){
        $query = '
            SELECT 
                ed_municipio.edmu_cd_municipio AS cd_municipio, 
                ed_municipio.edmu_nm_municipio, 
                ed_uf.eduf_cd_uf,
                ed_uf.eduf_sg_uf
            FROM spat.ed_municipio 
            INNER JOIN spat.ed_uf
            ON ed_uf.eduf_cd_uf = ed_municipio.eduf_cd_uf
            WHERE ed_municipio.edmu_cd_municipio = ?::NUMERIC;
        ';
        $params = [$cd_municipio];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterEstado($cd_uf){
        $query = 'SELECT eduf_cd_uf AS cd_uf, eduf_nm_uf, eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf = ?::NUMERIC;';
        $params = [$cd_uf];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterRegiao($cd_regiao){
        $query = 'SELECT edre_cd_regiao AS cd_regiao, edre_nm_regiao FROM spat.vw_spat_regiao WHERE edre_cd_regiao = ?::NUMERIC;';
        $params = [$cd_regiao];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterNomeLocalidade($tipoRegiao, $latitude, $longitude){
        $query = 'SELECT * FROM portal.buscar_nome_localidade(?::TEXT, ?::DOUBLE PRECISION, ?::DOUBLE PRECISION);';
        $params = [$tipoRegiao, $latitude, $longitude];
        return $this->executarQuery($query, false, $params);
    }
}