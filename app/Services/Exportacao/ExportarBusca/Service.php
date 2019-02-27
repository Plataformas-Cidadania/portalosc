<?php

namespace App\Services\Exportacao\ExportarBusca;

use App\Services\BaseService;
use App\Dao\Exportacao\ExportacaoBuscaDao;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model($conteudoRequisicao);
		
		if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();
	        $resultadoDao = (new ExportacaoBuscaDao())->ExportarBusca($requisicao);
    	    
			if($resultadoDao->codigo === 200){
				$resultado = json_decode($resultadoDao->resultado);
	    	    $this->resposta->prepararResposta($resultado, 200);
	    	}else{
				$mensagem = $resultadoDao->mensagem;
				$codigo = $resultadoDao->codigo;
	    		$this->resposta->prepararResposta(['msg' => $mensagem], $codigo);
	    	}
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}