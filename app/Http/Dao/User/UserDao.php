<?php

namespace App\Http\Dao\User;

use App\Http\Dao\Dao;

class UserDao extends Dao
{	
	public function getUserOsc($object)
	{
		$result = array();
		
		$query = 'SELECT * FROM portal.obter_representante(?::INTEGER);';
		$params = [$object['id_user']];
		$resultQuery = $this->execute($query, true, $params);
		
		if($resultQuery){
			foreach($resultQuery as $key => $value){
				$result = array_merge($result, [$key => $value]);
			}
			
			$query = 'SELECT * FROM portal.obter_representacao(?::INTEGER);';
			$params = [$object['id_user']];
			$resultQuery = $this->execute($query, true, $params);
			
			$result = array_merge($result, ["representacao" => $resultQuery]);
		}
		
		return $result;
	}
}