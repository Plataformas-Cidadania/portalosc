<?php

namespace App\Services\Analises\ObterBarraTransparenciaOsc;

use App\Services\BaseService;
use App\Dao\Analises\BarraTransparenciaOscDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
	    
	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
	    	$barraTransparenciaOsc = (new BarraTransparenciaOscDao())->obterBarraTransparenciaOsc($requisicao->id_osc);
	    	
	    	if($barraTransparenciaOsc){
	    		$this->resposta->prepararResposta($barraTransparenciaOsc, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a barra de transparência desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}