<?php

namespace App\Services\Osc;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\OscDao;

class ObterListaOscsAtualizadasService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'limit' => ['apelidos' => ['limit', 'quantidade'], 'obrigatorio' => false, 'tipo' => 'integer']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	    	$listaOscs = (new OscDao())->obterListaOscsAtualizadas($model->getRequisicao()->limit);
	    	
	    	if($listaOscs){
	    	    $this->resposta->prepararResposta($listaOscs, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre atualizações de OSCs no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }
	}
}
