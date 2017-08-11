<?php

namespace App\Services\Menu;

use App\Services\Service;
use App\Services\Model;
use App\Dao\MenuDao;

class ObterMenuGeograficoService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'tipo_regiao' => ['apelidos' => ['tipo_regiao'], 'obrigatorio' => true, 'tipo' => 'string'],
	        'parametro' => ['apelidos' => ['parametro'], 'obrigatorio' => true, 'tipo' => 'string'],
	        'limit' => ['apelidos' => ['limit'], 'obrigatorio' => true, 'tipo' => 'string'],
	        'offset' => ['apelidos' => ['offset'], 'obrigatorio' => true, 'tipo' => 'string']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	        $requisicao = $model->getRequisicao();
	        $resultadoDao = (new MenuDao())->obterMenuGeografico($requisicao->tipo_regiao, $requisicao->parametro, $requisicao->limit, $requisicao->offset);
	        
	        if($resultadoDao){
	            $this->resposta->prepararResposta($resultadoDao, 200);
	        }else{
	            $mensagem = 'Este menu não existe ou não contém dados cadastrados no banco de dados.';
	            $this->resposta->prepararResposta(['msg' => $mensagem], 400);
	        }
	    }
	}
}
