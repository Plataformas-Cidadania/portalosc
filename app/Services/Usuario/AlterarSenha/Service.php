<?php

namespace App\Services\Usuario\AlterarSenha;

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
            
            $usuarioDao = new UsuarioDao();
            $resultadoTokenDao = $usuarioDao->obterDadosToken($requisicao->tx_token);
            $analiseToken = $this->analisarToken($resultadoTokenDao);
            
            if($analiseToken){
                $requisicao->id_usuario = $resultadoTokenDao->id_usuario;
                $resultadoAlterarSenhaDao = $usuarioDao->alterarSenhaUsuario($requisicao);
                
                if($resultadoAlterarSenhaDao->flag){
                    $resultadoExcluirTokenDao = $usuarioDao->excluirTokenUsuario($resultadoTokenDao->id_token);
                    
                    $this->resposta->prepararResposta(['msg' => $resultadoAlterarSenhaDao->mensagem], 200);
                }else{
                    $this->resposta->prepararResposta(['msg' => $resultadoAlterarSenhaDao->mensagem], 400);
                }
            }
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
    
    private function analisarToken($token)
    {
        $resultado = false;
        
        if($token){
            $dataExpiracaoToken = date_create($token->dt_data_expiracao_token);
            $dataExpiracaoToken = date_format($dataExpiracaoToken, "Y-m-d");
            $dataAtual = date("Y-m-d");
            
            if($dataAtual <= $dataExpiracaoToken){
                $resultado = true;
            }else{
                $this->resposta->prepararResposta(['msg' => 'Este token está expirado.'], 400);
            }
        }else{
            $this->resposta->prepararResposta(['msg' => 'Este token é inválido.'], 401);
        }
        
        return $resultado;
    }
}