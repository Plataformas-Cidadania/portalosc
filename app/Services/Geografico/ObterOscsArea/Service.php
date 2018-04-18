<?php

namespace App\Services\Geografico\ObterOscsArea;

use App\Services\BaseService;
use App\Dao\Geografico\GeolocalizacaoDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
		
		if($modelo->obterCodigoResposta() === 200){
	        $requisicao = $modelo->obterRequisicao();
	        $geolocalizacaoOsc = (new GeolocalizacaoDao())->obterGeolocalizacaoOscsArea($requisicao->norte, $requisicao->sul, $requisicao->leste, $requisicao->oeste);
			
			if($geolocalizacaoOsc){
				$this->resposta->prepararResposta($geolocalizacaoOsc, 200);
			}else{
				$this->resposta->prepararResposta(null, 204);
			}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}