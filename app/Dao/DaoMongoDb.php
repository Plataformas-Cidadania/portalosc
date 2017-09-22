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
			$resultado = $db->collection('parcerias_estado_municipio')->insert($json);
	    }
	    
		return $resultado;
	}
}
