<?php

namespace App\Dao;

use App\Dao\Dao;

class OscDao extends Dao
{
	public function getPopupOsc($param)
	{
		$query = 'SELECT * FROM portal.obter_osc_popup(?::TEXT);';
        $result = $this->executeQuery($query, true, [$param]);
        return $result;
	}

    public function getComponentOsc($component, $param)
    {
    	switch ($component) {
    		case "area_atuacao":
        		$result = $this->getAreaAtuacao($param);
    			break;

    		case "cabecalho":
    			$result = $this->getCabecalho($param);
    			break;

    		case "certificado":
    			$result = $this->getCertificado($param);
    			break;

    		case "dados_gerais":
    			$result = $this->getDadosGerais($param);
    			break;

    		case "descricao":
    			$result = $this->getDescricao($param);
    			break;

    		case "participacao_social":
    			$result = $this->getParticipacaoSocial($param);
    			break;

    		case "projeto":
    			$result = $this->getProjeto($param);
    			break;

			case "projeto_abreviado":
    			$result = $this->getProjetoAbreviado($param);
    			break;

            case "recursos":
    			$result = $this->getRecursosOsc($param);
    			break;

    		case "relacoes_trabalho_governanca":
    			$result = $this->getRelacoesTrabalhoGovernanca($param);
    			break;

    		default:
    			$result = null;
    	}
    	return $result;
    }

    public function getOsc($param, $with_project = true)
    {
    	$result = array();
    	$result_query = $this->getComponentOsc("area_atuacao", $param);
    	if($result_query){
    		$result = array_merge($result, ["area_atuacao" => $result_query]);
    	}

    	$result_query = $this->getComponentOsc("cabecalho", $param);
    	if($result_query){
    		$result = array_merge($result, ["cabecalho" => $result_query]);
    	}

    	$result_query = $this->getComponentOsc("certificado", $param);
    	if($result_query){
    		$result = array_merge($result, ["certificado" => $result_query]);
    	}

    	$result_query = $this->getComponentOsc("dados_gerais", $param);
    	if($result_query){
    		$result = array_merge($result, ["dados_gerais" => $result_query]);
    	}

    	$result_query = $this->getComponentOsc("descricao", $param);
    	if($result_query){
    		$result = array_merge($result, ["descricao" => $result_query]);
    	}

    	$result_query = $this->getComponentOsc("participacao_social", $param);
    	if($result_query){
    		$result = array_merge($result, ["participacao_social" => $result_query]);
    	}

    	if($with_project){
	    	$result_query = $this->getComponentOsc("projeto", $param);
	    	if($result_query){
	    		$result = array_merge($result, ["projeto" => $result_query]);
	    	}
    	}else{
			$result_query = $this->getComponentOsc("projeto_abreviado", $param);
	    	if($result_query){
	    		$result = array_merge($result, ["projeto_abreviado" => $result_query]);
	    	}
		}

    	$result_query = $this->getComponentOsc("recursos", $param);
    	if($result_query){
    		$result = array_merge($result, ["recursos" => $result_query]);
    	}

    	$result_query = $this->getComponentOsc("relacoes_trabalho_governanca", $param);
    	if($result_query){
    		$result = array_merge($result, ["relacoes_trabalho_governanca" => $result_query]);
    	}

    	return $result;
    }

    private function getAreaAtuacao($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_area_atuacao(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);

		if($result_query){
			$area_atuacao = array();
			foreach ($result_query as $key_query => $value_query) {
				$area = array();
				$area['cd_area_atuacao'] = $value_query->cd_area_atuacao;
                $area['tx_nome_area_atuacao'] = $value_query->tx_nome_area_atuacao;
				$area['tx_nome_area_atuacao_outra'] = $value_query->tx_nome_area_atuacao_outra;

				if($value_query->cd_subarea_atuacao){
					$subarea = ['cd_subarea_atuacao' => $value_query->cd_subarea_atuacao, 'tx_nome_subarea_atuacao' => $value_query->tx_nome_subarea_atuacao, 'tx_nome_subarea_atuacao_outra' => $value_query->tx_nome_subarea_atuacao_outra, 'ft_area_atuacao' => $value_query->ft_area_atuacao, 'bo_oficial' => $value_query->bo_oficial];
					$area['subarea_atuacao'] = array($subarea);
				}
				else{
					$subarea = ['cd_subarea_atuacao' => null, 'tx_nome_subarea_atuacao' => null, 'tx_nome_subarea_atuacao_outra' => null, 'ft_area_atuacao' => $value_query->ft_area_atuacao, 'bo_oficial' => $value_query->bo_oficial];
					$area['subarea_atuacao'] = array($subarea);
				}
				array_push($area_atuacao, $area);
			}
    		$result = array_merge($result, ["area_atuacao" => $area_atuacao]);
    	}

        $query = "SELECT * FROM portal.obter_osc_area_atuacao_outra(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["area_atuacao_outra" => $result_query]);
    	}

