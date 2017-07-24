<?php

namespace App\DAO\Geo;

use App\DAO\DAO;

class MunicipioDAO extends DAO
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
