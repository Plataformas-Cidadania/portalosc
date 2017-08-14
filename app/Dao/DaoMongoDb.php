<?php

namespace App\Dao;

use DB;

class DaoMongoDb
{
	protected function executarInsert($json)
	{
		$resultado = null;
		
	    DB::connection('mongodb');
	    
	    if($json){
	    	$resultado = DB::collection('parcerias')->insert($json);
	    }
	    
		return $resultado;
	}
}
