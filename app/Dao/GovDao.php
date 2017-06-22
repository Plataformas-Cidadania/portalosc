<?php

namespace App\Dao;

use App\Dao\Dao;

class GovDao extends Dao
{
    public function setDataGov($param)
    {
    	$result = array();
		
	    $query = "SELECT * FROM portal.obter_representante(?::INTEGER);";
        $result_query = $this->executeQuery($query, true, [$param]);
		
        if($result_query){
            foreach($result_query as $key => $value){
            	$result = array_merge($result, [$key => $value]);
            }
			
            $query = "SELECT * FROM portal.obter_representacao(?::INTEGER);";
            $result_query = $this->executeQuery($query, false, [$param]);
        	$result = array_merge($result, ["representacao" => $result_query]);
        }
		
        return $result;
    }
}
