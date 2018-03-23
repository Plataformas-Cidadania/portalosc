<?php

namespace App\Services\Usuario\SolicitarAtivacaoRepresentanteGoverno;

use App\Services\BaseService;
use App\Dao\Usuario\UsuarioDao;
use App\Email\InformeCadastroRepresentanteGovernoIpeaEmail;

class Service extends BaseService
{
	public function executar()
	{
		$requisicao = $this->requisicao->getConteudo();
		$modelo = new Model($requisicao);
	    
	    if($modelo->obterCodigoResposta() === 200){
			$this->resposta->prepararResposta(['msg' => 'Este serviço não está implementado.'], 400);

			/*
			$usuarioDao = new UsuarioDao();
			
			$confirmacaoEmail = $usuarioDao->confirmarEmailUsuario($resultadoTokenDao->id_usuario);
			
			if($confirmacaoEmail->flag){
				$token = $usuarioDao->obterDadosToken($requisicao->tx_token);
				$usuario = $usuarioDao->obterUsuarioParaAtivacao($token->id_usuario);
				
				$tituloEmail = 'Notificação de cadastro de representante de governo no Mapa das Organizações da Sociedade Civil';
				$emailIpea = 'mapaosc@ipea.gov.br';
				$ativacaoEmail = (new InformeCadastroRepresentanteGovernoIpeaEmail())->enviar($emailIpea, $tituloEmail, $usuario->tx_nome_usuario, $usuario);
				
				$this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 200);
			}else{
				$this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
			}
			*/
		}else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}