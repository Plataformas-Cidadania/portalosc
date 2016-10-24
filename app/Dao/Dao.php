<?php

namespace App\Dao;

use DB;

class Dao
{
    public function executeQuery($query, $unique, $params = null)
    {
        $result = null;
        if($params){
    		$result_query = DB::select($query, $params);
        }else{
        	$result_query = DB::select($query);
        }

    	if($result_query){
	    	if($unique){
	    		$result = json_encode(reset($result_query));
			}else{
	    		$result = json_encode($result_query);
			}
    	}

    	return $result;
    }
}
