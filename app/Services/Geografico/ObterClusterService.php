<?php

namespace App\Services\Geografico;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\GeograficoDao;

class ObterClusterService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'tipo_regiao' => ['apelidos' => NomenclaturaAtributoEnum::TIPO_REGIAO, 'obrigatorio' => true, 'tipo' => 'string', 'default' => ''],
	        'id_regiao' => ['apelidos' => NomenclaturaAtributoEnum::ID_REGIAO, 'obrigatorio' => true, 'tipo' => 'integer', 'default' => 0]
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	        $requisicao = $model->getRequisicao();
	        $geolocalizacaoOsc = (new GeograficoDao())->obterCluster($requisicao->tipo_regiao, $requisicao->id_regiao);
    	    
	        $this->resposta->prepararResposta($geolocalizacaoOsc, 200);
	    }
	}
}
