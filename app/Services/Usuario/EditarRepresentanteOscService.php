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
			
			$usuarioDao->setRequisicao($requisicao);
			$usuarioDao->obterIdOscsDeRepresentante();
			$this->separarOscs($requisicao, $usuarioDao->getResposta());
			
			$usuarioDao->setRequisicao($requisicao);
			$usuarioDao->editarRepresentanteOsc();
			$resultadoEditarDao = $usuarioDao->getResposta();
			
			if($resultadoEditarDao->flag){
				if($requisicao->representacao_insert){
					$usuarioDao->setRequisicao($requisicao);
					$usuarioDao->obterCpfUsuario();
					$requisicao->nr_cpf_usuario = $usuarioDao->getResposta()->nr_cpf_usuario;
					
					$requisicao->representacao = $requisicao->representacao_insert;
					$oscDao = new OscDao($requisicao);
					$oscDao->obterNomeEmailOscs();
					
					foreach($oscDao->getResposta() as $osc) {
						$osc = ['nomeOsc' => $osc->tx_nome_osc, 'emailOsc' => $osc->tx_email];
						$user = ['nome' => $requisicao->tx_nome_usuario, 'email' => $requisicao->tx_email_usuario, 'cpf' => $requisicao->nr_cpf_usuario];
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
					
					$this->resposta->prepararResposta(['msg' => $resultadoEditarDao->mensagem], 200);
				}else{
					$this->resposta->prepararResposta(['msg' => $resultadoEditarDao->mensagem], 200);
				}
			}else{
				$this->resposta->prepararResposta(['msg' => $resultadoEditarDao->mensagem], 400);
			}
		}
	}
	
	private function separarOscs($requisicao, $oscsUsuario)
	{

		$representacao_requisicao = array_map(function($o) { return $o['id_osc']; }, $requisicao->representacao);
		$representacao_existente = array_map(function($o) { return $o->id_osc; }, $oscsUsuario);
		
		$representacao_insert = array_diff($representacao_requisicao, $representacao_existente);
		$representacao_delete = array_diff($representacao_existente, $representacao_requisicao);
		
		$requisicao->representacao_insert = $representacao_insert;
		$requisicao->representacao_delete = $representacao_delete;
	}
	
	private function configContent($object){
		$cd_tipo_usuario = 2;
		$time_expires = strtotime('+15 minutes');
		
		$representacaoString = array();
		foreach($object['representacao'] as $key => $value){
			array_push($representacaoString, $value['id_osc']);
		}
		$representacaoString = str_replace(' ', '', implode(',', $representacaoString));
		
		$token = $object['id_usuario'].'_'.$cd_tipo_usuario.'_'.$representacaoString.'_'.$time_expires;
		$token = openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
		
		$content['id_usuario'] = $object['id_usuario'];
		$content['tx_nome_usuario'] = $object['tx_nome_usuario'];
		$content['cd_tipo_usuario'] = $cd_tipo_usuario;
		$content['representacao'] = '['.$representacaoString.']';
		$content['access_token'] = $token;
		$content['token_type'] = 'Bearer';
		$content['expires_in'] = $time_expires;
		
		return $content;
	}
}