<?php

namespace App\Dao;

use App\Dao\Dao;

class OscDao extends Dao
{
    public function getComponentOsc($component, $id)
    {
    	switch ($component) {
    		case "area_atuacao_fasfil":
        		$result = $this->getAreaAtuacaoFasfil($id);
    			break;

    		case "area_atuacao_outras":
    			$result = $this->getAreaAtuacaoOutra($id);
    			break;

    		case "cabecalho":
    			$result = $this->getCabecalho($id);
    			break;

    		case "certificacao":
    			$result = $this->getCertificacao($id);
    			break;

    		case "dados_gerais":
    			$result = $this->getDadosGerais($id);
    			break;

    		case "descricao":
    			$result = $this->getDescricao($id);
    			break;

    		case "dirigente":
    			$result = $this->getDirigente($id);
    			break;

    		case "participacao_social":
    			$result = $this->getParticipacaoSocial($id);
    			break;

    		case "projeto":
    			$result = $this->getProjeto($id);
    			break;

    		case "recursos":
    			$result = $this->getRecursos($id);
    			break;

    		case "relacoes_trabalho":
    			$result = $this->getRelacoesTrabalho($id);
    			break;

    		default:
    			$result = null;
    	}
    	return $result;
    }

    public function getOsc($id)
    {
    	$result = array();

    	$result_query = $this->getComponentOsc("area_atuacao_fasfil", $id);
    	if($result_query){
    		$result = array_merge($result, ["area_atuacao_fasfil" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("area_atuacao_outras", $id);
    	if($result_query){
    		$result = array_merge($result, ["area_atuacao_outras" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("cabecalho", $id);
    	if($result_query){
    		$result = array_merge($result, ["cabecalho" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("certificacao", $id);
    	if($result_query){
    		$result = array_merge($result, ["certificacao" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("dados_gerais", $id);
    	if($result_query){
    		$result = array_merge($result, ["dados_gerais" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("descricao", $id);
    	if($result_query){
    		$result = array_merge($result, ["descricao" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("dirigente", $id);
    	if($result_query){
    		$result = array_merge($result, ["dirigente" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("participacao_social", $id);
    	if($result_query){
    		$result = array_merge($result, ["participacao_social" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("projeto", $id);
    	if($result_query){
    		$result = array_merge($result, ["projeto" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("recursos", $id);
    	if($result_query){
    		$result = array_merge($result, ["recursos" => json_decode($result_query)]);
    	}

    	$result_query = $this->getComponentOsc("relacoes_trabalho", $id);
    	if($result_query){
    		$result = array_merge($result, ["relacoes_trabalho" => json_decode($result_query)]);
    	}

    	return $result;
    }



    private function getAreaAtuacaoFasfil($id)
    {
    	$query = "SELECT * FROM portal.get_osc_area_atuacao_fasfil(?::INTEGER);";
    	return $this->executeQuery($query, true, [$id]);
    }

    private function getAreaAtuacaoOutra($id)
    {
    	$query = "SELECT * FROM portal.get_osc_area_atuacao_outra(?::INTEGER);";
    	return $this->executeQuery($query, true, [$id]);
    }

    private function getCabecalho($id)
    {

    	$query = "SELECT * FROM portal.get_osc_cabecalho(?::INTEGER);";
    	return $this->executeQuery($query, true, [$id]);
    }

    private function getCertificacao($id)
    {
    	$query = "SELECT * FROM portal.get_osc_certificacao(?::INTEGER);";
    	return $this->executeQuery($query, false, [$id]);
    }

    private function getDadosGerais($id)
    {
    	$query = "SELECT * FROM portal.get_osc_dados_gerais(?::INTEGER);";
    	return $this->executeQuery($query, true, [$id]);
    }

    private function getDescricao($id)
    {
    	$query = "SELECT * FROM portal.get_osc_descricao(?::INTEGER);";
    	return $this->executeQuery($query, true, [$id]);
    }

    private function getDirigente($id)
    {
    	$query = "SELECT * FROM portal.get_osc_dirigente(?::INTEGER);";
    	return $this->executeQuery($query, false, [$id]);
    }

    private function getParticipacaoSocial($id)
    {
    	$result = array();

    	$query = "SELECT * FROM portal.get_osc_participacao_social_conferencia(?::INTEGER);";
    	$result_query = $this->executeQuery($query, false, [$id]);
    	if($result_query){
    		$result = array_merge($result, ["conferencia" => json_decode($result_query)]);
    	}
    	$query = "SELECT * FROM portal.get_osc_participacao_social_conselho(?::INTEGER);";
    	$result_query = $this->executeQuery($query, false, [$id]);
    	if($result_query){
    		$result = array_merge($result, ["conselho" => json_decode($result_query)]);
    	}
    	$query = "SELECT * FROM portal.get_osc_participacao_social_outra(?::INTEGER);";
	    $result_query = $this->executeQuery($query, false, [$id]);
        if($result_query){
        	$result = array_merge($result, ["outra" => json_decode($result_query)]);
        }

    	return json_encode($result);
    }

    private function getProjeto($id)
    {
    	$query = "SELECT * FROM portal.get_osc_projeto(?::INTEGER);";
    	return $this->executeQuery($query, false, [$id]);
    }

    private function getRecursos($id)
    {
    	$result = array();

    	$query = "SELECT * FROM portal.get_osc_recursos(?::INTEGER);";
    	$result_query = $this->executeQuery($query, true, [$id]);
    	if($result_query){
    		foreach(json_decode($result_query) as $key => $value){
    			$result = array_merge($result, [$key => $value]);
    		}
    	}

    	$query = "SELECT * FROM portal.get_osc_conselho_contabil(?::INTEGER);";
    	$result_query = $this->executeQuery($query, false, [$id]);
    	if($result_query){
    		$result = array_merge($result, ["conselho_contabil" => json_decode($result_query)]);
    	}

    	return json_encode($result);
    }

    private function getRelacoesTrabalho($id)
    {
    	$query = "SELECT * FROM portal.get_osc_relacoes_trabalho(?::INTEGER);";
    	return $this->executeQuery($query, true, [$id]);
    }
}
