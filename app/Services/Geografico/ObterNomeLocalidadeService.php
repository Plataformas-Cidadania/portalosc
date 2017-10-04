<?php

namespace App\Services\Geografico;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\GeograficoDao;

class ObterNomeLocalidadeService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'tipo_regiao' => ['apelidos' => NomenclaturaAtributoEnum::TIPO_REGIAO, 'obrigatorio' => true, 'tipo' => 'string'],
	        'latitude' => ['apelidos' => NomenclaturaAtributoEnum::LATITUDE, 'obrigatorio' => true, 'tipo' => 'float'],
	    	'longitude' => ['apelidos' => NomenclaturaAtributoEnum::LONGITUDE, 'obrigatorio' => true, 'tipo' => 'float']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	        $requisicao = $model->getRequisicao();
	        $nomeLocalidade = (new GeograficoDao())->obterNomeLocalidade($requisicao->tipo_regiao, $requisicao->latitude, $requisicao->longitude);
    	    
	        $this->resposta->prepararResposta($nomeLocalidade, 200);
	    }
	}
}
