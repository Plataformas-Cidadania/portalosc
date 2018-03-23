<?php

namespace App\Services\Osc;

use App\Services\BaseService;
use App\Services\BaseModel;
use App\Dao\OscDao;

class ObterListaOscsAreaAtuacaoService extends BaseService
{
	public function executar()
	{
	    $estrutura = [
	        'area_atuacao' => [
				'apelidos' => ['area_atuacao', 'cd_area_atuacao', 'areaAtuacao'], 
				'obrigatorio' => true, 
				'tipo' => 'integer'
			],
	        'cd_municipio' => [
				'apelidos' => ['cd_municipio', 'municipio'], 
				'obrigatorio' => false, 
				'tipo' => 'integer'
			],
	        'latitude' => [
				'apelidos' => ['latitude', 'lat'], 
				'obrigatorio' => false, 
				'tipo' => 'double'
			],
	        'longitude' => [
				'apelidos' => ['longitude', 'long', 'lon', 'lng'], 
				'obrigatorio' => false, 
				'tipo' => 'double'
			],
	        'limite' => [
				'apelidos' => ['limite', 'limit', 'quantidade'], 
				'obrigatorio' => false, 
				'tipo' => 'integer'
			]
	    ];
	    
	    $requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
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
