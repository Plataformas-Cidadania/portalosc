<?php

namespace App\Services\Osc\DadosGerais;

use App\Services\BaseService;
use App\Models\Osc\DadosGeraisModel;
use App\Models\Osc\ObjetivoMetaModel;
use App\Dao\Osc\DadosGeraisOscDao;

class EditarDadosGeraisOscService extends BaseService
{
	public function executar()
	{
		$conteudoRequisicao = $this->requisicao->getConteudo();

		$idOsc = $conteudoRequisicao->id_osc;
		
		$dadosGerais = new DadosGeraisModel($conteudoRequisicao);
		$flag = $this->analisarModel($dadosGerais);

		if($flag){
			$listaObjetivo = array();
			if(isset($dadosGerais->getModel()->objetivoMeta)){
				foreach($dadosGerais->getModel()->objetivoMeta as $objetivoMeta){
					$modelo = new ObjetivoMetaModel($objetivoMeta);
					$flag = $this->analisarModel($modelo);
					
					if($flag){
						$objetivoMetaAjustado = $modelo->getModel();
						array_push($listaObjetivo, $objetivoMetaAjustado);
					}else{
						break;
					}
				}
			}

			if($flag){
				$this->executarDao($idOsc, $dadosGerais->getModel());
			}
		}
	}

	private function executarDao($idOsc, $dadosGerais){
		$resultadoDao = (new DadosGeraisOscDao)->editarDadosGerais($idOsc, $dadosGerais);
		$this->analisarDao($resultadoDao);
	}
}