        if(count($result) == 0){
            return null;
        }else{
            return $result;
        }
    }

    private function getCabecalho($param)
    {
        $query = "SELECT * FROM portal.obter_osc_cabecalho(?::TEXT);";
    	return $this->executeQuery($query, true, [$param]);
    }

    private function getCertificado($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_certificado(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["certificado" => $result_query]);
    	}
        if(count($result) == 0){
            return null;
        }else{
            return $result;
        }
    }

    private function getDadosGerais($param)
    {
        $query = "SELECT * FROM portal.obter_osc_dados_gerais(?::TEXT);";
    	return $this->executeQuery($query, true, [$param]);
    }

    private function getDescricao($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_descricao(?::TEXT);";
        $result_query = $this->executeQuery($query, true, [$param]);
        $flag = false;
        if($result_query){
            foreach($result_query as $value){
                if($value){
                    $flag = true;
                }
            }
        }
        if($flag){
            return $result_query;
        }else{
            return null;
        }
    }

    private function getParticipacaoSocial($param)
    {
    	$result = array();

    	$query = "SELECT * FROM portal.obter_osc_participacao_social_conferencia(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["conferencia" => $result_query]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_participacao_social_conferencia_outra(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["conferencia_outra" => $result_query]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_participacao_social_conselho(?::TEXT);";
    	$result_query_conselho = $this->executeQuery($query, false, [$param]);
    	if($result_query_conselho){
    		$result_partial = array();

    		foreach($result_query_conselho as $key => $conselho){
    			$result_conselho = array();
    			$result_conselho = array_merge($result_conselho, ["conselho" => $conselho]);
    			$query = "SELECT * FROM portal.obter_osc_representante_conselho(?::TEXT);";
    			$result_query_representante = $this->executeQuery($query, false, [$conselho->id_conselho]);
    			if($result_query_representante){
    				$result_conselho = array_merge($result_conselho, ["representante" => $result_query_representante]);
    			}
    			$result_partial = array_merge($result_partial, [$key => $result_conselho]);
    		}
    		$result = array_merge($result, ['conselho' => $result_partial]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_participacao_social_outra(?::TEXT);";
	    $result_query = $this->executeQuery($query, false, [$param]);
        if($result_query){
        	$result = array_merge($result, ["outra" => $result_query]);
        }

        if(count($result) == 0){
            return null;
        }else{
            return $result;
        }
    }

    private function getProjeto($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_projeto_id_osc(?::TEXT);";
        $result_query = $this->executeQuery($query, false, [$param]);

		if($result_query){
			$result_partial = array();

	        foreach($result_query as $key => $projeto){
				$result_projeto = array();

				foreach($projeto as $key_projeto => $value_projeto){
		        	$result_projeto = array_merge($result_projeto, [$key_projeto => $value_projeto]);
				}

		        $query = "SELECT id_fonte_recursos_projeto, cd_origem_fonte_recursos_projeto, tx_nome_origem_fonte_recursos_projeto, ft_fonte_recursos_projeto FROM portal.obter_osc_fonte_recursos_projeto(?::INTEGER);";
		        $result_query_partial = $this->executeQuery($query, false, [$projeto->id_projeto]);
		        if($result_query_partial){
		        	$array_partial = array();
		            foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
		        		$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
		        	}
		            $result_projeto = array_merge($result_projeto, ["fonte_recursos" => $array_partial]);
				}
				
				$query = "SELECT * FROM portal.obter_osc_publico_beneficiado_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$projeto->id_projeto]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["publico_beneficiado" => $array_partial]);
				}
				
				$query = "SELECT id_financiador_projeto, tx_nome_financiador, ft_nome_financiador FROM portal.vw_osc_financiador_projeto WHERE id_projeto = ?::INTEGER;";
				$result_query_partial = $this->executeQuery($query, false, [$projeto->id_projeto]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["financiador_projeto" => $array_partial]);
				}
				
				$query = "SELECT * FROM portal.obter_osc_area_atuacao_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$projeto->id_projeto]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["area_atuacao" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_area_atuacao_outra_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$projeto->id_projeto]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["area_atuacao_outra" => $array_partial]);
				}
				
				$query = "SELECT * FROM portal.obter_osc_localizacao_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$projeto->id_projeto]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["localizacao" => $array_partial]);
				}
				
				$query = "SELECT * FROM portal.obter_osc_parceira_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$projeto->id_projeto]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["osc_parceira" => $array_partial]);
				}
				
				$query = "SELECT * FROM portal.obter_osc_objetivo_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$projeto->id_projeto]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["objetivo_meta" => $array_partial]);
				}

				$result_partial = array_merge($result_partial, [$key => $result_projeto]);
	        }

        	$result = array_merge($result, ["projeto" => $result_partial]);

	        if(count($result) == 0){
	            return null;
	        }else{
	            if(count($result) == 0){
	                return null;
	            }else{
		            $query = "SELECT * FROM portal.obter_recursos_projeto(?::TEXT);";
		        	$result_query = $this->executeQuery($query, true, [$param]);

		        	if($result_query){
		                $result_partial = array();
		                foreach($result_query as $key => $value){
		        			$result_partial = array_merge($result_partial, [$key => $value]);
		        		}
		                $result = array_merge($result, ["recursos" => $result_partial]);
		        	}

		            if(count($result) == 0){
		                return null;
		            }else{
		                return $result;
		            }
	            }
	        }
		}
    }

	private function getProjetoAbreviado($param)
	{
		$result = array();
    	$query = "SELECT * FROM portal.obter_osc_projeto_abreviado(?::TEXT);";
        $result_query = $this->executeQuery($query, false, [$param]);

		if($result_query){
        	$result = array_merge($result, $result_query);
        }

        if(count($result) == 0){
            return null;
        }else{
            return $result;
        }
	}

	private function getRecursosOscPorFonteAno($fonte, $ano, $param){
        $result  = null;

		$query = "SELECT * FROM portal.obter_osc_recursos_osc_por_fonte_ano(?::INTEGER, ?::TEXT, ?::TEXT);";
		$result_query = $this->executeQuery($query, true, [$fonte, $ano, $param]);
		if($result_query){
			$result = $result_query;
		}

		return $result;
	}

	private function getRecursosAno($ano, $param){
		$result = array("dt_ano_recursos_osc" => $ano);

        /*
         * Recursos próprios
         */
        $recursos = $this->getRecursosOscPorFonteAno(26, $ano, $param);
        if($recursos) $result['recursos_proprios']['rendimentos_fundos_patrimoniais'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(27, $ano, $param);
        if($recursos) $result['recursos_proprios']['rendimentos_financeiros_reservas_contas_correntes_proprias'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(28, $ano, $param);
        if($recursos) $result['recursos_proprios']['mensalidades_contribuicoes_associados'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(29, $ano, $param);
        if($recursos) $result['recursos_proprios']['premios_recebidos'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(30, $ano, $param);
        if($recursos) $result['recursos_proprios']['venda_produtos'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(31, $ano, $param);
        if($recursos) $result['recursos_proprios']['prestacao_servicos'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(32, $ano, $param);
        if($recursos) $result['recursos_proprios']['venda_bens_direitos'] = $recursos;

        /*
         * Recursos públicos
         */
        $recursos = $this->getRecursosOscPorFonteAno(13, $ano, $param);
        if($recursos) $result['recursos_publicos']['parceria_governo_federal'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(14, $ano, $param);
        if($recursos) $result['recursos_publicos']['parceria_governo_estadual'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(15, $ano, $param);
        if($recursos) $result['recursos_publicos']['parceria_governo_municipal'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(16, $ano, $param);
        if($recursos) $result['recursos_publicos']['acordo_organismos_multilaterais'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(17, $ano, $param);
        if($recursos) $result['recursos_publicos']['acordo_governos_estrangeiros'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(18, $ano, $param);
        if($recursos) $result['recursos_publicos']['empresas_publicas_sociedades_economia_mista'] = $recursos;

        /*
         * Recursos privados
         */
        $recursos = $this->getRecursosOscPorFonteAno(33, $ano, $param);
        if($recursos) $result['recursos_privados']['parceria_oscs_brasileiras'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(34, $ano, $param);
        if($recursos) $result['recursos_privados']['parcerias_oscs_estrangeiras'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(35, $ano, $param);
        if($recursos) $result['recursos_privados']['parcerias_organizacoes_religiosas_brasileiras'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(36, $ano, $param);
        if($recursos) $result['recursos_privados']['parcerias_organizacoes_religiosas_estrangeiras'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(37, $ano, $param);
        if($recursos) $result['recursos_privados']['empresas_privadas_brasileiras'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(38, $ano, $param);
        if($recursos) $result['recursos_privados']['empresas_privadas_estrangeiras'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(39, $ano, $param);
        if($recursos) $result['recursos_privados']['doacoes_pessoa_juridica'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(40, $ano, $param);
        if($recursos) $result['recursos_privados']['doacoes_pessoa_fisica'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(41, $ano, $param);
        if($recursos) $result['recursos_privados']['doacoes_recebidas_forma_produtos_servicos_com_nota_fiscal'] = $recursos;

        /*
         * Recursos não financeiros
         */
        $recursos = $this->getRecursosOscPorFonteAno(42, $ano, $param);
        if($recursos) $result['recursos_nao_financeiros']['voluntariado'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(43, $ano, $param);
        if($recursos) $result['recursos_nao_financeiros']['isencoes'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(44, $ano, $param);
        if($recursos) $result['recursos_nao_financeiros']['imunidades'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(45, $ano, $param);
        if($recursos) $result['recursos_nao_financeiros']['bens_recebidos_direito_uso'] = $recursos;

        $recursos = $this->getRecursosOscPorFonteAno(46, $ano, $param);
        if($recursos) $result['recursos_nao_financeiros']['doacoes_recebidas_forma_produtos_servicos_sem_nota_fiscal'] = $recursos;

		return $result;
	}

    private function getRecursosOsc($param)
    {
    	$result = array();

    	$array_recursos = array();
        for ($i = 2016; $i >= 2014; $i--) {
            $recursos = $this->getRecursosAno($i, $param);
            if($recursos){
                array_push($array_recursos, $recursos);
            }
        }

        if($array_recursos){
    	    $result = array_merge($result, ["recursos" => $array_recursos]);
        }

    	$query = "SELECT * FROM portal.obter_osc_recursos_outro_osc(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["recursos_outro" => $result_query]);
    	}

        if(count($result) == 0){
            return null;
        }else{
            return $result;
        }
    }

    private function getRelacoesTrabalhoGovernanca($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_relacoes_trabalho(?::TEXT);";
    	$result_query = $this->executeQuery($query, true, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["relacoes_trabalho" => $result_query]);
    	}
    	$query = "SELECT * FROM portal.obter_osc_relacoes_trabalho_outra(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["relacoes_trabalho_outra" => $result_query]);
    	}
    	$query = "SELECT * FROM portal.obter_osc_governanca(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["governanca" => $result_query]);
    	}
    	$query = "SELECT * FROM portal.obter_osc_conselho_fiscal(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["conselho_fiscal" => $result_query]);
    	}
        if(count($result) == 0){
            return null;
        }else{
            return $result;
        }
    }

    public function updateLogo($params)
    {
    	$query = 'UPDATE osc.tb_dados_gerais SET im_logo = ?::TEXT, ft_logo = ?::TEXT WHERE id_osc = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateDadosGerais($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_dados_gerais(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT,
    			?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateApelido($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_apelido(?::INTEGER, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function insertContatos($params)
    {
    	$query = 'SELECT * FROM portal.inserir_contato(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateContatos($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_contato(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateDescricao($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_descricao(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateAreaAtuacao($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_area_atuacao(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function insertAreaAtuacao($params)
    {
    	$query = 'SELECT * FROM portal.inserir_area_atuacao(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteAreaAtuacao($params)
    {
    	$query = 'SELECT * FROM portal.excluir_area_atuacao(?::INTEGER, ?::INTEGER, ?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteAreaAtuacaoPorId($params)
    {
		if($params[2]){
    		$query = 'DELETE FROM osc.tb_area_atuacao WHERE id_osc = ?::INTEGER AND (cd_area_atuacao <> ?::INTEGER AND cd_subarea_atuacao <> ?::INTEGER);';
		}else{
			$query = 'DELETE FROM osc.tb_area_atuacao WHERE id_osc = ?::INTEGER AND (cd_area_atuacao <> ?::INTEGER AND cd_subarea_atuacao IS NOT NULL);';
		}
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function setAreaAtuacaoOutra($params)
    {
    	$query = 'SELECT * FROM portal.inserir_area_atuacao_outra(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteAreaAtuacaoOutra($params)
    {
    	$query = 'SELECT * FROM portal.excluir_area_atuacao_outra(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function insertDirigente($params)
    {
    	$query = 'SELECT * FROM portal.inserir_dirigente(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateDirigente($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_dirigente(?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteDirigente($params)
    {
    	$query = 'SELECT * FROM portal.excluir_dirigente(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function setMembroConselho($params)
    {
    	$query = 'SELECT * FROM portal.inserir_membro_conselho(?::INTEGER, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateMembroConselho($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_membro_conselho(?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteMembroConselho($params)
    {
    	$query = 'SELECT * FROM portal.excluir_membro_conselho(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateRelacoesTrabalho($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_trabalhadores(?::INTEGER, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function setOutrosTrabalhadores($params)
    {
    	$query = 'SELECT * FROM portal.inserir_outro_trabalhador(?::INTEGER, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateOutrosTrabalhadores($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_outros_trabalhadores(?::INTEGER, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function insertParticipacaoSocialConselho($params)
    {
    	//$query = 'SELECT * FROM portal.inserir_participacao_social_conselho(?::INTEGER, ?::INTEGER, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::BOOLEAN);';
    	$query = 'INSERT INTO osc.tb_participacao_social_conselho (id_osc, cd_conselho, ft_conselho, cd_tipo_participacao, ft_tipo_participacao, tx_periodicidade_reuniao, ft_periodicidade_reuniao, dt_data_inicio_conselho, ft_data_inicio_conselho, dt_data_fim_conselho, ft_data_fim_conselho, bo_oficial)
    				VALUES (?::INTEGER, ?::INTEGER, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::BOOLEAN)
    				RETURNING id_conselho;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function selectIdParticipacaoSocialConselho($params)
    {
    	$query = 'SELECT id_conselho FROM osc.tb_participacao_social_conselho WHERE id_osc = ?::INTEGER AND cd_conselho = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params)->id_conselho;
    	return $result;
    }

    public function updateParticipacaoSocialConselho($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_participacao_social_conselho(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteParticipacaoSocialConselho($params)
    {
    	$query = 'SELECT * FROM portal.excluir_participacao_social_conselho(?::INTEGER, ?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

	public function insertMembroParticipacaoSocialConselho($params)
    {
    	$query = 'INSERT INTO osc.tb_representante_conselho (id_osc, id_participacao_social_conselho, tx_nome_representante_conselho, ft_nome_representante_conselho, bo_oficial) VALUES (?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::BOOLEAN) RETURNING id_representante_conselho;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

	public function deleteMembroParticipacaoSocialConselho($params)
    {
    	$query = 'DELETE FROM osc.tb_representante_conselho WHERE id_representante_conselho = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

	public function deleteMembroParticipacaoSocialConselhoByIdConselho($params)
    {
    	$query = 'DELETE FROM osc.tb_representante_conselho WHERE id_participacao_social_conselho = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function insertParticipacaoSocialConferencia($params)
    {
    	$query = 'SELECT * FROM portal.inserir_participacao_social_conferencia(?::INTEGER, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::INTEGER, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result->inserir_participacao_social_conferencia;
    }

    public function updateParticipacaoSocialConferencia($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_participacao_social_conferencia(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteParticipacaoSocialConferencia($params)
    {
    	$query = 'SELECT * FROM portal.excluir_participacao_social_conferencia(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function setParticipacaoSocialConferenciaOutra($params)
    {
    	$query = 'SELECT * FROM portal.inserir_participacao_social_conferencia_outra(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateParticipacaoSocialConferenciaOutra($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_participacao_social_conferencia_outra(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteParticipacaoSocialConferenciaOutra($params)
    {
    	$query = 'SELECT * FROM portal.excluir_participacao_social_conferencia_outra(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function setParticipacaoSocialDeclarada($params)
    {
    	$query = 'SELECT * FROM portal.inserir_participacao_social_declarada(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateParticipacaoSocialDeclarada($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_participacao_social_declarada(?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteParticipacaoSocialDeclarada($params)
    {
    	$query = 'SELECT * FROM portal.excluir_participacao_social_declarada(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function insertParticipacaoSocialOutra($params)
    {
    	$query = 'SELECT * FROM portal.inserir_participacao_social_outra(?::INTEGER, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteParticipacaoSocialOutra($params)
    {
    	$query = 'SELECT * FROM portal.excluir_participacao_social_outra(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateLinkRecursos($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_link_recursos(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function insertConselhoFiscal($params)
    {
    	$query = 'SELECT * FROM portal.inserir_conselho_fiscal(?::INTEGER, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateConselhoFiscal($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_conselho_fiscal(?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteConselhoFiscal($params)
    {
    	$query = 'SELECT * FROM portal.excluir_conselho_fiscal(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function setProjeto($params)
    {
    	$query = 'SELECT * FROM portal.inserir_projeto(?::INTEGER, ?::TEXT, ?::TEXT, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT, ?::TEXT, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::SMALLINT, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateProjeto($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_projeto(?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT, ?::TEXT, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::SMALLINT, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteProjeto($params)
    {
    	$query = 'DELETE FROM osc.tb_projeto WHERE id_projeto = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

	public function setPublicoBeneficiado($params)
    {
    	$query = 'SELECT * FROM portal.inserir_publico_beneficiado(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updatePublicoBeneficiado($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_publico_beneficiado(?::INTEGER, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deletePublicoBeneficiado($params)
    {
    	$query = 'DELETE FROM osc.tb_publico_beneficiado_projeto WHERE id_projeto = ?::INTEGER AND bo_oficial <> true RETURNING id_publico_beneficiado;';
    	$result = $this->executeQuery($query, false, $params);

    	if($result){
	    	foreach($result as $key => $value){
		    	$query = 'DELETE FROM osc.tb_publico_beneficiado WHERE id_publico_beneficiado = ?::INTEGER;';
	    		$params = [$value->id_publico_beneficiado];
	    		$result = $this->executeQuery($query, false, $params);
	    	}
    	}

    	return $result;
    }

	public function setAreaAtuacaoProjeto($params)
    {
    	$query = 'SELECT * FROM portal.inserir_area_atuacao_projeto(?::INTEGER, ?::INTEGER, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateAreaAtuacaoProjeto($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_area_atuacao_projeto(?::INTEGER, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteAreaAtuacaoProjeto($params)
    {
    	$query = 'SELECT * FROM portal.excluir_area_atuacao_projeto(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function setAreaAtuacaoOutraProjeto($params)
    {
    	$query = 'SELECT * FROM portal.inserir_area_atuacao_outra_projeto(?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateAreaAtuacaoOutraProjeto($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_area_atuacao_outra_projeto(?::INTEGER, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteAreaAtuacaoOutraProjeto($params)
    {
    	$query = 'DELETE FROM osc.tb_area_atuacao_outra_projeto WHERE id_projeto = ?::INTEGER RETURNING id_area_atuacao_outra;';
    	$result = $this->executeQuery($query, false, $params);

    	if($result){
    		foreach($result as $key => $value){
    			$query = 'DELETE FROM osc.tb_area_atuacao_outra WHERE id_area_atuacao_outra = ?::INTEGER RETURNING id_area_atuacao_declarada;';
    			$params = [$value->id_area_atuacao_outra];
    			$result = $this->executeQuery($query, true, $params);

    			$query = 'DELETE FROM osc.tb_area_atuacao_declarada WHERE id_area_atuacao_declarada = ?::INTEGER;';
    			$params = [$result->id_area_atuacao_declarada];
    			$result = $this->executeQuery($query, true, $params);
    		}
    	}

    	return $result;
    }

	public function setLocalizacaoProjeto($params)
    {
    	$query = 'SELECT * FROM portal.inserir_localizacao_projeto(?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateLocalizacaoProjeto($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_localizacao_projeto(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteLocalizacaoProjeto($params)
    {
    	$query = 'SELECT * FROM portal.excluir_localizacao_projeto(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteFinanciadoresProjeto($params)
    {
    	$query = 'DELETE FROM osc.tb_financiador_projeto WHERE id_projeto = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

	public function setObjetivoProjeto($params)
    {
    	$query = 'SELECT * FROM portal.inserir_objetivo_projeto(?::INTEGER, ?::INTEGER, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateObjetivoProjeto($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_objetivo_projeto(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteObjetivoProjeto($params)
    {
    	$query = 'SELECT * FROM portal.excluir_objetivo_projeto(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

	public function setParceiraProjeto($params)
    {
    	$query = 'SELECT * FROM portal.inserir_parceira_projeto(?::INTEGER, ?::INTEGER, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteParceiraProjeto($params)
    {
    	$query = 'DELETE FROM osc.tb_osc_parceira_projeto WHERE id_osc = ?::INTEGER AND id_projeto = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteFonteRecursosProjeto($params)
    {
    	$query = 'DELETE FROM osc.tb_fonte_recursos_projeto WHERE id_projeto = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

	public function insertFinanciadorProjeto($params)
    {
     	$query = 'INSERT INTO osc.tb_financiador_projeto (id_projeto, tx_nome_financiador, ft_nome_financiador, bo_oficial) VALUES (?::INTEGER, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteFinanciadorProjeto($params)
    {
    	$query = 'DELETE FROM osc.tb_financiador_projeto WHERE id_financiador_projeto = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function insertCertificado($params)
    {
    	$query = 'SELECT * FROM portal.inserir_certificado(?::INTEGER, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateCertificado($params)
    {
    	//$query = 'SELECT * FROM portal.atualizar_certificado(?::INTEGER, ?::INTEGER, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::BOOLEAN);';
    	$query = 'UPDATE osc.tb_certificado
    				SET
    					dt_inicio_certificado = ?::DATE,
    					ft_inicio_certificado = ?::TEXT,
    					dt_fim_certificado = ?::DATE,
    					ft_fim_certificado = ?::TEXT,
    					bo_oficial = ?::BOOLEAN
    				WHERE
    					id_osc = ?::INTEGER AND
    					cd_certificado = ?::INTEGER;';

    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteCertificado($params)
    {
    	$query = 'SELECT * FROM portal.excluir_certificado(?::INTEGER, ?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function insertRecursosOsc($params)
    {
    	$query = 'SELECT * FROM portal.inserir_recursos_osc(?::INTEGER, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result->inserir_recursos_osc;
    }

    public function updateRecursosOsc($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_recursos_osc(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result->status;
    }

    public function deleteRecursosOsc($params)
    {
    	$query = 'SELECT * FROM portal.excluir_recursos_osc(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function setRecursosOutroOsc($params)
    {
    	$query = 'SELECT * FROM portal.inserir_recursos_outro_osc(?::INTEGER, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateRecursosOutroOsc($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_recursos_outro_osc(?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteRecursosOutroOsc($params)
    {
    	$query = 'SELECT * FROM portal.excluir_recursos_outro_osc(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
}
