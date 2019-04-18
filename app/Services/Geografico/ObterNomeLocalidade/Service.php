<?php

namespace App\Services\Geografico\ObterNomeLocalidade;

use App\Services\BaseService;
use App\Dao\Geografico\GlossarioDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
		
		if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
	    	if(in_array($requisicao->tipo_regiao, ['regiao', 'estado', 'municipio'])){
		        $nomeLocalidade = (new GlossarioDao())->obterNomeLocalidade($requisicao->tipo_regiao, $requisicao->latitude, $requisicao->longitude);
	    	    
		        $this->resposta->prepararResposta($nomeLocalidade, 200);
	    	}else{
	    		$this->resposta->prepararResposta(['msg' => 'Não existe este tipo de região.'], 403);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}