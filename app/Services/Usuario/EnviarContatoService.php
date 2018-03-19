<?php

namespace App\Services\Usuario;

use App\Services\Service;
use App\Models\Model;
use App\Email\ContatoEmail;

class EnviarContatoService extends Service
{
    public function executar()
    {
	    $estrutura = array(
	        'tx_nome_usuario' => [
                'apelidos' => ['nome', 'nome_usuario', 'tx_nome_usuario'], 
                'obrigatorio' => true, 
                'tipo' => 'string'
            ],
       		'tx_email_usuario' => [
                'apelidos' => ['email', 'email_usuario', 'tx_email_usuario'], 
                'obrigatorio' => true, 
                'tipo' => 'email'
            ],
            'tx_assunto' => [
                'apelidos' => ['assunto', 'tx_assunto'], 
                'obrigatorio' => true, 
                'tipo' => 'string'
            ],
       		'tx_mensagem' => [
                'apelidos' => ['mensagem', 'tx_mensagem'], 
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
            
            $emailIpea = 'mapaosc@ipea.gov.br';
            
            $resultadoEmail = (new ContatoEmail())->enviar($emailIpea, $requisicao->tx_assunto, $requisicao->tx_mensagem, $requisicao->tx_nome_usuario, $requisicao->tx_email_usuario);
            
            if($resultadoEmail){
            	$this->resposta->prepararResposta(['msg' => 'Foi enviado um e-mail de contato.'], 200);
            }else{
            	$this->resposta->prepararResposta(['msg' => 'Ocorreu um erro no envio do e-mail de contato.'], 500);
            }
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
}
