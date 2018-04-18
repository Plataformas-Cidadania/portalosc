<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class PopupDao extends DaoPostgres{
    public function obterPopup($modelo){
    	$result = array();
    	
		$query = 'SELECT * FROM portal.obter_osc_popup(?::TEXT);';
		$params = [$modelo->id_osc];
        $result = $this->executarQuery($query, true, $params);
        
        return $result;
    }
}