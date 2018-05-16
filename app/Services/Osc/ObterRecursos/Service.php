<?php

namespace App\Services\Osc\ObterRecursos;

use App\Services\BaseService;
use App\Dao\Osc\RecursosDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
		
	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
			$resultadoDao = (new RecursosDao())->obterRecursos($requisicao);
	    	
	    	if($resultadoDao){
				$resultado = $this->ajustarObjeto(json_decode($resultadoDao->resultado));
	    	    $this->resposta->prepararResposta($resultado, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a atualização desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}

	private function ajustarObjeto($objeto){
		$resultado = new \stdClass();
		$resultado->recursos = null;
		$resultado->recursos_outros = null;

		if($objeto !== null){
			$recursosAnuais = array();

			foreach($objeto as $recurso){
				$recursoAjustado = new \stdClass();
				
				if(array_search($recurso->dt_ano_recursos_osc, array_keys($recursosAnuais)) > -1){
					$recursoAjustado = $recursosAnuais[$recurso->dt_ano_recursos_osc];
				}else{
					$recursoAjustado->dt_ano_recursos_osc = $recurso->dt_ano_recursos_osc;
					$recursoAjustado->bo_nao_possui = $recurso->bo_nao_possui;
					$recursoAjustado->ft_nao_possui = $recurso->ft_nao_possui;
					$recursoAjustado->bo_nao_possui_recursos_publicos = null;
					$recursoAjustado->ft_nao_possui_recursos_publicos = null;
					$recursoAjustado->bo_nao_possui_recursos_privados = null;
					$recursoAjustado->ft_nao_possui_recursos_privados = null;
					$recursoAjustado->bo_nao_possui_recursos_proprios = null;
					$recursoAjustado->ft_nao_possui_recursos_proprios = null;
					$recursoAjustado->bo_nao_possui_recursos_nao_financeiros = null;
					$recursoAjustado->ft_nao_possui_recursos_nao_financeiros = null;
					$recursoAjustado->recursos_publicos = null;
					$recursoAjustado->recursos_privados = null;
					$recursoAjustado->recursos_proprios = null;
					$recursoAjustado->recursos_nao_financeiros = null;
				}

				if($recurso->bo_nao_possui === true){
					if($recurso->cd_origem_fonte_recursos_osc === null){
						$recursoAjustado->recursos_publicos = null;
						$recursoAjustado->recursos_privados = null;
						$recursoAjustado->recursos_proprios = null;
						$recursoAjustado->recursos_nao_financeiros = null;

						$recursosAnuais[$recurso->dt_ano_recursos_osc] = $recursoAjustado;
					}else{
						$recursoAjustado->bo_nao_possui = null;
						$recursoAjustado->ft_nao_possui = null;
						$recursoAjustado->cd_fonte_recursos_osc = null;

						if($recurso->cd_origem_fonte_recursos_osc === 1){
							$recursoAjustado->recursos_publicos = null;
							$recursoAjustado->bo_nao_possui_recursos_publicos = $recurso->bo_nao_possui;
							$recursoAjustado->ft_nao_possui_recursos_publicos = $recurso->ft_nao_possui;
						}

						if($recurso->cd_origem_fonte_recursos_osc === 2){
							$recursoAjustado->recursos_privados = null;
							$recursoAjustado->bo_nao_possui_recursos_privados = $recurso->bo_nao_possui;
							$recursoAjustado->ft_nao_possui_recursos_privados = $recurso->ft_nao_possui;
						}

						if($recurso->cd_origem_fonte_recursos_osc === 3){
							$recursoAjustado->recursos_proprios = null;
							$recursoAjustado->bo_nao_possui_recursos_proprios = $recurso->bo_nao_possui;
							$recursoAjustado->ft_nao_possui_recursos_proprios = $recurso->ft_nao_possui;
						}

						if($recurso->cd_origem_fonte_recursos_osc === 4){
							$recursoAjustado->recursos_nao_financeiros = null;
							$recursoAjustado->bo_nao_possui_recursos_nao_financeiros = $recurso->bo_nao_possui;
							$recursoAjustado->ft_nao_possui_recursos_nao_financeiros = $recurso->ft_nao_possui;
						}

						$recursosAnuais[$recurso->dt_ano_recursos_osc] = $recursoAjustado;
					}
				}else{
					if(array_search($recurso->cd_fonte_recursos_osc, [157, 158, 159, 160, 161, 162]) > -1){
						$recursoFonte = new \stdClass();
						$recursoFonte->id_recursos_osc = $recurso->id_recursos_osc;
						$recursoFonte->cd_fonte_recursos_osc = $recurso->cd_fonte_recursos_osc;
						$recursoFonte->nr_valor_recursos_osc = $recurso->nr_valor_recursos_osc;
						$recursoFonte->ft_valor_recursos_osc = $recurso->ft_valor_recursos_osc;

						$recursosOrigem = null;
						if(array_search($recurso->dt_ano_recursos_osc, array_keys($recursosAnuais)) > -1){
							$recursosOrigem = $recursosAnuais[$recurso->dt_ano_recursos_osc]->recursos_publicos;
						}

						if($recursosOrigem === null){
							$recursosOrigem = new \stdClass();
						}

						if($recurso->cd_fonte_recursos_osc === 157){
							$recursosOrigem->parceria_governo_federal = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 158){
							$recursosOrigem->parceria_governo_estadual = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 159){
							$recursosOrigem->parceria_governo_municipal = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 160){
							$recursosOrigem->acordo_organismos_multilaterais = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 161){
							$recursosOrigem->acordo_governos_estrangeiros = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 162){
							$recursosOrigem->empresas_publicas_sociedades_economia_mista = $recursoFonte;
						}

						$recursoAjustado->recursos_publicos = $recursosOrigem;
					}

					if(array_search($recurso->cd_fonte_recursos_osc, [162, 163, 164, 165, 166, 167, 168, 169, 170, 171]) > -1){
						$recursoFonte = new \stdClass();
						$recursoFonte->id_recursos_osc = $recurso->id_recursos_osc;
						$recursoFonte->cd_fonte_recursos_osc = $recurso->cd_fonte_recursos_osc;
						$recursoFonte->nr_valor_recursos_osc = $recurso->nr_valor_recursos_osc;
						$recursoFonte->ft_valor_recursos_osc = $recurso->ft_valor_recursos_osc;

						$recursosOrigem = null;
						if(array_search($recurso->dt_ano_recursos_osc, array_keys($recursosAnuais)) > -1){
							$recursosOrigem = $recursosAnuais[$recurso->dt_ano_recursos_osc]->recursos_privados;
						}

						if($recursosOrigem === null){
							$recursosOrigem = new \stdClass();
						}

						if($recurso->cd_fonte_recursos_osc === 163){
							$recursosOrigem->parceria_oscs_brasileiras = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 164){
							$recursosOrigem->parcerias_oscs_estrangeiras = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 165){
							$recursosOrigem->parcerias_organizacoes_religiosas_brasileiras = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 166){
							$recursosOrigem->parcerias_organizacoes_religiosas_estrangeiras = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 167){
							$recursosOrigem->empresas_privadas_brasileiras = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 168){
							$recursosOrigem->empresas_privadas_estrangeiras = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 169){
							$recursosOrigem->doacoes_pessoa_juridica = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 170){
							$recursosOrigem->doacoes_pessoa_fisica = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 171){
							$recursosOrigem->doacoes_recebidas_forma_produtos_servicos_com_nota_fiscal = $recursoFonte;
						}

						$recursoAjustado->recursos_privados = $recursosOrigem;
					}

					if(array_search($recurso->cd_fonte_recursos_osc, [172, 173, 174, 175, 176, 177, 178]) > -1){
						$recursoFonte = new \stdClass();
						$recursoFonte->id_recursos_osc = $recurso->id_recursos_osc;
						$recursoFonte->cd_fonte_recursos_osc = $recurso->cd_fonte_recursos_osc;
						$recursoFonte->nr_valor_recursos_osc = $recurso->nr_valor_recursos_osc;
						$recursoFonte->ft_valor_recursos_osc = $recurso->ft_valor_recursos_osc;

						$recursosOrigem = null;
						if(array_search($recurso->dt_ano_recursos_osc, array_keys($recursosAnuais)) > -1){
							$recursosOrigem = $recursosAnuais[$recurso->dt_ano_recursos_osc]->recursos_proprios;
						}

						if($recursosOrigem === null){
							$recursosOrigem = new \stdClass();
						}

						if($recurso->cd_fonte_recursos_osc === 172){
							$recursosOrigem->rendimentos_fundos_patrimoniais = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 173){
							$recursosOrigem->rendimentos_financeiros_reservas_contas_correntes_proprias = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 174){
							$recursosOrigem->mensalidades_contribuicoes_associados = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 175){
							$recursosOrigem->premios_recebidos = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 176){
							$recursosOrigem->venda_produtos = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 177){
							$recursosOrigem->prestacao_servicos = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 178){
							$recursosOrigem->venda_bens_direitos = $recursoFonte;
						}

						$recursoAjustado->recursos_proprios = $recursosOrigem;
					}

					if(array_search($recurso->cd_fonte_recursos_osc, [179, 180, 181, 182, 183]) > -1){
						$recursoFonte = new \stdClass();
						$recursoFonte->id_recursos_osc = $recurso->id_recursos_osc;
						$recursoFonte->cd_fonte_recursos_osc = $recurso->cd_fonte_recursos_osc;
						$recursoFonte->nr_valor_recursos_osc = $recurso->nr_valor_recursos_osc;
						$recursoFonte->ft_valor_recursos_osc = $recurso->ft_valor_recursos_osc;

						$recursosOrigem = null;
						if(array_search($recurso->dt_ano_recursos_osc, array_keys($recursosAnuais)) > -1){
							$recursosOrigem = $recursosAnuais[$recurso->dt_ano_recursos_osc]->recursos_nao_financeiros;
						}

						if($recursosOrigem === null){
							$recursosOrigem = new \stdClass();
						}

						if($recurso->cd_fonte_recursos_osc === 179){
							$recursosOrigem->voluntariado = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 180){
							$recursosOrigem->isencoes = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 181){
							$recursosOrigem->imunidades = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 182){
							$recursosOrigem->bens_recebidos_direito_uso = $recursoFonte;
						}

						if($recurso->cd_fonte_recursos_osc === 183){
							$recursosOrigem->doacoes_recebidas_forma_produtos_servicos_sem_nota_fiscal = $recursoFonte;
						}

						$recursoAjustado->recursos_nao_financeiros = $recursosOrigem;
					}

					$recursosAnuais[$recurso->dt_ano_recursos_osc] = $recursoAjustado;
				}
			}

			$resultado->recursos = array_values($recursosAnuais);
		}

		return $resultado;
	}
}