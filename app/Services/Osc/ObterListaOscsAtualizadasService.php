<?php

namespace App\Services\Osc;

use App\Services\Service;
use App\Models\Model;
use App\Dao\OscDao;

class ObterListaOscsAtualizadasService extends Service
{
	public function executar()
	{
	    $estrutura = [
	        'limit' => [
				'apelidos' => ['limite', 'limit', 'quantidade'], 
				'obrigatorio' => false, 
				'tipo' => 'integer'
			]
	    ];
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
	    	$listaOscs = (new OscDao())->obterListaOscsAtualizadas($requisicao->limit);
	    	
	    	if($listaOscs){
	    	    $this->resposta->prepararResposta($listaOscs, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre atualizações de OSCs no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}