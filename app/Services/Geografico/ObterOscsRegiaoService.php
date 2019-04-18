<?php

namespace App\Services\Geografico;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\GeograficoDao;

class ObterOscsRegiaoService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'tipo_regiao' => ['apelidos' => NomenclaturaAtributoEnum::TIPO_REGIAO, 'obrigatorio' => true, 'tipo' => 'string'],
	        'id_regiao' => ['apelidos' => NomenclaturaAtributoEnum::ID_REGIAO, 'obrigatorio' => true, 'tipo' => 'integer']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	        $requisicao = $model->getRequisicao();
	        $geolocalizacaoOsc = (new GeograficoDao())->obterGeolocalizacaoOscsRegiao($requisicao->tipo_regiao, $requisicao->id_regiao);
    	    
	        $this->resposta->prepararResposta($geolocalizacaoOsc, 200);
	    }
	}
}
