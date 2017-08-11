<?php

namespace App\Services\Geografico;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\GeograficoDao;

class ObterOscService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'id_osc' => ['apelidos' => NomenclaturaAtributoEnum::ID_OSC, 'obrigatorio' => true, 'tipo' => 'integer']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	        $requisicao = $model->getRequisicao();
	        $geolocalizacaoOsc = (new GeograficoDao())->obterGeolocalizacaoOsc($requisicao->id_osc);
    	    
	        $this->resposta->prepararResposta($geolocalizacaoOsc, 200);
	    }
	}
}
