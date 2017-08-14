<?php

namespace App\Services\Menu;

use App\Services\Service;
use App\Services\Model;
use App\Dao\MenuDao;

class ObterMenuOscService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'menu' => ['apelidos' => ['menu'], 'obrigatorio' => true, 'tipo' => 'string'],
	        'parametro' => ['apelidos' => ['parametro'], 'obrigatorio' => false, 'tipo' => 'string']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	        $requisicao = $model->getRequisicao();
	        $resultadoDao = (new MenuDao())->obterMenuOsc($requisicao->menu, $requisicao->parametro);
    	    
	        if($resultadoDao){
                $this->resposta->prepararResposta($resultadoDao, 200);
	        }else{
	            $mensagem = 'Este menu não existe ou não contém dados cadastrados no banco de dados.';
	            $this->resposta->prepararResposta(['msg' => $mensagem], 400);
	        }
        }
	}
}
