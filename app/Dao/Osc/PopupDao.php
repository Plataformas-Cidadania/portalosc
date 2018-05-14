<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class PopupDao extends DaoPostgres{
    public function obterPopup($modelo){
    	$result = array();
        
        $idOsc = $modelo->id_osc;

		$query = 'SELECT * FROM portal.obter_osc_popup(?::TEXT);';
		$params = [$idOsc];
        $result = $this->executarQuery($query, true, $params);
        
        return $result;
    }
}