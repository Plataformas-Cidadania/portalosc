<?php

namespace App\Dao;

use DB;

class DaoMongoDb
{
    protected function executarUpsert($json)
	{
		$resultado = null;
		
	    if($json){
			$db = DB::connection('mongodb');
			
			$query = array(
			    '_id' => $json['_id']
			);
			
            $resultado = $db->command(
                array(
                    'findAndModify' => 'parcerias_estado_municipio',
                    'query' => $query,
                    'update' => $json,
                    'new' => true,
                    'upsert' => true
                )
            );
	    }
	    
		return $resultado;
	}
}
