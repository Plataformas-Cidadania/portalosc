<?php

namespace App\Services\Usuario;

use App\Services\Service;
use App\Models\Model;
use App\Dao\Usuario\UsuarioDao;

class CriarAssinanteNewsletterService extends Service
{
    public function executar()
    {
        $estrutura = array(
	        'tx_email_usuario' => [
                'apelidos' => ['tx_email_usuario', 'email_usuario', 'emailUsuario', 'email'], 
                'obrigatorio' => true, 
                'tipo' => 'email'
            ],
            'tx_nome_usuario' => [
                'apelidos' => ['tx_nome_usuario', 'nome_usuario', 'nomeUsuario', 'nome'], 
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