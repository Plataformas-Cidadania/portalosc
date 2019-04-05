<?php

namespace App\Services\Osc\ObterDataAtualizacao;

use App\Services\BaseService;
use App\Dao\OscDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);

	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
	    	$dataAtualizacaoOsc = (new OscDao())->obterDataAtualizacao($requisicao->id_osc);
	    	
	    	if($dataAtualizacaoOsc){
	    	    $this->resposta->prepararResposta($dataAtualizacaoOsc, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a atualização desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}