<?php

namespace App\Services\Analises\ObterListaOscsAtualizadas;

use App\Services\BaseService;
use App\Dao\OscDao;

class Service extends BaseService
{
	public function executar()
	{
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
	    
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