<?php

namespace App\Dao;

use App\Dao\Dao;

class OscDao extends Dao
{
    public function getComponentOsc($component, $param)
    {
    	switch ($component) {
    		case "area_atuacao":
        		$result = $this->getAreaAtuacao($param);
    			break;

    		case "cabecalho":
    			$result = $this->getCabecalho($param);
    			break;

    		case "certificacao":
    			$result = $this->getCertificacao($param);
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

    		case "relacoes_trabalho_governanca":
    			$result = $this->getRelacoesTrabalhoGovernanca($param);
    			break;

    		default:
    			$result = null;
    	}
    	return $result;
    }

    public function getOsc($param)
    {
    	$result = array();

    	$result_query = $this->getComponentOsc("area_atuacao", $param);
    	if($result_query){
    		$result = array_merge($result, ["area_atuacao" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("cabecalho", $param);
    	if($result_query){
    		$result = array_merge($result, ["cabecalho" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("certificacao", $param);
    	if($result_query){
    		$result = array_merge($result, ["certificacao" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("dados_gerais", $param);
    	if($result_query){
    		$result = array_merge($result, ["dados_gerais" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("descricao", $param);
    	if($result_query){
    		$result = array_merge($result, ["descricao" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("participacao_social", $param);
    	if($result_query){
    		$result = array_merge($result, ["participacao_social" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("projeto", $param);
    	if($result_query){
    		$result = array_merge($result, ["projeto" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("relacoes_trabalho_governanca", $param);
    	if($result_query){
    		$result = array_merge($result, ["relacoes_trabalho_governanca" => json_decode($result_query)]);
    	}

    	return $result;
    }



    private function getAreaAtuacao($param)
    {
    	$result = array();

    	$query = "SELECT * FROM portal.obter_osc_area_atuacao(?::TEXT);";
    	$result_query = $this->executeQuery($query, true, [$param]);

    	if($result_query){
    		$result = array_merge($result, ["area_atuacao" => json_decode($result_query)]);
    	}

        $query = "SELECT * FROM portal.obter_osc_area_atuacao_outra(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["area_atuacao_outra" => json_decode($result_query)]);
    	}

        if(count($result) == 0){
            return null;
        }else{
            return json_encode($result);
        }
    }

    private function getCabecalho($param)
    {
        $query = "SELECT * FROM portal.obter_osc_cabecalho(?::TEXT);";
    	return $this->executeQuery($query, true, [$param]);
    }

    private function getCertificacao($param)
    {
    	$result = array();

    	$query = "SELECT * FROM portal.obter_osc_certificacao(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["certificado" => json_decode($result_query)]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_utilidade_publica_estadual(?::TEXT);";
    	$result_query = $this->executeQuery($query, true, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["utilidade_publica_estadual" => json_decode($result_query)]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_utilidade_publica_municipal(?::TEXT);";
    	$result_query = $this->executeQuery($query, true, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["utilidade_publica_municipal" => json_decode($result_query)]);
    	}

        if(count($result) == 0){
            return null;
        }else{
            return json_encode($result);
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
            foreach(json_decode($result_query) as $value){
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
    		$result = array_merge($result, ["conferencia" => json_decode($result_query)]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_participacao_social_conselho(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["conselho" => json_decode($result_query)]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_participacao_social_outra(?::TEXT);";
	    $result_query = $this->executeQuery($query, false, [$param]);
        if($result_query){
        	$result = array_merge($result, ["outra" => json_decode($result_query)]);
        }

        if(count($result) == 0){
            return null;
        }else{
            return json_encode($result);
        }
    }

    private function getProjeto($param)
    {
    	$result = array();

    	$query = "SELECT * FROM portal.obter_osc_projeto(?::TEXT);";
        $result_query = $this->executeQuery($query, false, [$param]);
        if($result_query){
        	$result = array_merge($result, ["projeto" => json_decode($result_query)]);
        }

        if(count($result) == 0){
            return null;
        }else{
            $query = "SELECT * FROM portal.obter_osc_recursos(?::TEXT);";
        	$result_query = $this->executeQuery($query, true, [$param]);
        	if($result_query){
                $result_partial = array();
                foreach(json_decode($result_query) as $key => $value){
        			$result_partial = array_merge($result_partial, [$key => $value]);
        		}
                $result = array_merge($result, ["recursos" => $result_partial]);
        	}

            if(count($result) == 0){
                return null;
            }else{
                return json_encode($result);
            }
        }
    }

    private function getRelacoesTrabalhoGovernanca($param)
    {
    	$result = array();

    	$query = "SELECT * FROM portal.obter_osc_relacoes_trabalho(?::TEXT);";
    	$result_query = $this->executeQuery($query, true, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["relacoes_trabalho" => json_decode($result_query)]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_relacoes_trabalho_outra(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["relacoes_trabalho_outra" => json_decode($result_query)]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_governanca(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["governanca" => json_decode($result_query)]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_conselho_fiscal(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["conselho_fiscal" => json_decode($result_query)]);
    	}

        if(count($result) == 0){
            return null;
        }else{
            return json_encode($result);
        }
    }
}
