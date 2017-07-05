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
				$flag_insert = true;

				$area = array();
				foreach($area_atuacao as $key_area => $value_area){
					if($value_area['cd_area_atuacao'] == $value_query->cd_area_atuacao){
						unset($area_atuacao[$key_area]);
						$area = $value_area;
						$flag_insert = false;
					}
				}

				if($flag_insert){
					$area = array();
					$area['cd_area_atuacao'] = $value_query->cd_area_atuacao;
					$area['tx_nome_area_atuacao'] = $value_query->tx_nome_area_atuacao;
					$area['tx_nome_area_atuacao_outra'] = $value_query->tx_nome_area_atuacao_outra;
					$area['ft_area_atuacao'] = $value_query->ft_area_atuacao;
					$area['bo_oficial'] = $value_query->bo_oficial;

					if($value_query->cd_subarea_atuacao){
						$subarea = ['cd_subarea_atuacao' => $value_query->cd_subarea_atuacao, 'tx_nome_subarea_atuacao' => $value_query->tx_nome_subarea_atuacao, 'tx_nome_subarea_atuacao_outra' => $value_query->tx_nome_subarea_atuacao_outra, 'ft_subarea_atuacao' => $value_query->ft_area_atuacao, 'bo_oficial' => $value_query->bo_oficial];
						$area['subarea_atuacao'] = array($subarea);
					}else{
						$area['subarea_atuacao'] = null;
					}

					array_push($area_atuacao, $area);
				}
				else{
					$subarea = ['cd_subarea_atuacao' => $value_query->cd_subarea_atuacao, 'tx_nome_subarea_atuacao' => $value_query->tx_nome_subarea_atuacao, 'tx_nome_subarea_atuacao_outra' => $value_query->tx_nome_subarea_atuacao_outra, 'ft_subarea_atuacao' => $value_query->ft_area_atuacao, 'bo_oficial' => $value_query->bo_oficial];
					array_push($area['subarea_atuacao'], $subarea);

					array_push($area_atuacao, $area);
				}
			}

			$area_atuacao_adjusted = array();
			foreach($area_atuacao as $key => $value){
    			array_push($area_atuacao_adjusted, $value);
			}
			$result = array_merge($result, ["area_atuacao" => $area_atuacao_adjusted]);
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

    	$query = "SELECT
					id_conferencia,
					cd_conferencia,
					tx_nome_conferencia,
					null AS tx_nome_conferencia_outro,
					ft_conferencia,
					dt_ano_realizacao,
					ft_ano_realizacao,
					cd_forma_participacao_conferencia,
					tx_nome_forma_participacao_conferencia,
					ft_forma_participacao_conferencia
				FROM
					portal.vw_osc_participacao_social_conferencia
				WHERE
					id_osc::TEXT = ?::TEXT AND cd_conferencia <> 132
    			OR
    				tx_apelido_osc = ?::TEXT
				UNION
				SELECT
					id_conferencia_outra AS id_conferencia,
					132 AS cd_conferencia,
					'Outra Conferência' AS tx_nome_conferencia,
					tx_nome_conferencia AS tx_nome_conferencia_outro,
					ft_nome_conferencia AS ft_conferencia,
					dt_ano_realizacao,
					ft_ano_realizacao,
					cd_forma_participacao_conferencia,
					tx_nome_forma_participacao_conferencia,
					ft_forma_participacao_conferencia
				FROM
					portal.vw_osc_participacao_social_conferencia_outra
				WHERE
					id_osc::TEXT = ?::TEXT
    			OR
    				tx_apelido_osc = ?::TEXT;";
    	$result_query = $this->executeQuery($query, false, [$param, $param, $param, $param]);
    	if($result_query){
    		$result = array_merge($result, ["conferencia" => $result_query]);
    	}else{
    		$result = array_merge($result, ["conferencia" => null]);
    	}

    	$query = "SELECT
    					a.id_conselho,
    					a.cd_conselho,
    					a.tx_nome_conselho,
    					b.tx_nome_conselho AS tx_nome_conselho_outro,
    					a.ft_conselho,
    					a.cd_tipo_participacao,
    					a.tx_nome_tipo_participacao,
    					a.ft_tipo_participacao,
    					a.cd_periodicidade_reuniao_conselho,
    					a.tx_nome_periodicidade_reuniao_conselho,
    					a.ft_periodicidade_reuniao,
    					a.dt_data_inicio_conselho,
    					a.ft_data_inicio_conselho,
    					a.dt_data_fim_conselho,
    					a.ft_data_fim_conselho
    				FROM
    					portal.vw_osc_participacao_social_conselho a
    				LEFT JOIN
    					portal.vw_osc_participacao_social_conselho_outro b
    				ON
    					a.id_conselho = b.id_conselho
    				WHERE
    					a.id_osc::TEXT = ?::TEXT
    				OR
    					a.tx_apelido_osc = ?::TEXT;";
    	$result_query_conselho = $this->executeQuery($query, false, [$param, $param]);
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
    	}else{
    		$result = array_merge($result, ["conselho" => null]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_participacao_social_outra(?::TEXT);";
	    $result_query = $this->executeQuery($query, false, [$param]);
        if($result_query){
        	$result = array_merge($result, ["outra" => $result_query]);
        }else{
    		$result = array_merge($result, ["outra" => null]);
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

		        $query = "SELECT * FROM portal.obter_osc_fonte_recursos_projeto(?::INTEGER);";
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

	private function getRecursosAno($ano, $dict_fonte_recursos, $param){
		$result = array("dt_ano_recursos_osc" => $ano);

		foreach ($dict_fonte_recursos as $key => $fonte_recursos){
			$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);

			if($recursos){
				if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Parceria com o governo federal') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_publicos']['parceria_governo_federal'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Parceria com o governo estadual') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_publicos']['parceria_governo_estadual'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Parceria com o governo municipal') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_publicos']['parceria_governo_municipal'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Acordo com organismos multilaterais') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_publicos']['acordo_organismos_multilaterais'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Acordo com governos estrangeiros') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_publicos']['acordo_governos_estrangeiros'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'blicas ou sociedades de economia mista') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_publicos']['empresas_publicas_sociedades_economia_mista'] = $recursos;
				}

				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Parceria com OSCs brasileiras') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_privados']['parceria_oscs_brasileiras'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Parcerias com OSCs estrangeiras') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_privados']['parcerias_oscs_estrangeiras'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'es religiosas brasileiras') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_privados']['parcerias_organizacoes_religiosas_brasileiras'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'es religiosas estrangeiras') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_privados']['parcerias_organizacoes_religiosas_estrangeiras'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Empresas privadas brasileiras') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_privados']['empresas_privadas_brasileiras'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Empresas estrangeiras') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_privados']['empresas_privadas_estrangeiras'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'es de pessoa jur') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_privados']['doacoes_pessoa_juridica'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'es de pessoa f') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_privados']['doacoes_pessoa_fisica'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'com Nota Fiscal') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_privados']['doacoes_recebidas_forma_produtos_servicos_com_nota_fiscal'] = $recursos;
				}

				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Rendimentos de fundos patrimoniais') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_proprios']['rendimentos_fundos_patrimoniais'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Rendimentos financeiros de reservas ou contas correntes') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_proprios']['rendimentos_financeiros_reservas_contas_correntes_proprias'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Mensalidades ou contribui') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_proprios']['mensalidades_contribuicoes_associados'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'mios recebidos') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_proprios']['premios_recebidos'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Venda de produtos') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_proprios']['venda_produtos'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'o de servi') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_proprios']['prestacao_servicos'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Venda de bens e direitos') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_proprios']['venda_bens_direitos'] = $recursos;
				}

				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Voluntariado') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_nao_financeiros']['voluntariado'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Isen') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_nao_financeiros']['isencoes'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Imunidades') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_nao_financeiros']['imunidades'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'Bens recebidos em direito de uso') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_nao_financeiros']['bens_recebidos_direito_uso'] = $recursos;
				}
				else if(strpos($fonte_recursos->tx_nome_fonte_recursos_osc, 'sem Nota Fiscal') !== false){
					$recursos = $this->getRecursosOscPorFonteAno($fonte_recursos->cd_fonte_recursos_osc, $ano, $param);
					if($recursos) $result['recursos_nao_financeiros']['doacoes_recebidas_forma_produtos_servicos_sem_nota_fiscal'] = $recursos;
				}
			}
		}

		return $result;
	}

    private function getRecursosOsc($param)
    {
    	$result = array();

    	$query = "SELECT * FROM syst.dc_origem_fonte_recursos_osc a INNER JOIN syst.dc_fonte_recursos_osc b ON a.cd_origem_fonte_recursos_osc = b.cd_origem_fonte_recursos_osc;";
    	$dict_fonte_recursos_osc = $this->executeQuery($query, false, null);

    	$array_recursos = array();
        for ($ano = 2017; $ano >= 2014; $ano--) {
            $recursos = $this->getRecursosAno($ano, $dict_fonte_recursos_osc, $param);
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

    public function insertRelacoesTrabalho($params)
    {
    	$query = 'INSERT INTO osc.tb_relacoes_trabalho (id_osc, nr_trabalhadores_voluntarios, ft_trabalhadores_voluntarios)
    				VALUES (?::INTEGER, ?::INTEGER, ?::TEXT);';
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
    	$query = 'INSERT INTO osc.tb_participacao_social_conselho (id_osc, cd_conselho, ft_conselho, cd_tipo_participacao, ft_tipo_participacao, cd_periodicidade_reuniao_conselho, ft_periodicidade_reuniao, dt_data_inicio_conselho, ft_data_inicio_conselho, dt_data_fim_conselho, ft_data_fim_conselho, bo_oficial)
    				VALUES (?::INTEGER, ?::INTEGER, ?::TEXT, ?::INTEGER, ?::TEXT, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::BOOLEAN)
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
    	//$query = 'SELECT * FROM portal.atualizar_participacao_social_conselho(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT);';
    	$query = 'UPDATE
    					osc.tb_participacao_social_conselho
    				SET
    					cd_conselho = ?::INTEGER,
    					cd_tipo_participacao = ?::INTEGER,
    					ft_tipo_participacao = ?::TEXT,
    					cd_periodicidade_reuniao_conselho = ?::INTEGER,
    					ft_periodicidade_reuniao = ?::TEXT,
    					dt_data_inicio_conselho = ?::DATE,
    					ft_data_inicio_conselho = ?::TEXT,
    					dt_data_fim_conselho = ?::DATE,
    					ft_data_fim_conselho = ?::TEXT
    				WHERE
    					id_osc = ?::INTEGER AND
    					id_conselho = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return ['mensagem' => 'Participação Social Conselho atualizada'];
    }

    public function deleteParticipacaoSocialConselho($params)
    {
    	$query = 'DELETE FROM osc.tb_participacao_social_conselho WHERE id_conselho = ?::INTEGER;';
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

    public function setParticipacaoSocialConselhoOutro($params)
    {
    	$query = 'SELECT * FROM portal.inserir_participacao_social_conselho_outro(?::TEXT, ?::TEXT, ?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateParticipacaoSocialConselhoOutro($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_participacao_social_conselho_outro(?::TEXT, ?::TEXT, ?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteParticipacaoSocialConselhoOutro($params)
    {
    	$query = 'DELETE FROM osc.tb_participacao_social_conselho_outro WHERE id_conselho = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function insertParticipacaoSocialConferencia($params)
    {
    	$query = 'INSERT INTO osc.tb_participacao_social_conferencia (cd_conferencia, ft_conferencia, id_osc, dt_ano_realizacao, ft_ano_realizacao, cd_forma_participacao_conferencia, ft_forma_participacao_conferencia, bo_oficial)
    				VALUES (?::INTEGER, ?::TEXT, ?::INTEGER, ?::DATE, ?::TEXT, ?::INTEGER, ?::TEXT, ?::BOOLEAN)
    			RETURNING id_conferencia;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
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
    	$query = 'SELECT * FROM portal.inserir_participacao_social_conferencia_outra(?::TEXT, ?::TEXT, ?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateParticipacaoSocialConferenciaOutra($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_participacao_social_conferencia_outra(?::TEXT, ?::TEXT, ?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteParticipacaoSocialConferenciaOutra($params)
    {
    	$query = 'DELETE FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia = ?::INTEGER;';
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
    	$query = 'SELECT * FROM portal.inserir_projeto(?::INTEGER, ?::TEXT, ?::TEXT, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT, ?::TEXT, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::INTEGER, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateProjeto($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_projeto(?::INTEGER, ?::INTEGER, ?::TEXT, ?::TEXT, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT, ?::TEXT, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::INTEGER, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteProjeto($params)
    {
    	$query = 'SELECT * FROM portal.excluir_projeto(?::INTEGER);';
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
    	$query = 'DELETE FROM osc.tb_publico_beneficiado_projeto WHERE id_publico_beneficiado = ?::INTEGER AND bo_oficial <> true RETURNING id_publico_beneficiado;';
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

	public function insertFonteRecursosProjeto($params)
    {
    	$query = 'INSERT INTO osc.tb_fonte_recursos_projeto (id_projeto, cd_origem_fonte_recursos_projeto, ft_fonte_recursos_projeto, cd_tipo_parceria, bo_oficial) VALUES (?::INTEGER, ?::INTEGER, ?::TEXT, ?::INTEGER, ?::BOOLEAN);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteFonteRecursosProjeto($params)
    {
    	$query = 'DELETE FROM osc.tb_fonte_recursos_projeto WHERE id_fonte_recursos_projeto = ?::INTEGER;';
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
    	$query = 'DELETE FROM osc.tb_financiador_projeto WHERE id_financiador_projeto = ?::INTEGER;';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

	public function setObjetivoProjeto($params)
    {
    	//$query = 'SELECT * FROM portal.inserir_objetivo_projeto(?::INTEGER, ?::INTEGER, ?::TEXT, ?::BOOLEAN);';

    	$query = 'INSERT INTO osc.tb_objetivo_projeto (id_projeto, cd_meta_projeto, ft_objetivo_projeto, bo_oficial)
					VALUES (?::INTEGER, (SELECT cd_meta_projeto FROM syst.dc_meta_projeto WHERE tx_codigo_meta_projeto = ?::TEXT), ?::TEXT, ?::BOOLEAN);';

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
    	//$query = 'SELECT * FROM portal.excluir_objetivo_projeto(?::INTEGER);';
    	$query = 'DELETE FROM osc.tb_objetivo_projeto WHERE id_objetivo_projeto = ?::INTEGER;';
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
    					cd_certificado = ?::INTEGER,
    					dt_inicio_certificado = ?::DATE,
    					ft_inicio_certificado = ?::TEXT,
    					dt_fim_certificado = ?::DATE,
    					ft_fim_certificado = ?::TEXT
    				WHERE
    					id_osc = ?::INTEGER AND
    					id_certificado = ?::INTEGER;';

    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteCertificado($params)
    {
    	//$query = 'SELECT * FROM portal.excluir_certificado(?::INTEGER, ?::INTEGER);';
    	$query = 'DELETE FROM osc.tb_certificado WHERE id_certificado = ?::INTEGER;';
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
