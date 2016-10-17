<?php

namespace App\Dao;

use App\Dao\Dao;

class OscDao extends Dao
{
    public function getComponentOsc($component, $param)
    {
    	switch ($component) {
    		case "area_atuacao_fasfil":
        		$result = $this->getAreaAtuacaoFasfil($param);
    			break;

    		case "area_atuacao_outras":
    			$result = $this->getAreaAtuacaoOutra($param);
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

    		case "dirigente":
    			$result = $this->getDirigente($param);
    			break;

    		case "participacao_social":
    			$result = $this->getParticipacaoSocial($param);
    			break;

    		case "projeto":
    			$result = $this->getProjeto($param);
    			break;

    		case "recursos":
    			$result = $this->getRecursos($param);
    			break;

    		case "relacoes_trabalho":
    			$result = $this->getRelacoesTrabalho($param);
    			break;

    		default:
    			$result = null;
    	}
    	return $result;
    }

    public function getOsc($param)
    {
    	$result = array();

    	$result_query = $this->getComponentOsc("area_atuacao_fasfil", $param);
    	if($result_query){
    		$result = array_merge($result, ["area_atuacao_fasfil" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("area_atuacao_outras", $param);
    	if($result_query){
    		$result = array_merge($result, ["area_atuacao_outras" => json_decode($result_query)]);
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

    	$result_query = $this->getComponentOsc("dirigente", $param);
    	if($result_query){
    		$result = array_merge($result, ["dirigente" => json_decode($result_query)]);
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

    	$result_query = $this->getComponentOsc("relacoes_trabalho", $param);
    	if($result_query){
    		$result = array_merge($result, ["relacoes_trabalho" => json_decode($result_query)]);
    	}

    	return $result;
    }



    private function getAreaAtuacaoFasfil($param)
    {
    	$query = "SELECT * FROM portal.obter_osc_area_atuacao_fasfil(?::TEXT);";
    	return $this->executeQuery($query, true, [$param]);
    }

    private function getAreaAtuacaoOutra($param)
    {
    	$query = "SELECT * FROM portal.obter_osc_area_atuacao_outra(?::TEXT);";
    	return $this->executeQuery($query, true, [$param]);
    }

    private function getCabecalho($param)
    {

    	$query = "SELECT * FROM portal.obter_osc_cabecalho(?::TEXT);";
    	return $this->executeQuery($query, true, [$param]);
    }

    private function getCertificacao($param)
    {
    	$query = "SELECT * FROM portal.obter_osc_certificacao(?::TEXT);";
    	return $this->executeQuery($query, false, [$param]);
    }

    private function getDadosGerais($param)
    {
    	$query = "SELECT * FROM portal.obter_osc_dados_gerais(?::TEXT);";
    	return $this->executeQuery($query, true, [$param]);
    }

    private function getDescricao($param)
    {
    	$query = "SELECT * FROM portal.obter_osc_descricao(?::TEXT);";
    	return $this->executeQuery($query, true, [$param]);
    }

    private function getDirigente($param)
    {
    	$query = "SELECT * FROM portal.obter_osc_dirigente(?::TEXT);";
    	return $this->executeQuery($query, false, [$param]);
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

    	return json_encode($result);
    }

    private function getProjeto($param)
    {
    	$query = "SELECT * FROM portal.obter_osc_projeto(?::TEXT);";
    	return $this->executeQuery($query, false, [$param]);
    }

    private function getRecursos($param)
    {
    	$result = array();

    	$query = "SELECT * FROM portal.obter_osc_recursos(?::TEXT);";
    	$result_query = $this->executeQuery($query, true, [$param]);
    	if($result_query){
    		foreach(json_decode($result_query) as $key => $value){
    			$result = array_merge($result, [$key => $value]);
    		}
    	}

    	$query = "SELECT * FROM portal.obter_osc_conselho_contabil(?::TEXT);";
    	$result_query = $this->executeQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["conselho_contabil" => json_decode($result_query)]);
    	}

    	return json_encode($result);
    }

    private function getRelacoesTrabalho($param)
    {
    	$query = "SELECT * FROM portal.obter_osc_relacoes_trabalho(?::TEXT);";
    	return $this->executeQuery($query, true, [$param]);
    }
}
