<?php

namespace App\Services\Osc;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\OscDao;

class EditarRecursosOscService extends Service
{
	public function executar()
	{
		$contrato = [
			'id_osc' => ['apelidos' => NomenclaturaAtributoEnum::ID_OSC, 'obrigatorio' => true, 'tipo' => 'integer'],
			'fonte_recursos' => ['apelidos' => ['fonterecursos, fonteRecursos', 'fonte_recursos'], 'obrigatorio' => true, 'tipo' => 'arrayObject']
		];
		
		$model = new Model($contrato, $this->requisicao->getConteudo());
		$flagModel = $this->analisarRequisicao($model);
		
		if($flagModel){
			$requisicao = $model->getRequisicao();
			
			$oscDao = new OscDao();
			$recursosExistentes = $oscDao->obterRecursosOsc($requisicao->id_osc);
			
			$arrayInsert = array();
			$arrayUpdate = array();
			$arrayDelete = $recursosExistentes;
			
			foreach($recursosExistentes as $recursoExistente){
				foreach($requisicao->fonte_recursos as $recursoRequisicao){
					
				}
			}
			
			
			
			foreach($requisicao->fonte_recursos as $recurso){		
				if($recurso->nr_valor_recursos_osc){
					$recurso->nr_valor_recursos_osc = true;
				}
			}
			
			/*
			 $representacao = $oscDao->inserirRecursosOsc($requisicao);
			 */
		}
	}
	
	private function analisarRequisicao($model)
	{
		$flagModel = $this->analisarModel($model);
		
		foreach($model->getRequisicao()->fonte_recursos as $recurso){
			$flagModel = $this->validarRecurso($recurso);
			
			if($flagModel == false){
				break;
			}
		}
		
		return $flagModel;
	}
	
	private function validarRecurso($recurso)
	{
		$contrato = [
			'cd_fonte_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::CD_FONTE_RECURSOS_OSC, 'obrigatorio' => false, 'tipo' => 'integer'],
			'dt_ano_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::ANO_RECURSOS_OSC, 'obrigatorio' => true, 'tipo' => 'date'],
			'nr_valor_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::VALOR_RECURSOS_OSC, 'obrigatorio' => true, 'tipo' => 'float'],
			'bo_nao_possui' => ['apelidos' => NomenclaturaAtributoEnum::NAO_POSSUI, 'obrigatorio' => false, 'tipo' => 'bollean']
		];
		
		$model = new Model($contrato, $recurso);
		$flagModel = $this->analisarModel($model);
		
		return $flagModel;
	}
}
