<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\OscDao;
use App\Dao\UsuarioDao;

class EditarRepresentanteOscService extends Service
{
	public function executar()
	{
		$contrato = [
			'id_usuario' => ['apelidos' => NomenclaturaAtributoEnum::ID_USUARIO, 'obrigatorio' => true, 'tipo' => 'numeric'],
			'tx_email_usuario' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'email'],
			'tx_senha_usuario' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'string'],
			'tx_nome_usuario' => ['apelidos' => NomenclaturaAtributoEnum::NOME_USUARIO, 'obrigatorio' => true, 'tipo' => 'string'],
			'representacao' => ['apelidos' => NomenclaturaAtributoEnum::REPRESENTACAO, 'obrigatorio' => true, 'tipo' => 'arrayArray']
		];
		
		$model = new Model($contrato, $this->requisicao->getConteudo());
		$flagModel = $this->analisarModel($model);
		
		if($flagModel){
			$requisicao = $model->getRequisicao();
			
			$usuarioDao = new UsuarioDAO();
			
			$representacao = $usuarioDao->obterIdOscsDeRepresentante($requisicao->id_usuario);
			
			$representacaoRequisicao = array_map(function($o) { return $o['id_osc']; }, $requisicao->representacao);
			$representacaoExistente = array_map(function($o) { return $o->id_osc; }, $representacao);
			
			$oscsInsert = array_diff($representacaoRequisicao, $representacaoExistente);
			$oscsDelete = array_diff($representacaoExistente, $representacaoRequisicao);
			
			$edicaoRepresentanteOsc = $usuarioDao->editarRepresentanteOsc($requisicao, $oscsInsert, $oscsDelete);
			
			if($edicaoRepresentanteOsc->flag){
			    if($oscsInsert){
			        $cpfUsuario = $usuarioDao->obterCpfUsuario($requisicao->id_usuario)->nr_cpf_usuario;
			        $nomeEmailOscs = (new OscDao())->obterNomeEmailOscs($oscsInsert);
					
			        foreach($nomeEmailOscs as $osc) {
						$osc = ['nomeOsc' => $osc->tx_nome_osc, 'emailOsc' => $osc->tx_email];
						$user = ['nome' => $requisicao->tx_nome_usuario, 'email' => $requisicao->tx_email_usuario, 'cpf' => $cpfUsuario];
						$emailIpea = 'mapaosc@ipea.gov.br';
						
						/*
						 * TODO: Enviar e-mails
						 */
						/*
						if($osc->tx_email){
							$message = $this->email->informationOSC($user, $nomeOsc);
							$this->email->send($emailOsc, "Notificação de cadastro no Mapa das Organizações da Sociedade Civil", $message);
							
							$message = $this->email->informationIpea($user, $osc);
							$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil", $message);
						}else{
							$message = $this->email->informationIpea($user, $osc);
							$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil", $message);
						}
						*/
					}
					
					$conteudoResposta = $this->configurarConteudoRespota($representacaoRequisicao);
					$conteudoResposta->msg = $edicaoRepresentanteOsc->mensagem;
					
					$this->resposta->prepararResposta($conteudoResposta, 200);
			    }else{
			        $conteudoResposta = $this->configurarConteudoRespota($representacaoRequisicao);
			        $conteudoResposta->msg = $edicaoRepresentanteOsc->mensagem;
			        
			        $this->resposta->prepararResposta($conteudoResposta, 200);
				}
			}else{
			    $this->resposta->prepararResposta(['msg' => $edicaoRepresentanteOsc->mensagem], 400);
			}
		}
	}
	
	public function configurarConteudoRespota($representacao) {
	    $requisicao = $this->requisicao->getConteudo();
	    $usuario = $this->requisicao->getUsuario();
	    
	    $tempoExpiracaoToken = strtotime('+15 minutes');
	    
	    $token = $usuario->id_usuario . '_' . $usuario->tipo_usuario . '_' . $usuario->localidade . '_' . $tempoExpiracaoToken;
	    $token = openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
	    
	    $conteudo = new \stdClass;
	    $conteudo->id_usuario = $usuario->id_usuario;
	    $conteudo->tx_nome_usuario = $requisicao->tx_nome_usuario;
	    $conteudo->cd_tipo_usuario = $usuario->tipo_usuario;
	    $conteudo->representacao = $representacao;
	    $conteudo->access_token = $token;
	    $conteudo->token_type = 'Bearer';
	    $conteudo->expires_in = $tempoExpiracaoToken;
	    
	    return $conteudo;
	}
}