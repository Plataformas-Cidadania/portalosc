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
			
			$configuracao = array(
				"upsert" => true
			);
			
			$resultado = $db->collection('parcerias_estado_municipio')->insert($json, $configuracao);
			
			/*
			$configuracao = array(
				"upsert" => true
			);
				
			$resultado = $db->collection('parcerias_estado_municipio')->save($json, $configuracao);
			*/
			
			/*
			$result = $db->command( array(
				'findAndModify' => 'parcerias_estado_municipio',
				'update' => $json,
				'new' => true,
				'upsert' => true
			));
			*/
			
			/*
			$configuracao = array(
				'upsert' => true
			);
			
			$resultado = $db->collection('parcerias_estado_municipio')->update($json, $configuracao);
			*/
	    }
	    
		return $resultado;
	}
}
