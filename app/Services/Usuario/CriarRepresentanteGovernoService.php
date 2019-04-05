<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Enums\TipoUsuarioEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;
use App\Email\SolicitacaoAtivacaoRepresentanteGovernoEmail;

class CriarRepresentanteGovernoService extends Service
{
    public function executar()
    {
        $contrato = [
            'tx_email_usuario' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'email'],
            'tx_senha_usuario' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'senha'],
            'tx_nome_usuario' => ['apelidos' => NomenclaturaAtributoEnum::NOME_USUARIO, 'obrigatorio' => true, 'tipo' => 'string'],
            'nr_cpf_usuario' => ['apelidos' => NomenclaturaAtributoEnum::CPF, 'obrigatorio' => true, 'tipo' => 'cpf'],
            'tx_telefone_1' => ['apelidos' => NomenclaturaAtributoEnum::TELEFONE_USUARIO_1, 'obrigatorio' => true, 'tipo' => 'string'],
            'tx_telefone_2' => ['apelidos' => NomenclaturaAtributoEnum::TELEFONE_USUARIO_2, 'obrigatorio' => false, 'tipo' => 'string'],
            'tx_orgao_usuario' => ['apelidos' => NomenclaturaAtributoEnum::ORGAO_USUARIO, 'obrigatorio' => true, 'tipo' => 'string'],
            'tx_dado_institucional' => ['apelidos' => NomenclaturaAtributoEnum::DADO_INSTITUCIONAL, 'obrigatorio' => false, 'tipo' => 'string'],
            'tx_email_confirmacao' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL_CONFIRMACAO, 'obrigatorio' => false, 'tipo' => 'email'],
            'localidade' => ['apelidos' => NomenclaturaAtributoEnum::LOCALIDADE, 'obrigatorio' => true, 'tipo' => 'localidade'],
            'bo_lista_email' => ['apelidos' => NomenclaturaAtributoEnum::LISTA_EMAIL, 'obrigatorio' => false, 'tipo' => 'boolean', 'default' => false],
            'bo_lista_atualizacao_anual' => ['apelidos' => NomenclaturaAtributoEnum::LISTA_ATUALIZACAO_ANUAL, 'obrigatorio' => false, 'tipo' => 'boolean', 'default' => false],
            'bo_lista_atualizacao_trimestral' => ['apelidos' => NomenclaturaAtributoEnum::LISTA_ATUALIZACAO_TRIMESTRAL, 'obrigatorio' => false, 'tipo' => 'boolean', 'default' => false]
        ];
        
        $model = new Model($contrato, $this->requisicao->getConteudo());
        $flagModel = $this->analisarModel($model);
        
        if($flagModel){
        	$requisicao = $model->getRequisicao();
        	$localidadeValida = (new UsuarioDao())->verificarRepresentanteGovernoAtivo($requisicao->localidade);
        	
        	if($localidadeValida->resultado == false){
	            $requisicao->token = md5($requisicao->nr_cpf_usuario . time());
	            
	            if(strlen($requisicao->localidade) == 7){
	                $resultadoDao = $this->criarRepresentanteGovernoMunicipio($requisicao);
	            }else if(strlen($requisicao->localidade) == 2){
	                $resultadoDao = $this->criarRepresentanteGovernoEstado($requisicao);
	            }
	            
	            if($resultadoDao->flag){
	                $tituloEmail = 'Solicitação de Ativação de Representante de Governo no Mapa das Organizações da Sociedade Civil';
	                $ativacaoEmail = (new SolicitacaoAtivacaoRepresentanteGovernoEmail())->enviar($requisicao->tx_email_usuario, $tituloEmail, $requisicao->tx_nome_usuario, $requisicao->token);
	                
	                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 201);
	            }else{
	                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
            	}
        	}else{
        		$this->resposta->prepararResposta(['msg' => 'A localidade informada já possui um representante cadastrado.'], 400);
        	}
        }
    }
    
    private function criarRepresentanteGovernoMunicipio($requisicao){
        $requisicao->cd_tipo_usuario = TipoUsuarioEnum::GOVERNO_MUNICIPAL;
        $requisicao->cd_municipio = $requisicao->localidade;
        
        return (new UsuarioDao())->criarRepresentanteGovernoMunicipio($requisicao);
    }
    
    private function criarRepresentanteGovernoEstado($requisicao){
        $requisicao->cd_tipo_usuario = TipoUsuarioEnum::GOVERNO_ESTADUAL;
        $requisicao->cd_uf = $requisicao->localidade;
        
        return (new UsuarioDao())->criarRepresentanteGovernoEstado($requisicao);
    }
}
