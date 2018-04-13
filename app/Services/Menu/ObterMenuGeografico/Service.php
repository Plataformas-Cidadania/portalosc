<?php

namespace App\Services\Menu\ObterMenuGeografico;

use App\Services\BaseService;
use App\Services\BaseModel;
use App\Dao\MenuDao;

class Service extends BaseService
{
	public function executar()
	{
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
		
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