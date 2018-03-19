<?php

namespace App\Services\Menu;

use App\Services\Service;
use App\Models\Model;
use App\Dao\MenuDao;

class ObterMenuGeograficoService extends Service
{
	public function executar()
	{
	    $estrutura = array(
	        'tipo_regiao' => [
				'apelidos' => ['tipo_regiao'], 
				'obrigatorio' => true, 
				'tipo' => 'string'
			],
	        'parametro' => [
				'apelidos' => ['parametro'], 
				'obrigatorio' => true, 
				'tipo' => 'string'
			],
	        'limit' => [
				'apelidos' => ['limit'], 
				'obrigatorio' => true, 
				'tipo' => 'string'
			],
	        'offset' => [
				'apelidos' => ['offset'], 
				'obrigatorio' => true, 
				'tipo' => 'string'
			]
		);
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
	    if($modelo->obterCodigoResposta() === 200){
	        $requisicao = $modelo->obterRequisicao();
	        $resultadoDao = (new MenuDao())->obterMenuGeografico($requisicao->tipo_regiao, $requisicao->parametro, $requisicao->limit, $requisicao->offset);
	        
	        if($resultadoDao){
	            $this->resposta->prepararResposta($resultadoDao, 200);
	        }else{
	            $mensagem = 'Este menu não existe ou não contém dados cadastrados no banco de dados.';
	            $this->resposta->prepararResposta(['msg' => $mensagem], 400);
	        }
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}