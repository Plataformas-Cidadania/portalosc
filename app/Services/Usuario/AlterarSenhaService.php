<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;
use App\Email\AlteracaoSenhaUsuario;

class AlterarSenhaService extends Service
{
    public function executar()
    {
        $contrato = [
            'tx_senha_usuario' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'senha'],
            'tx_token' => ['apelidos' => NomenclaturaAtributoEnum::TOKEN, 'obrigatorio' => true, 'tipo' => 'string']
        ];
        
        $model = new Model($contrato, $this->requisicao->getConteudo());
        $flagModel = $this->analisarModel($model);
        
        if($flagModel){
            $requisicao = $model->getRequisicao();
            
            $usuarioDao = new UsuarioDao();
            $resultadoTokenDao = $usuarioDao->obterDadosToken($requisicao->tx_token);
            
            if($resultadoTokenDao){
                $dataExpiracaoToken = date_create($resultadoTokenDao->dt_data_expiracao_token);
                $dataExpiracaoToken = date_format($dataExpiracaoToken, "Y-m-d");
                $dataAtual = date("Y-m-d");
                
                if($dataAtual <= $dataExpiracaoToken){
                    $requisicao->id_usuario = $resultadoTokenDao->id_usuario;
                    $resultadoAlterarSenhaDao = $usuarioDao->alterarSenhaUsuario($requisicao);
                    
                    if($resultadoAlterarSenhaDao->flag){
                        $resultadoExcluirTokenDao = $usuarioDao->excluirTokenUsuario($resultadoTokenDao->id_token);
                        
                        $this->resposta->prepararResposta(['msg' => $resultadoAlterarSenhaDao->mensagem], 200);
                    }else{
                        $this->resposta->prepararResposta(['msg' => $resultadoAlterarSenhaDao->mensagem], 400);
                    }
                }else{
                    $this->resposta->prepararResposta(['msg' => 'Este token está expirado.'], 400);
                }
            }else{
                $this->resposta->prepararResposta(['msg' => 'Este token é inválido.'], 401);
            }
        }
    }
}
