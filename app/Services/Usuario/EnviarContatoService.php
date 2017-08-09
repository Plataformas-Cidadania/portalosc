<?php

namespace App\Services\Usuario;

use App\Services\Service;
use App\Services\Model;
use App\Email\ContatoEmail;

class EnviarContatoService extends Service
{
    public function executar()
    {
        $contrato = [
       		'tx_nome_usuario' => ['apelidos' => ['nome', 'nome_usuario', 'tx_nome_usuario'], 'obrigatorio' => true, 'tipo' => 'string'],
       		'tx_email_usuario' => ['apelidos' => ['email', 'email_usuario', 'tx_email_usuario'], 'obrigatorio' => true, 'tipo' => 'email'],
            'tx_assunto' => ['apelidos' => ['assunto', 'tx_assunto'], 'obrigatorio' => true, 'tipo' => 'string'],
       		'tx_mensagem' => ['apelidos' => ['mensagem', 'tx_mensagem'], 'obrigatorio' => true, 'tipo' => 'string']
        ];
        
        $model = new Model($contrato, $this->requisicao->getConteudo());
        $flagModel = $this->analisarModel($model);
        
        if($flagModel){
            $requisicao = $model->getRequisicao();
            
            $emailIpea = 'mapaosc@ipea.gov.br';
            
            $contatoEmail = new ContatoEmail();
            $conteudoEmail = $contatoEmail->obterConteudo($requisicao->tx_nome_usuario, $requisicao->tx_email_usuario, $requisicao->tx_mensagem);
            $resultadoEmail = $contatoEmail->enviarEmail($emailIpea, $requisicao->tx_assunto, $conteudoEmail);
            
            if($resultadoEmail){
            	$this->resposta->prepararResposta(['msg' => 'Foi enviado um e-mail de contato.'], 200);
            }else{
            	$this->resposta->prepararResposta(['msg' => 'Ocorreu um erro no envio do e-mail de contato.'], 500);
            }
        }
    }
}
