<?php

namespace App\Services\Osc\EditarDadosGerais;

use App\Services\BaseService;
use App\Dao\Analises\BarraTransparenciaOscDao;
use App\Dao\Osc\DadosGeraisDao;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();

		$idOsc = $conteudoRequisicao->id_osc;

		$modelo = new Model($conteudoRequisicao);

		$listaObjetivo = array();
		if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();

			$resultadoDao = (new DadosGeraisDao)->editarDadosGerais($idOsc, $requisicao);
			$this->analisarDao($resultadoDao);
		}else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}