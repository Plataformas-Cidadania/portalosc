<?php

namespace App\Services\Osc\ObterRelacoesTrabalhoGovernanca;

use App\Services\BaseService;
use App\Dao\Osc\RelacoesTrabalhoGovernancaDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);

	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
			$resultadoDao = (new RelacoesTrabalhoGovernancaDao())->obterRelacoesTrabalhoGovernanca($requisicao);
	    	
	    	if($resultadoDao){
	    	    $this->resposta->prepararResposta(json_decode($resultadoDao->resultado), 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a atualização desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}