<?php

namespace App\Services\Osc\EditarDadosGerais;

use App\Services\BaseService;
use App\Dao\Osc\DadosGeraisOscDao;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();

		$idOsc = $conteudoRequisicao->id_osc;

		$modelo = new Model($conteudoRequisicao);

		$listaObjetivo = array();
		if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();

			$resultadoDao = (new DadosGeraisOscDao)->editarDadosGerais($idOsc, $requisicao);
			$this->analisarDao($resultadoDao);
		}
	}
}