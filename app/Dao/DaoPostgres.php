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

	protected function executarQuerys($querys = [])
	{
		$resultado = array();

		DB::beginTransaction();
		try {
			foreach($querys as $query){
				$resultadoQuery = $this->executarQuery($query->query, $query->unique, $query->params);

				array_push($resultado, $resultadoQuery);

				if(isset($resultado->flag)){
					if(!$resultado->flag){
						throw new Exception();
						break;
					}
				}
			}

			DB::commit();
		} catch (\Exception $e) {
			$resultadoQuery = new \stdClass();
			$resultadoQuery->mensagem = 'Ocorreu um erro.';
			$resultadoQuery->flag = false;

			array_push($resultado, $resultadoQuery);
			DB::rollback();
		}

		return $resultado;
	}
}