<?php

namespace App\Dao\Analises;

use App\Dao\DaoPostgres;

class GraficoDao extends DaoPostgres{
    public function obterGrafico($modelo){
    	$result = array();
        
        $id = $modelo->id;

		$query = 'SELECT * FROM portal.obter_grafico(?::TEXT);';
		$params = [$id];
        $result = $this->executarQuery($query, true, $params);
        
        return $result;
    }
}