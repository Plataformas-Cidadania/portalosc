<?php

namespace App\Services\Edital\CriarEdital;

use App\Services\BaseService;
use App\Dao\Edital\EditalDao;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
		
		if($modelo->obterCodigoResposta() === 200){
	        $requisicao = $modelo->obterRequisicao();
	        $resultadoDao = (new EditalDao())->criarEdital($requisicao);
	        
	        if($resultadoDao->flag){
	            $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 200);
	        }else{
	            $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
	        }
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}