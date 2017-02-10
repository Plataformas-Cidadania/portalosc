<?php

namespace App\Dao;

use App\Dao\Dao;

class ComponentDao extends Dao
{
	public function getProjeto($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_projeto_id_projeto(?::INTEGER);";
        $result_query = $this->executeQuery($query, false, [$param]);

		if($result_query){
			$result_partial = array();

	        foreach($result_query as $key => $projeto){
				$result_projeto = array();

				foreach($projeto as $key_projeto => $value_projeto){
		        	$result_projeto = array_merge($result_projeto, [$key_projeto => $value_projeto]);
				}

		        $query = "SELECT * FROM portal.obter_osc_fonte_recursos_projeto(?::INTEGER);";
		        $result_query_partial = $this->executeQuery($query, false, [$param]);
		        if($result_query_partial){
		        	$array_partial = array();
		            foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
		        		$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
		        	}
		            $result_projeto = array_merge($result_projeto, ["fonte_recursos" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_publico_beneficiado_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["publico_beneficiado" => $array_partial]);
				}

				$query = "SELECT id_financiador_projeto, tx_nome_financiador, ft_nome_financiador FROM portal.vw_osc_financiador_projeto WHERE id_projeto = ?::INTEGER;";
				$result_query_partial = $this->executeQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["financiador_projeto" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_area_atuacao_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["area_atuacao" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_area_atuacao_outra_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["area_atuacao_outra" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_localizacao_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["localizacao" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_parceira_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, false, [$param]);
				if($result_query_partial){
					$array_partial = array();
					foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
						$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
					}
					$result_projeto = array_merge($result_projeto, ["osc_parceira" => $array_partial]);
				}

				$query = "SELECT * FROM portal.obter_osc_objetivo_projeto(?::INTEGER);";
				$result_query_partial = $this->executeQuery($query, true, [$param]);
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





	public function getProjeto2($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_projeto_id_projeto(?::INTEGER);";
        $result_query = $this->executeQuery($query, true, [$param]);

		if($result_query){
			$result_projeto = array();

			foreach($result_query as $key_projeto => $value_projeto){
	        	$result_projeto = array_merge($result_projeto, [$key_projeto => $value_projeto]);
			}

	        $query = "SELECT * FROM portal.obter_osc_fonte_recursos_projeto(?::INTEGER);";
	        $result_query_partial = $this->executeQuery($query, false, [$param]);
	        if($result_query_partial){
	        	$array_partial = array();
	            foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
	        		$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
	        	}
	            $result_projeto = array_merge($result_projeto, ["fonte_recursos" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_publico_beneficiado_projeto(?::INTEGER);";
			$result_query_partial = $this->executeQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["publico_beneficiado" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_area_atuacao_projeto(?::INTEGER);";
			$result_query_partial = $this->executeQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["area_atuacao" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_area_atuacao_outra_projeto(?::INTEGER);";
			$result_query_partial = $this->executeQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["area_atuacao_outra" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_localizacao_projeto(?::INTEGER);";
			$result_query_partial = $this->executeQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["localizacao" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_parceira_projeto(?::INTEGER);";
			$result_query_partial = $this->executeQuery($query, false, [$param]);
			if($result_query_partial){
				$array_partial = array();
				foreach($result_query_partial as $key_recursos_projeto => $value_recursos_projeto){
					$array_partial = array_merge($array_partial, [$key_recursos_projeto => $value_recursos_projeto]);
				}
				$result_projeto = array_merge($result_projeto, ["localizacao" => $array_partial]);
			}

			$query = "SELECT * FROM portal.obter_osc_objetivo_projeto(?::INTEGER);";
			$result_query_partial = $this->executeQuery($query, false, [$param]);
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
