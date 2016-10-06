<?php

namespace App\Dao;

use App\Dao\Dao;

class SearchDao extends Dao{
    public function searchOsc($param){
        $query = "SELECT * FROM portal.buscar_osc(?::TEXT);";
        $result = json_decode($this->executeQuery($query, false, [$param]));
        return $result;
    }
}
