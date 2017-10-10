<?php

namespace App\Services\Osc;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\OscDao;

class ObterDataAtualizacaoService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'id_osc' => ['apelidos' => NomenclaturaAtributoEnum::ID_OSC, 'obrigatorio' => true, 'tipo' => 'numeric']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	    	$requisicao = $model->getRequisicao();
	    	$dataAtualizacaoOsc = (new OscDao())->obterDataAtualizacao($model->getRequisicao()->id_osc);
	    	
	    	if($dataAtualizacaoOsc){
	    	    $this->resposta->prepararResposta($dataAtualizacaoOsc, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a atualização desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }
	}
}
