<?php

namespace App\Dao\Analises;

use App\Dao\DaoPostgres;

class PerfilRegiaoDao extends DaoPostgres{
    public function obterPerfil($idRegiao){
    	$result = array();
        
        $id = $modelo->id;
        
		$query = 'SELECT * FROM portal.obter_perfil_regiao(?::TEXT);';
		$params = [$idRegiao];
        $result = $this->executarQuery($query, true, $params);
        
        return $result;
    }
}