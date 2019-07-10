<?php

namespace App\Dao\Analises;

use App\Dao\DaoPostgres;

class DadosGeograficosIDHDao extends DaoPostgres{
    public function obterDadosGeograficosIDHDao($modelo){
    	$result = array();
        
        $id = $modelo->id;
        //print_r($modelo);
		//$query = 'SELECT * FROM analysis.obter_perfil_localidade(?::INTEGER);';
        $query = 'SELECT * FROM ipeadata.obter_dados_geograficos_idh_municipio(?::INTEGER);';
		$params = [$id];
        $result = $this->executarQuery($query, true, $params);
        //print_r($result);
        return $result;
    }
}