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

    	$result_query = $this->getComponentOsc("certificado", $param);
    	if($result_query){
    		$result = array_merge($result, ["certificado" => json_decode($result_query)]);
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

    	$result_query = $this->getComponentOsc("recursos", $param);
    	if($result_query){
    		$result = array_merge($result, ["recursos" => json_decode($result_query)]);
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
    	$result_query = $this->executeQuery($query, false, [$param]);
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

    private function getCertificado($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_certificado(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["certificado" => json_decode($result_query)]);
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

    	$query = "SELECT * FROM portal.obter_osc_participacao_social_conferencia_outra(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["conferencia_outra" => json_decode($result_query)]);
    	}

    	$query = "SELECT * FROM portal.obter_osc_participacao_social_conselho(?::TEXT);";
    	$result_query_conselho = $this->executeQuery($query, false, [$param]);
    	if($result_query_conselho){
    		$result_partial = array();
            
    		foreach(json_decode($result_query_conselho) as $conselho){
    			$result_conselho = array();
    			$result_conselho = array_merge($result_conselho, ["conselho" => $conselho]);
    			$query = "SELECT * FROM portal.obter_osc_representante_conselho(?::TEXT);";
    			$result_query_representante = $this->executeQuery($query, false, [$conselho->id_conselho]);
    			if($result_query_representante){
    				$result_conselho = array_merge($result_conselho, ["representante" => json_decode($result_query_representante)]);
    			}
    			$result_partial = array_merge($result_partial, $result_conselho);
    		}
    		$result = array_merge($result, ['conselho' => $result_partial]);
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
            $query = "SELECT * FROM portal.obter_recursos_projeto(?::TEXT);";
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

    private function getRecursosOsc($param)
    {
    	$result = array();
    	$query = "SELECT * FROM portal.obter_osc_recursos_osc(?::TEXT);";
    	$result_query = $this->executeQuery($query, true, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["recursos" => json_decode($result_query)]);
    	}

        if(count($result) == 0){
            return null;
        }else{
            return json_encode($result);
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

    public function setContatos($params)
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

    public function setAreaAtuacao($params)
    {
    	$query = 'SELECT * FROM portal.inserir_area_atuacao(?::INTEGER, ?::INTEGER, ?::TEXT, ?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateAreaAtuacao($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_area_atuacao(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteAreaAtuacao($params)
    {
    	$query = 'SELECT * FROM portal.excluir_area_atuacao(?::INTEGER);';
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

    public function setDirigente($params)
    {
    	$query = 'SELECT * FROM portal.inserir_dirigente(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT);';
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
    	$query = 'SELECT * FROM portal.inserir_membro_conselho(?::INTEGER, ?::TEXT, ?::TEXT);';
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

    public function setTrabalhadores($params)
    {
    	$query = 'SELECT * FROM portal.inserir_trabalhador(?::INTEGER, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateTrabalhadores($params)
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

    public function setParticipacaoSocialConselho($params)
    {
    	$query = 'SELECT * FROM portal.inserir_participacao_social_conselho(?::INTEGER, ?::INTEGER, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function updateParticipacaoSocialConselho($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_participacao_social_conselho(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function deleteParticipacaoSocialConselho($params)
    {
    	$query = 'SELECT * FROM portal.excluir_participacao_social_conselho(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }

    public function setParticipacaoSocialConferencia($params)
    {
    	$query = 'SELECT * FROM portal.inserir_participacao_social_conferencia(?::INTEGER, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::INTEGER, ?::TEXT);';
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
    	$query = 'SELECT * FROM portal.inserir_participacao_social_conferencia_outra(?::INTEGER, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
    
    public function updateParticipacaoSocialConferenciaOutra($params)
    {
    	$query = 'SELECT * FROM portal.atualizar_participacao_social_conferencia_outra(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DATE, ?::TEXT, ?::INTEGER, ?::TEXT);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
    
    public function deleteParticipacaoSocialConferenciaOutra($params)
    {
    	$query = 'SELECT * FROM portal.excluir_participacao_social_conferencia_outra(?::INTEGER);';
    	$result = $this->executeQuery($query, true, $params);
    	return $result;
    }
}
