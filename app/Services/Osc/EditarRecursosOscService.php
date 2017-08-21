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
			$recursosExistente = (new OscDao())->obterRecursosOsc($model->getRequisicao()->id_osc);
			
			$arrayInsert = array();
			$arrayUpdate = array();
			$arrayDelete = $recursosExistente;
			
			$idusuario = $this->requisicao->getusuario()->id_usuario;
			
			foreach($model->getRequisicao()->fonte_recursos as $recursosRequisicao){
				$flagInsert = true;
				
				if($recursosRequisicao->nr_valor_recursos_osc){
					$recursosRequisicao->bo_nao_possui = false;
				}
				
				foreach ($recursosExistente as $keyRecursosBd => $recursosBd) {
					if($recursosBd->cd_fonte_recursos_osc == $recursosRequisicao->cd_fonte_recursos_osc && $recursosBd->dt_ano_recursos_osc == $recursosRequisicao->dt_ano_recursos_osc){
						$flagInsert = false;
						
						unset($arrayDelete[$keyRecursosBd]);
						
						if($recursosBd->nr_valor_recursos_osc != $recursosRequisicao->nr_valor_recursos_osc){
							$recursosRequisicao->id_recursos_osc = $recursosBd->id_recursos_osc;
							$recursosRequisicao->id_osc = $model->getRequisicao()->id_osc;
							$recursosRequisicao->ft_fonte_recursos_osc = 'Representante';
							$recursosRequisicao->ft_ano_recursos_osc = 'Representante';
							$recursosRequisicao->ft_valor_recursos_osc = 'Representante';
							array_push($arrayUpdate, $recursosRequisicao);
						}
					}
				}
				
				if($flagInsert){
					$recursosRequisicao->id_osc = $model->getRequisicao()->id_osc;
					$recursosRequisicao->ft_fonte_recursos_osc = 'Representante';
					$recursosRequisicao->ft_ano_recursos_osc = 'Representante';
					$recursosRequisicao->ft_valor_recursos_osc = 'Representante';
					array_push($arrayInsert, $recursosRequisicao);
				}
			}
			
			$recursosDelete = $this->excluirListaRecursosOsc($arrayDelete);
			$recursosUpdate = $this->atualizarListaRecursosOsc($arrayUpdate);
			$recursosInsert = $this->inserirListaRecursosOsc($arrayInsert);
			
			$mensagensErro = $this->analisarResultadosDao($recursosDelete, $recursosUpdate, $recursosInsert);
			
			if($mensagensErro){
				$this->resposta->prepararResposta(['msg' => 'Recursos de OSC foram atualizados, mas não completamente. Ocorreu algum erro na atualização dos dados.'], 202);
			}else{
				$this->resposta->prepararResposta(['msg' => 'Recursos de OSC foram atualizados.'], 200);
			}
		}
	}
	
	private function analisarResultadosDao($recursosDelete, $recursosUpdate, $recursosInsert)
	{
		$mensagensErro = array();
		
		foreach($recursosDelete as $resultadoDao){
			if(!$resultadoDao->flag){
				array_push($mensagensErro, $resultadoDao);
			}
		}
		
		foreach($recursosUpdate as $resultadoDao){
			if(!$resultadoDao->flag){
				array_push($mensagensErro, $resultadoDao);
			}
		}
		
		foreach($recursosInsert as $resultadoDao){
			if(!$resultadoDao->flag){
				array_push($mensagensErro, $resultadoDao);
			}
		}
		
		return $mensagensErro;
	}
	
	private function excluirListaRecursosOsc($arrayDelete)
	{
		$arrayResultadoDao = array();
		
		foreach($arrayDelete as $recursosOsc){
			$resultadoDao = (new OscDao())->excluirRecursosOsc($recursosOsc->id_recursos_osc);
			array_push($arrayResultadoDao, $resultadoDao);
		}
		
		return $arrayResultadoDao;
	}
	
	private function atualizarListaRecursosOsc($arrayUpdate)
	{
		$arrayResultadoDao = array();
		
		foreach($arrayUpdate as $recursosOsc){
			$resultadoDao = (new OscDao())->atualizarRecursosOsc($recursosOsc);
			array_push($arrayResultadoDao, $resultadoDao);
		}
		
		return $arrayResultadoDao;
	}
	
	private function inserirListaRecursosOsc($arrayInsert)
	{
		$arrayResultadoDao = array();
		
		foreach($arrayInsert as $recursosOsc){
			$resultadoDao = (new OscDao())->inserirRecursosOsc($recursosOsc);
			array_push($arrayResultadoDao, $resultadoDao);
		}
		
		return $arrayResultadoDao;
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
			'cd_fonte_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::CD_FONTE_RECURSOS_OSC, 'obrigatorio' => true, 'tipo' => 'integer'],
			'dt_ano_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::ANO_RECURSOS_OSC, 'obrigatorio' => true, 'tipo' => 'date'],
			'nr_valor_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::VALOR_RECURSOS_OSC, 'obrigatorio' => false, 'tipo' => 'float'],
			'bo_nao_possui' => ['apelidos' => NomenclaturaAtributoEnum::NAO_POSSUI, 'obrigatorio' => false, 'tipo' => 'bollean']
		];
		
		$model = new Model($contrato, $recurso);
		$flagModel = $this->analisarModel($model);
		
		return $flagModel;
	}
}
