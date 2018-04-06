<?php

namespace App\Services\Analises\ObterListaOscsAreaAtuacao;

use App\Services\BaseService;
use App\Dao\OscDao;

class Service extends BaseService
{
	public function executar()
	{
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
	    
	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
	    	
	    	if($requisicao->latitude && $requisicao->longitude){
	    	    $requisicao->geolocalizacao = '{' . $requisicao->latitude . ', ' . $requisicao->longitude . '}';
	    	}else{
	    	    $requisicao->geolocalizacao = null;
	    	}
	    	
	    	$listaOscs = (new OscDao())->obterListaOscsAreaAtuacao($requisicao->area_atuacao, $requisicao->geolocalizacao, $requisicao->cd_municipio, $requisicao->limite);
	    	
	    	/*
	    	if($listaOscs){
	    	    $this->resposta->prepararResposta($listaOscs, 200);
	    	}else{
	    		$this->resposta->prepararResposta(null, 204);
	    	}
	    	*/
	    	
	    	$this->resposta->prepararResposta($listaOscs, 200);
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}
