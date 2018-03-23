<?php

namespace App\Services\Usuario\SolicitarAlteracaoSenha;

use App\Services\BaseService;
use App\Dao\Usuario\UsuarioDao;
use App\Email\AlteracaoSenhaUsuarioEmail;

class Service extends BaseService
{
    public function executar()
    {
        $requisicao = $this->requisicao->getConteudo();
		$modelo = new Model($requisicao);
	    
	    if($modelo->obterCodigoResposta() === 200){
            $requisicao = $modelo->obterRequisicao();
            
            $usuarioDao = new UsuarioDao();
            $resultadoUsuarioDao = $usuarioDao->obterUsuarioParaTrocaSenha($requisicao->tx_email_usuario);
            
            if($resultadoUsuarioDao){
                $token = md5($resultadoUsuarioDao->nr_cpf_usuario . time());
                $dataExpiracaoToken = date('Y-m-d', strtotime('+24 hours'));
                
                $resultadoTokenDao = $usuarioDao->criarTokenUsuario($resultadoUsuarioDao->id_usuario, $token, $dataExpiracaoToken);
                
                if($resultadoTokenDao->flag){
                    $tituloEmail = 'Solicitação de troca de senha do Mapa das Organizações da Sociedade Civil';
                    
                    $alteracaoSenhaEmail = (new AlteracaoSenhaUsuarioEmail())->enviar($requisicao->tx_email_usuario, $tituloEmail, $resultadoUsuarioDao->tx_nome_usuario, $token);
                    
                    if($alteracaoSenhaEmail){
                        $this->resposta->prepararResposta(['msg' => 'Foi enviado um e-mail para a troca da senha.'], 200);
                    }else{
                        $this->resposta->prepararResposta(['msg' => 'Ocorreu um erro no envio do e-mail para a troca da senha.'], 500);
                    }
                }else{
                    $this->resposta->prepararResposta(['msg' => $resultadoTokenDao->mensagem], 400);
                }
            }else{
                $this->resposta->prepararResposta(['msg' => 'Não há usuário cadastrado com este e-mail.'], 401);
            }
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
}