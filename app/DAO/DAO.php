<?php

namespace App\DAO;

use DB;

class DAO
{
	protected function executeQuery($query, $unique = false, $params = null)
	{
		$result = null;
		
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
		
		return (array) $result;
	}
}
