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

		$modelo = new DadosGeraisModel($conteudoRequisicao);

		$listaObjetivo = array();
		if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();

			$resultadoDao = (new DadosGeraisOscDao)->editarDadosGerais($idOsc, $requisicao);
			$this->analisarDao($resultadoDao);
		}
	}
}