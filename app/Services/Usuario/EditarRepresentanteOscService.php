<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;

class EditarRepresentanteOscService extends Service
{
	public function executar($requisicao)
	{
		$contrato = [
				'id_usuario' => ['apelidos' => NomenclaturaAtributoEnum::ID_USUARIO, 'obrigatorio' => true, 'tipo' => 'numeric'],
				'tx_nome_usuario' => ['apelidos' => NomenclaturaAtributoEnum::NOME_USUARIO, 'obrigatorio' => true, 'tipo' => 'string'],
				'tx_email_usuario' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'email'],
				'tx_senha_usuario' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'string'],
				'representacao' => ['apelidos' => NomenclaturaAtributoEnum::REPRESENTACAO, 'obrigatorio' => true, 'tipo' => 'arrayObject']
		];
		
		$model = new Model($contrato, $requisicao->obterConteudo());
		$model->ajustarRequisicao();
		$model->validarRequisição();
		
		if($model->getDadosFantantes()){
			$this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) não enviado(s).'], 400);
		}else if($model->getDadosInvalidos()){
			$this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) inválido(s).'], 400);
		}else{
			$conteudoRequisicao = $model->getRequisicao();
			
			if(count($conteudoRequisicao['representacao']) < 1){
				$this->resposta->prepararResposta(['msg' => 'É necessário indicar ao menos uma OSC que o representa.'], 400);
			}else{
				$dao = new UsuarioDAO();
				$resultadoDao = $dao->editarRepresentanteOsc($model->getRequisicao());
				
				if($resultDao['status']){
					if($resultDao['nova_representacao']){
						foreach($resultDao['nova_representacao'] as $value) {
							$params_osc = [$value['id_osc']];
							
							$osc = ['nomeOsc' => $value['tx_razao_social_osc'], 'emailOsc' => $value['tx_email']];
							$user = ['nome' => $object['tx_nome_usuario'], 'email' => $object['tx_email_usuario'], 'cpf' => $resultDao['nr_cpf_usuario']];
							$emailIpea = "mapaosc@ipea.gov.br";
							
							if($value['tx_email'] == null){
								#$message = $this->email->informationIpea($user, $osc);
								#$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil", $message);
							}else{
								#$message = $this->email->informationOSC($user, $nomeOsc);
								#$this->email->send($emailOsc, "Notificação de cadastro no Mapa das Organizações da Sociedade Civil", $message);
								
								#$message = $this->email->informationIpea($user, $osc);
								#$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil", $message);
							}
						}
					}
					
					$content = $this->configContent($object);
					
					$this->resposta->updateContent($content);
				}else{
					$content['msg'] = $resultDao->mensagem;
					$this->resposta->setResponse($content, 400);
				}
			}
		}
		
		return $this->resposta;
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