<?php

namespace App\Dao;

use DB;

class DaoMongoDb
{
	protected function executarInsert($json)
	{
		$resultado = null;
		
	    if($json){
			$db = DB::connection('mongodb');
			$resultado = $db->collection('parcerias')->insert($json);
	    }
	    
		return $resultado;
	}
}
