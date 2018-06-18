<?php

namespace App\Services\Busca\BuscaComum;

use App\Services\BaseService;
use App\Dao\Busca\BuscaComumDao;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();

		$modelo = new Model($conteudoRequisicao);

		$listaObjetivo = array();
		if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();

			$resultadoDao = (new BuscaComumDao)->obterBusca($conteudoRequisicao, $requisicao);

			if($resultadoDao){
	    	    $this->resposta->prepararResposta($resultadoDao, 200);
	    	}else{
	    		$this->resposta->prepararResposta(null, 204);
	    	}
		}else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}