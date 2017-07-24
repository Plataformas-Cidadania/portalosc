<?php

namespace App\DAO\Geo;

use App\DAO\DAO;

class EstadoDAO extends DAO
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
