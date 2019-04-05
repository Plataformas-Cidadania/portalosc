<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class RelacoesTrabalhoGovernancaDao extends DaoPostgres{
    public function obterRelacoesTrabalhoGovernanca($modelo){
    	$result = array();
    	
		$query = 'SELECT * FROM portal.obter_osc_relacoes_trabalho_governanca(?::TEXT);';
		$params = [$modelo->id_osc];
        $result = $this->executarQuery($query, true, $params);
        
        return $result;
    }
}