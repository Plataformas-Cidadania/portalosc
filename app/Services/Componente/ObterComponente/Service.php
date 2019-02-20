<?php

namespace App\Services\Componente\ObterComponente;

use App\Services\BaseService;
use App\Dao\Componente\ComponenteDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
		
		if($modelo->obterCodigoResposta() === 200){
	        $requisicao = $modelo->obterRequisicao();
	        $resultadoDao = (new ComponenteDao())->obterComponente($requisicao->componente, $requisicao->parametro);
    	    
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