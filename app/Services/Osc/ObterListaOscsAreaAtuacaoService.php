<?php

namespace App\Services\Osc;

use App\Services\Service;
use App\Services\Model;
use App\Dao\OscDao;

class ObterListaOscsAreaAtuacaoService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'area_atuacao' => ['apelidos' => ['area_atuacao', 'cd_area_atuacao', 'areaAtuacao'], 'obrigatorio' => true, 'tipo' => 'integer'],
	        'cd_municipio' => ['apelidos' => ['cd_municipio', 'municipio'], 'obrigatorio' => false, 'tipo' => 'integer'],
	        'latitude' => ['apelidos' => ['latitude'], 'obrigatorio' => false, 'tipo' => 'float'],
	        'longitude' => ['apelidos' => ['longitude'], 'obrigatorio' => false, 'tipo' => 'float'],
	        'limit' => ['apelidos' => ['limit', 'quantidade'], 'obrigatorio' => false, 'tipo' => 'integer']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	    	$requisicao = $model->getRequisicao();
	    	
	    	if($requisicao->latitude && $requisicao->longitude){
	    	    $requisicao->geolocalizacao = '{' . $requisicao->latitude . ', ' . $requisicao->longitude . '}';
	    	}else{
	    	    $requisicao->geolocalizacao = null;
	    	}
	    	
	    	$listaOscs = (new OscDao())->obterListaOscsAreaAtuacao($requisicao->area_atuacao, $requisicao->geolocalizacao, $requisicao->cd_municipio, $requisicao->limit);
	    	
	    	/*
	    	if($listaOscs){
	    	    $this->resposta->prepararResposta($listaOscs, 200);
	    	}else{
	    		$this->resposta->prepararResposta(null, 204);
	    	}
	    	*/
	    	
	    	$this->resposta->prepararResposta($listaOscs, 200);
	    }
	}
}
