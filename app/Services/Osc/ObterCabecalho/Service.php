<?php

namespace App\Services\Osc\ObterCabecalho;

use App\Services\BaseService;
use App\Dao\Osc\CabecalhoDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);

	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
			$resultadoDao = (new CabecalhoDao())->obterCabecalho($requisicao);
	    	
	    	if($resultadoDao){
	    	    $this->resposta->prepararResposta($resultadoDao, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a atualização desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}