<?php

namespace App\Dao;

use App\Dao\Dao;

class OscDao extends Dao
{
    public function buscarOSCsDeUsuario($object)
    {
        $result = array();
        
        $query = 'SELECT * FROM portal.obter_representacao(?::INTEGER);';
        $params = [$object->id_usuario];
        $result = $this->executeQuery($query, false, $params);
        
        return $result;
    }
}
