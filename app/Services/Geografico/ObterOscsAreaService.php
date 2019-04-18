<?php

namespace App\Services\Geografico;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\GeograficoDao;

class ObterOscsAreaService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'norte' => ['apelidos' => ['norte'], 'obrigatorio' => true, 'tipo' => 'float'],
	        'sul' => ['apelidos' => ['sul'], 'obrigatorio' => true, 'tipo' => 'float'],
	        'leste' => ['apelidos' => ['leste'], 'obrigatorio' => true, 'tipo' => 'float'],
	        'oeste' => ['apelidos' => ['oeste'], 'obrigatorio' => true, 'tipo' => 'float']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	        $requisicao = $model->getRequisicao();
	        $geolocalizacaoOsc = (new GeograficoDao())->obterGeolocalizacaoOscsArea($requisicao->norte, $requisicao->sul, $requisicao->leste, $requisicao->oeste);
    	    
	        $this->resposta->prepararResposta($geolocalizacaoOsc, 200);
	    }
	}
}
