<?php

namespace App\Dao\Analises;

use App\Dao\DaoPostgres;

class PerfilLocalidadeDao extends DaoPostgres{
    public function obterPerfilLocalidade($modelo){
    	$result = array();
        
        $id = $modelo->id;
        
		$query = 'SELECT * FROM analysis.obter_perfil_localidade(?::INTEGER);';
		$params = [$id];
        $result = $this->executarQuery($query, true, $params);
        
        return $result;
    }
}