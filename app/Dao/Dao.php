<?php

namespace App\Dao;

use DB;

class Dao
{
    public function executeSelectQuery($query, $unique, $params)
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

    public function executeInsertQuery($query, $params)
    {
        DB::insert($query, $params);
    }
}
