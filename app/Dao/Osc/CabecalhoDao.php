<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class CabecalhoDao extends DaoPostgres{
    public function obterCabecalho($modelo){
    	$result = array();
        
        $params = [$modelo->id_osc];

		$query = 'SELECT * FROM portal.obter_osc_cabecalho(?::TEXT);';
        $result = $this->executarQuery($query, true, $params);

        $query = "SELECT * FROM portal.obter_data_atualizacao(?::TEXT);";
    	$dataAtualizacao = $this->executarQuery($query, true, $params);
    	
        $result = array_merge((array) $result, (array) $dataAtualizacao);
        
        return $result;
    }
}