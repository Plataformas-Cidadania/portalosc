<?php

namespace App\Dao;

use App\Dao\DaoPostgres;

class ComponentDao extends DaoPostgres
{
	public function getProjeto($param)
    {
    	$result = array();
    	$query = "SELECT 
    				id_osc, 
					tx_identificador_projeto_externo, 
					ft_identificador_projeto_externo, 
				    tx_nome_projeto, 
				    ft_nome_projeto, 
					cd_status_projeto, 
				    tx_nome_status_projeto, 
				    ft_status_projeto, 
				    dt_data_inicio_projeto, 
				    ft_data_inicio_projeto, 
				    dt_data_fim_projeto, 
				    ft_data_fim_projeto, 
				    tx_link_projeto, 
				    ft_link_projeto, 
				    nr_total_beneficiarios, 
				    ft_total_beneficiarios, 
				    nr_valor_total_projeto, 
				    ft_valor_total_projeto, 
				    nr_valor_captado_projeto, 
				    ft_valor_captado_projeto, 
				    tx_descricao_projeto, 
				    ft_descricao_projeto, 
				    tx_metodologia_monitoramento, 
				    ft_metodologia_monitoramento,
					cd_abrangencia_projeto, 
				    tx_nome_abrangencia_projeto, 
				    ft_abrangencia_projeto, 
					cd_zona_atuacao_projeto, 
				    tx_nome_zona_atuacao, 
				    ft_zona_atuacao_projeto 
    			FROM portal.obter_osc_projeto_id_projeto(?::INTEGER);";
        $result_query = $this->executarQuery($query, false, [$param]);

		if($result_query){
			$result_partial = array();

	        foreach($result_query as $key => $projeto){
				$result_projeto = array();

				foreach($projeto as $key_projeto => $value_projeto){
		        	$result_projeto = array_merge($result_projeto, [$key_projeto => $value_projeto]);
				}

		        $query = "SELECT id_fonte_recursos_projeto, cd_origem_fonte_recursos_projeto, tx_nome_origem_fonte_recursos_projeto AS tx_nome_valor, ft_fonte_recursos_projeto FROM portal.obter_osc_fonte_recursos_projeto(?::INTEGER);";
		        $result_query_partial = $this->executarQuery($query, false, [$param]);
		        if($result_query_partial){
		        	$array_partial = array();
		            foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
		        		$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
		        	}
		            $result_projeto = array_merge($result_projeto, ["fonte_recursos" => $array_partial]);
				}else{
					$result_projeto = array_merge($result_projeto, ["fonte_recursos" => null]);
				}
				
				$query = "SELECT id_tipo_parceria_projeto, cd_tipo_parceria_projeto, tx_nome_tipo_parceria AS tx_nome_valor, ft_tipo_parceria_projeto FROM portal.vw_osc_tipo_parceria_projeto WHERE id_projeto = ?::INTEGER;";
		        $result_query_partial = $this->executarQuery($query, false, [$param]);
		        if($result_query_partial){
		        	$array_partial = array();
		            foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
		        		$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
		        	}
		            $result_projeto = array_merge($result_projeto, ["tipo_parceria" => $array_partial]);
				}else{
					$result_projeto = array_merge($result_projeto, ["tipo_parceria" => null]);
				}
				
				$query = "SELECT * FROM portal.obter_osc_publico_beneficiado_projeto(?::INTEGER);";
				$result_query_partial = $this->executarQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["publico_beneficiado" => $array_partial]);
				}

				$query = "SELECT id_financiador_projeto, tx_nome_financiador, ft_nome_financiador FROM portal.vw_osc_financiador_projeto WHERE id_projeto = ?::INTEGER;";
				$result_query_partial = $this->executarQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["financiador_projeto" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_area_atuacao_projeto(?::INTEGER);";
				$result_query_partial = $this->executarQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["area_atuacao" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_area_atuacao_outra_projeto(?::INTEGER);";
				$result_query_partial = $this->executarQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["area_atuacao_outra" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_localizacao_projeto(?::INTEGER);";
				$result_query_partial = $this->executarQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["localizacao" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_parceira_projeto(?::INTEGER);";
				$result_query_partial = $this->executarQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["osc_parceira" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_objetivo_projeto(?::INTEGER);";
				$result_query_partial = $this->executarQuery($query, false, [$param]);
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
		        	$result_query = $this->executarQuery($query, true, [$param]);

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





	public function getProjeto2($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_projeto_id_projeto(?::INTEGER);";
        $result_query = $this->executarQuery($query, true, [$param]);

		if($result_query){
			$result_projeto = array();

			foreach($result_query as $key_projeto => $value_projeto){
	        	$result_projeto = array_merge($result_projeto, [$key_projeto => $value_projeto]);
			}

	        $query = "SELECT * FROM portal.obter_osc_fonte_recursos_projeto(?::INTEGER);";
	        $result_query_partial = $this->executarQuery($query, false, [$param]);
	        if($result_query_partial){
	        	$array_partial = array();
	            foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
	        		$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
	        	}
	            $result_projeto = array_merge($result_projeto, ["fonte_recursos" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_publico_beneficiado_projeto(?::INTEGER);";
			$result_query_partial = $this->executarQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["publico_beneficiado" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_area_atuacao_projeto(?::INTEGER);";
			$result_query_partial = $this->executarQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["area_atuacao" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_area_atuacao_outra_projeto(?::INTEGER);";
			$result_query_partial = $this->executarQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["area_atuacao_outra" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_localizacao_projeto(?::INTEGER);";
			$result_query_partial = $this->executarQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["localizacao" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_parceira_projeto(?::INTEGER);";
			$result_query_partial = $this->executarQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["localizacao" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_objetivo_projeto(?::INTEGER);";
			$result_query_partial = $this->executarQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["localizacao" => $array_partial]);
			}

			$result = array_merge($result, $result_projeto);

        	return $result;
		}
    }
}
