<?php

namespace App\Services\Usuario\CriarRepresentanteGoverno;

use App\Services\BaseService;
use App\Dao\Geografico\GlossarioDao;
use App\Dao\Usuario\UsuarioDao;
use App\Email\AtivacaoRepresentanteGovernoEmail;
use App\Email\AtivacaoUsuarioEmail;
use App\Enums\TipoUsuarioEnum;

class Service extends BaseService{
    public function executar(){
        $requisicao = $this->requisicao->getConteudo();
		$modelo = new Model($requisicao);
		
	    if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();

			$tipoLocalidade = '';
			$localidade = '';

			if(strlen($requisicao->cd_localidade) == 7){
				$tipoLocalidade = 'município';
				$localidade = (new GlossarioDao())->obterMunicipio($requisicao->cd_localidade);
				$localidade = $localidade->edmu_nm_municipio . ' - ' . $localidade->eduf_sg_uf;
			}else if(strlen($requisicao->cd_localidade) == 2){
				$tipoLocalidade = 'estado';
				$localidade = ((new GlossarioDao())->obterEstado($requisicao->cd_localidade))->eduf_nm_uf;
			}

			if($localidade){
				$localidadeValida = (new UsuarioDao())->verificarRepresentanteGovernoAtivo($requisicao->cd_localidade);
				
				if($localidadeValida->resultado == false){
					$requisicao->token = md5($requisicao->nr_cpf_usuario . time());

					if(strlen($requisicao->cd_localidade) == 7){
						$resultadoDao = $this->criarRepresentanteGovernoMunicipio($requisicao);
					}else if(strlen($requisicao->cd_localidade) == 2){
						$resultadoDao = $this->criarRepresentanteGovernoEstado($requisicao);
					}
					
					if($resultadoDao->flag){
						$destinatarioUsuario = $requisicao->tx_email_usuario;
						$assuntoUsuario = 'Ativação do cadastro no Mapa das Organizações da Sociedade Civil';
						$confirmacaoUsuarioEmail = (new AtivacaoUsuarioEmail())->enviar($destinatarioUsuario, $assuntoUsuario, $requisicao->tx_nome_usuario, $requisicao->token);
						
						$destinatarioIpea = 'mapaosc@ipea.gov.br';
						$assuntoIpea = 'Ativação de representante de governo no Mapa das Organizações da Sociedade Civil';
						$ativacaoEmail = (new AtivacaoRepresentanteGovernoEmail())->enviar($destinatarioIpea, $assuntoIpea, $requisicao->tx_nome_usuario, $requisicao->nr_cpf_usuario, $requisicao->tx_email_usuario, $requisicao->tx_telefone_1, $requisicao->tx_telefone_2, $requisicao->tx_orgao_usuario, $requisicao->tx_dado_institucional, $tipoLocalidade, $localidade, $requisicao->token);
						
						$this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 201);
					}else{
						$this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
					}
				}else{
					$this->resposta->prepararResposta(['msg' => 'A localidade informada já possui um representante cadastrado.'], 400);
				}
			}else{
				$this->resposta->prepararResposta(['msg' => 'Não existe localização com este código.'], 400);
			}
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
    
    private function criarRepresentanteGovernoMunicipio($requisicao){
        $requisicao->cd_tipo_usuario = TipoUsuarioEnum::GOVERNO_MUNICIPAL;
        $requisicao->cd_municipio = $requisicao->cd_localidade;
        
        return (new UsuarioDao())->criarRepresentanteGovernoMunicipio($requisicao);
    }
    
    private function criarRepresentanteGovernoEstado($requisicao){
        $requisicao->cd_tipo_usuario = TipoUsuarioEnum::GOVERNO_ESTADUAL;
        $requisicao->cd_uf = $requisicao->cd_localidade;
        
        return (new UsuarioDao())->criarRepresentanteGovernoEstado($requisicao);
    }
}