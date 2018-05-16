<?php

namespace App\Dao\Analises;

use App\Dao\DaoPostgres;

class GraficoDao extends DaoPostgres{
    public function obterGrafico($modelo){
    	$result = array();
        
        $nomeGrafico = $modelo->nome_grafico;

		$query = 'SELECT * FROM portal.obter_osc_popup(?::TEXT);';
		$params = [$nomeGrafico];
        $result = $this->executarQuery($query, true, $params);
        
        return $result;
    }
}