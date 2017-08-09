<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\OscDao;
use App\Dao\UsuarioDao;
use App\Email\InformeCadastroRepresentanteOscEmail;
use App\Email\InformeCadastroRepresentanteOscIpeaEmail;

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
			        $requisicao->nr_cpf_usuario = $cpfUsuario;
			        
			        $nomeEmailOscs = (new OscDao())->obterNomeEmailOscs($oscsInsert);
					
			        foreach($nomeEmailOscs as $osc) {
			            $emailIpea = 'mapaosc@ipea.gov.br';
			            $tituloEmail = 'Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil';
			            
			            if($osc->tx_email){
			            	$informeIpeaEmail = (new InformeCadastroRepresentanteOscIpeaEmail())->obterConteudo($emailIpea, $tituloEmail, $requisicao, $osc);
			            	$informeOscEmail = (new InformeCadastroRepresentanteOscEmail())->obterConteudo($osc->tx_email, $tituloEmail, $requisicao, $osc->tx_nome_osc);
			            }else{
			            	$informeIpeaEmail = (new InformeCadastroRepresentanteOscIpeaEmail())->obterConteudo($emailIpea, $tituloEmail, $requisicao, $osc);
			            }
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