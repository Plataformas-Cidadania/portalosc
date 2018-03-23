<?php

namespace App\Services\Usuario\EnviarContato;

use App\Services\BaseService;
use App\Email\ContatoEmail;

class Service extends BaseService
{
    public function executar()
    {
	    $requisicao = $this->requisicao->getConteudo();
		$modelo = new Model($requisicao);
	    
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
