<?php

namespace App\DAO\OSC;

use App\DAO\DAO;

class OSCDAO extends DAO
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