<?php

namespace App\Dao\Geo;

use App\Dao\Dao;

class MunicipioDao extends Dao
{
    public function buscarMunicipioPorCodigo($cd_municipio)
    {
        $result = array();
        
        $query = 'SELECT * FROM spat.ed_municipio WHERE edmu_cd_municipio == ?::NUMERIC;';
        $params = [$cd_municipio];
        $result = $this->executeQuery($query, false, $params);
        
        return $result;
    }
}
