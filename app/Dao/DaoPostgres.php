<?php

namespace App\Dao;

use DB;

class DaoPostgres
{
	protected function executarQuery($query, $unique = false, $params = null)
	{
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
