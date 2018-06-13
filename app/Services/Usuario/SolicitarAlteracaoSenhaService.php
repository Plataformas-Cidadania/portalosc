<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;
use App\Email\AlteracaoSenhaUsuarioEmail;

class SolicitarAlteracaoSenhaService extends Service
{
    public function executar()
    {
        $contrato = [
            'tx_email_usuario' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'email']
        ];
        
        $model = new Model($contrato, $this->requisicao->getConteudo());
        $flagModel = $this->analisarModel($model);
        
        if($flagModel){
            $requisicao = $model->getRequisicao();
            
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
                        //$this->resposta->prepararResposta(['msg' => 'Ocorreu um erro no envio do e-mail para a troca da senha.'], 500);
                        $this->resposta->prepararResposta(['msg' => 'Ocorreu um erro no envio do e-mail para a troca da senha.'], 200);
                    }
                }else{
                    //$this->resposta->prepararResposta(['msg' => $resultadoTokenDao->mensagem], 400);
                    $this->resposta->prepararResposta(['msg' => $resultadoTokenDao->mensagem], 200);
                }
            }else{
                //$this->resposta->prepararResposta(['msg' => 'Não há usuário cadastrado com este e-mail.'], 403);
                $this->resposta->prepararResposta(['msg' => 'Não há usuário cadastrado com este e-mail.'], 200);
            }
        }else{
            //$this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), 200);
        }
    }
}
