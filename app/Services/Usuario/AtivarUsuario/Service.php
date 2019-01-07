<?php

namespace App\Services\Usuario\AtivarUsuario;

use App\Services\BaseService;
use App\Dao\Usuario\UsuarioDao;
use App\Email\BemVindoRepresentanteOscEmail;
use App\Email\BemVindoRepresentanteGovernoEmail;
use App\Enums\TipoUsuarioEnum;

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
                $resultadoUsuarioAtivacaoDao = $usuarioDao->obterUsuarioParaAtivacao($resultadoTokenDao->id_usuario);
                
                if($resultadoUsuarioAtivacaoDao->cd_tipo_usuario == TipoUsuarioEnum::OSC){
                    $resultadoAtivacaoDao = $usuarioDao->ativarRepresentanteOsc($resultadoTokenDao->id_usuario);
                    if($resultadoAtivacaoDao->flag){
                    	$assuntoEmail = 'Usuário ativado no Mapa das Organizações da Sociedade Civil';
                    	$bemVindoEmail = (new BemVindoRepresentanteGovernoEmail)->enviar($resultadoUsuarioAtivacaoDao->tx_email_usuario, $assuntoEmail, $resultadoUsuarioAtivacaoDao->tx_nome_usuario);
                    	$resultadoExclusaoTokenDao = $usuarioDao->excluirTokenUsuario($resultadoTokenDao->id_token);
                    	
                    	$this->resposta->prepararResposta(['msg' => $resultadoAtivacaoDao->mensagem], 200);
                    }else{
                    	$this->resposta->prepararResposta(['msg' => $resultadoAtivacaoDao->mensagem], 400);
                    }
                }else if($resultadoUsuarioAtivacaoDao->cd_tipo_usuario == TipoUsuarioEnum::GOVERNO_MUNICIPAL || $resultadoUsuarioAtivacaoDao->cd_tipo_usuario == TipoUsuarioEnum::GOVERNO_ESTADUAL){
                    $usuario = $this->requisicao->getUsuario();
                    
                    if($this->verificarAdministrador()){
                        $resultadoAtivacaoDao = $usuarioDao->ativarRepresentanteGoverno($resultadoTokenDao->id_usuario);
                        if($resultadoAtivacaoDao->flag){
                    		$assuntoEmail = 'Usuário ativado no Mapa das Organizações da Sociedade Civil';
                    		$bemVindoEmail = (new BemVindoRepresentanteOscEmail)->enviar($resultadoUsuarioAtivacaoDao->tx_email_usuario, $assuntoEmail, $resultadoUsuarioAtivacaoDao->tx_nome_usuario);
                        	$resultadoExclusaoTokenDao = $usuarioDao->excluirTokenUsuario($resultadoTokenDao->id_token);
                        	
                        	$this->resposta->prepararResposta(['msg' => $resultadoAtivacaoDao->mensagem], 200);
                        }else{
                        	$this->resposta->prepararResposta(['msg' => $resultadoAtivacaoDao->mensagem], 400);
                        }
                    }
                }else{
                    $this->resposta->prepararResposta(['msg' => 'Não é possível ativar este usuário.'], 400);
                }
            }
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
    
    private function verificarAdministrador()
    {
        $resultado = false;
        
        $usuario = $this->requisicao->getUsuario();
        if(property_exists($usuario, 'tipo_usuario')){
            if($usuario->tipo_usuario == TipoUsuarioEnum::ADMINISTRADOR){
                $resultado = true;
            }
        }
        
        if($resultado == false){
            $this->resposta->prepararResposta(['msg' => 'Para ativar este usuário é necessário entrar com o perfíl administrador.'], 400);
        }
        
        return $resultado;
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