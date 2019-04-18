<?php

namespace App\Services\Usuario\CriarAssinanteNewsletter;

use App\Services\BaseService;
use App\Dao\Usuario\UsuarioDao;

class Service extends BaseService
{
    public function executar()
    {
        $requisicao = $this->requisicao->getConteudo();
		$modelo = new Model($requisicao);
	    
	    if($modelo->obterCodigoResposta() === 200){
            $requisicao = $modelo->obterRequisicao();
            $resultadoDao = (new UsuarioDao())->criarAssinanteNewsletter($requisicao);
            
            if($resultadoDao->flag){
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 201);
            }else{
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
            }
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
}