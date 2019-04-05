<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;
use App\Email\InformeCadastroRepresentanteGovernoIpeaEmail;

class SolicitarAtivacaoRepresentanteGovernoService extends Service
{
	public function executar()
	{
		$contrato = [
				'tx_token' => ['apelidos' => NomenclaturaAtributoEnum::TOKEN, 'obrigatorio' => true, 'tipo' => 'string']
		];
		
		$model = new Model($contrato, $this->requisicao->getConteudo());
		$flagModel = $this->analisarModel($model);
		
		if($flagModel){
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
		}
	}
}
