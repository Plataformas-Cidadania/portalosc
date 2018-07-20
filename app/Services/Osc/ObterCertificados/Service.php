<?php

namespace App\Services\Osc\ObterCertificados;

use App\Services\BaseService;
use App\Dao\Osc\CertificadoDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);

	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
			$resultadoDao = (new CertificadoDao())->obterCertificados($requisicao);
	    	
	    	if($resultadoDao){
				if($resultadoDao->id_certificado === null){
					$this->resposta->prepararResposta([], 200);
				}else{
					$this->resposta->prepararResposta($resultadoDao, 200);
				}
	    	}else{
	    		$mensagem = 'Não existe dados sobre a atualização desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}