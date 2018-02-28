<?php

namespace App\Services\Osc\DadosGerais;

use App\Services\Service;
use App\Models\Osc\DadosGeraisModel;
use App\Models\Osc\ObjetivoMetaModel;
use App\Dao\Osc\DadosGeraisOscDao;

class EditarDadosGeraisOscService extends Service
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
					$modelo = new CertificadoOscModel($objetivoMeta);
					$flag = $this->analisarModel($modelo);
					
					if(!$flag){
						break;
					}
				}
			}

			if($flag){
				$this->executarDao($idOsc, $dadosGerais);
			}
		}
	}

	private function executarDao($idOsc, $dadosGerais){
		$resultadoDao = (new DadosGeraisOscDao)->editarDadosGerais($idOsc, $dadosGerais);
		$this->analisarDao($resultadoDao);
	}
}