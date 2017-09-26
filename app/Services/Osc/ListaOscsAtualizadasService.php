<?php

namespace App\Services\Osc;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\OscDao;

class ListaOscsAtualizadasService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'limit' => ['apelidos' => ['limit', 'quantidade'], 'obrigatorio' => false, 'tipo' => 'integer']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	    	$requisicao = $model->getRequisicao();
	    	$barraTransparenciaOsc = (new OscDao())->obterBarraTransparenciaOsc($model->getRequisicao()->id_osc);
	    	
	    	if($barraTransparenciaOsc){
	    		$this->resposta->prepararResposta($barraTransparenciaOsc, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a barra de transparência desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }
	}
}
