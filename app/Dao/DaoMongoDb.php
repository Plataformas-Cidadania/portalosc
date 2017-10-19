<?php

namespace App\Dao;

use DB;

class DaoMongoDb
{
    protected function executarUpsert($dados, $query)
	{
		$resultado = null;
		
		if($dados){
			$db = DB::connection('mongodb');
			
            $resultado = $db->command(
                array(
                    'findAndModify' => 'parcerias_estado_municipio',
                    'query' => $query,
                    'update' => $dados,
                    'new' => true,
                    'upsert' => true
                )
            );
	    }
	    
		return $resultado;
	}
}
