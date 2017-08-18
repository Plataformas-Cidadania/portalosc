<?php

namespace App\Services\Osc;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\OscDao;

class EditarRecursosOscService extends Service
{
	private function validarRecursos($listaRecursos)
	{
		$contrato = [
				'cd_fonte_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::ID_USUARIO, 'obrigatorio' => true, 'tipo' => 'integer'],
				'dt_ano_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'date'],
				'nr_valor_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'float']
		];
		
		foreach($listaRecursos as $recurso){
			$model = new Model($contrato, $recurso);
			$flagModel = $this->analisarModel($model);
			
			if($flagModel == false){
				break;
			}
		}
		
		return $flagModel;
	}
	
	private function analisarRequisicao($model)
	{
		$flagModel = $this->analisarModel($model);
		
		if($flagModel){
			$flagModel = $this->validarRecursos($model->fonte_recursos);
		}
		
		return $flagModel;
	}
	
	public function executar()
	{
		$contrato = [
			'id_osc' => ['apelidos' => NomenclaturaAtributoEnum::ID_OSC, 'obrigatorio' => true, 'tipo' => 'integer'],
			'fonte_recursos' => ['apelidos' => ['fonterecursos, fonteRecursos', 'fonte_recursos'], 'obrigatorio' => true, 'tipo' => 'arrayObject']
		];
		
		$model = new Model($contrato, $this->requisicao->getConteudo());
		$flagModel = $this->analisarRequisicao($model);
		
		
		
		
		
		$recursos_req = $request->fonte_recursos;
		
		$id_usuario = $request->user()->id;
		
		$query = "SELECT * FROM osc.tb_recursos_osc WHERE id_osc = ?::INTEGER;";
		$recursos_db = DB::select($query, [$id_osc]);
		
		$array_insert = array();
		$array_update = array();
		$array_delete = $recursos_db;
		
		$flag_delete = true;
		
		foreach($recursos_req as $key_req => $value_req){
			$cd_fonte_recursos_osc = $value_req['cd_fonte_recursos_osc'];
				
			$dt_ano_recursos_osc = null;
			if($value_req['dt_ano_recursos_osc']){
				$dt_ano_recursos_osc = $value_req['dt_ano_recursos_osc'];
		
				if(strlen($dt_ano_recursos_osc) == 4){
					$dt_ano_recursos_osc = $dt_ano_recursos_osc.'-01-01';
				}
		
				$date = date_create($dt_ano_recursos_osc);
				$dt_ano_recursos_osc = date_format($date, "Y-m-d");
			}
				
			$nr_valor_recursos_osc = null;
			if(isset($value_req['nr_valor_recursos_osc'])){
				$nr_valor_recursos_osc = $this->formatacaoUtil->converMoneyToDouble($value_req['nr_valor_recursos_osc']);
			}
				
			$params = ["id_usuario" => $id_usuario, "id_osc" => $id_osc, "cd_fonte_recursos_osc" => $cd_fonte_recursos_osc, "dt_ano_recursos_osc" => $dt_ano_recursos_osc, "nr_valor_recursos_osc" => $nr_valor_recursos_osc];
				
			$flag_insert = true;
				
			foreach ($recursos_db as $key_db => $value_db) {
				if($value_db->cd_fonte_recursos_osc == $cd_fonte_recursos_osc && $value_db->dt_ano_recursos_osc == $dt_ano_recursos_osc){
					$flag_insert = false;
						
					if(!$nr_valor_recursos_osc){
						foreach ($array_delete as $key => $value) {
							if($value->id_recursos_osc == $value_db->id_recursos_osc){
								$flag_delete = $this->deleteRecursosOsc($value);
							}
						}
					}
					else if($value_db->nr_valor_recursos_osc != $nr_valor_recursos_osc){
						$params['id_recursos_osc'] = $value_db->id_recursos_osc;
						$params['recursos_osc_db'] = $recursos_db;
						array_push($array_update, $params);
					}
				}
			}
				
			if($flag_insert){
				if($nr_valor_recursos_osc){
					array_push($array_insert, $params);
				}
			}
				
			foreach ($array_delete as $key => $value) {
				if($value->cd_fonte_recursos_osc == $cd_fonte_recursos_osc && $value->dt_ano_recursos_osc == $dt_ano_recursos_osc){
					unset($array_delete[$key]);
				}
			}
		}
		
		$flag_insert = true;
		foreach($array_insert as $key => $value){
			$flag_insert = $this->insertRecursosOsc($value);
		}
		
		$flag_update = true;
		foreach($array_update as $key => $value){
			$flag_update = $this->updateRecursosOsc($value);
		}
		
		foreach($array_delete as $key => $value){
			$flag_delete = $this->deleteRecursosOsc($value, $id_usuario);
		}
		
		if($flag_insert || $flag_update || $flag_delete){
			$result = ['msg' => 'Recursos da OSC atualizado.'];
			/*
			 if(!$flag_insert){
			 $result['msg'] = $result['msg'] . ' Mas ocorreu um erro na inserção de algum novo recurso.';
			 }
			 if(!$flag_update){
			 $result['msg'] = $result['msg'] . ' Mas ocorreu um erro na atualização de algum recurso.';
			 }
			 if(!$flag_delete){
			 $result['msg'] = $result['msg'] . ' Mas ocorreu um erro na exclusão de algum recurso.';
			 }
			 */
			$this->configResponse($result, 200);
		}
		else{
			$result = ['msg' => 'Ocorreu um erro'];
			$this->configResponse($result, 400);
		}
		
		return $this->response();
	}
}
