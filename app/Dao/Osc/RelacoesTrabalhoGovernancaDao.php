<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class RelacoesTrabalhoGovernancaDao extends DaoPostgres{
    public function obterRelacoesTrabalhoGovernanca($modelo){
    	$result = array();
		
    	$query = "SELECT * FROM portal.obter_osc_relacoes_trabalho(?::TEXT);";
    	$result_query = $this->executarQuery($query, true, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["relacoes_trabalho" => $result_query]);
		}
		
    	$query = "SELECT * FROM portal.obter_osc_relacoes_trabalho_outra(?::TEXT);";
    	$result_query = $this->executarQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["relacoes_trabalho_outra" => $result_query]);
		}
		
    	$query = "SELECT * FROM portal.obter_osc_governanca(?::TEXT);";
    	$result_query = $this->executarQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["governanca" => $result_query]);
		}
		
    	$query = "SELECT * FROM portal.obter_osc_conselho_fiscal(?::TEXT);";
    	$result_query = $this->executarQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["conselho_fiscal" => $result_query]);
		}
		
        if(count($result) == 0){
            $result = null;
        }
        
        return $result;
    }
}