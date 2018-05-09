<?php

namespace App\Services\Osc\EditarDescricao;

use App\Services\BaseService;
use App\Dao\Osc\DescricaoDao;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();

		$idOsc = $conteudoRequisicao->id_osc;

		$modelo = new Model($conteudoRequisicao);

		$listaObjetivo = array();
		if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();

			$resultadoDao = (new DescricaoDao)->editarDescricao($idOsc, $requisicao);
			$this->analisarDao($resultadoDao);
		}else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}