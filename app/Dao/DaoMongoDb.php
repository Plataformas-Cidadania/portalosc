<?php

namespace App\Dao;

use DB;

class DaoMongoDb
{
	public function executarQuery($query, $unique = false, $params = null)
	{
	    DB::connection('mongodb');
	    
		$result = array();
		
		if($params){
			$result_query = DB::select($query, $params);
		}else{
			$result_query = DB::select($query);
		}
		
		if($result_query){
			if($unique){
				$result = reset($result_query);
			}else{
				$result = $result_query;
			}
		}
		
		return $result;
	}
}
