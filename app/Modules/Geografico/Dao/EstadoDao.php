<?php

namespace App\Dao\Geo;

use App\Dao\Dao;

class EstadoDao extends Dao
{
    public function buscarEstadoPorCodigo($cd_uf)
    {
        $result = array();
        
        $query = 'SELECT * FROM spat.ed_municipio WHERE ed_uf == ?::NUMERIC;';
        $params = [$cd_uf];
        $result = $this->executeQuery($query, false, $params);
        
        return $result;
    }
}
