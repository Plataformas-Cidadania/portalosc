<?php

namespace App\Dao;

use App\Dao\Dao;

class OscDao extends Dao
{
	public $componentQueries = array
    (
    	# Estrutura: nome_componente => [query_sql, is_unique]
        "area_atuacao_fasfil" => ["SELECT * FROM portal.get_osc_area_atuacao_fasfil(?::INTEGER);", true],
        "area_atuacao_outras" => ["SELECT * FROM portal.get_osc_area_atuacao_outra(?::INTEGER);", true],
        "cabecalho" => ["SELECT * FROM portal.get_osc_cabecalho(?::INTEGER);", true],
    	"certificacao" => ["SELECT * FROM portal.get_osc_certificacao(?::INTEGER);", false],
        "conferencia" => ["SELECT * FROM portal.get_osc_conferencia(?::INTEGER);", false],
        "dados_gerais" => ["SELECT * FROM portal.get_osc_dados_gerais(?::INTEGER);", true],
        "descricao" => ["SELECT * FROM portal.get_osc_descricao(?::INTEGER);", true],
        "dirigente" => ["SELECT * FROM portal.get_osc_dirigente(?::INTEGER);", false],
        "projeto" => ["SELECT * FROM portal.get_osc_projeto(?::INTEGER);", false],
        "recursos" => ["SELECT * FROM portal.get_osc_recursos(?::INTEGER);", true],
    	"conselho_contabil" => ["SELECT * FROM portal.get_osc_conselho_contabil(?::INTEGER);", false],
        "relacoes_trabalho" => ["SELECT * FROM portal.get_osc_relacoes_trabalho(?::INTEGER);", true],
    	"participacao_social_conferencia" => ["SELECT * FROM portal.get_osc_relacoes_trabalho(?::INTEGER);", false],
    	"participacao_social_conselho" => ["SELECT * FROM portal.get_osc_participacao_social_conselho(?::INTEGER);", false],
    	"participacao_social_outra" => ["SELECT * FROM portal.get_osc_participacao_social_outra(?::INTEGER);", false]
    );
	
    public function getComponentOsc($component, $id)
    {
    	switch ($component) {
    		case "area_atuacao_fasfil":
    			$query = "SELECT * FROM portal.get_osc_area_atuacao_fasfil(?::INTEGER);";
	    		$unique = true;
        		$result = $this->executeSelectQuery($query, $unique, [$id]);
    			break;
    			
    		case "area_atuacao_outras":
    			$query = "SELECT * FROM portal.get_osc_area_atuacao_outra(?::INTEGER);";
    			$unique = true;
    			$result = $this->executeSelectQuery($query, $unique, [$id]);
    			break;
    			
    		case "dados_gerais":
    			$query = "SELECT * FROM portal.get_osc_dados_gerais(?::INTEGER);";
	    		$unique = true;
        		$result = $this->executeSelectQuery($query, $unique, [$id]);
    			break;
    			
    		case "participacao_social":
    			$query_conferencia = "SELECT * FROM portal.get_osc_participacao_social_conferencia(?::INTEGER);";
    			$query_conselho = "SELECT * FROM portal.get_osc_participacao_social_conselho(?::INTEGER);";
    			$query_outra = "SELECT * FROM portal.get_osc_participacao_social_outra(?::INTEGER);";
	    		$unique = false;
	    		
        		$result_conferencia = $this->executeSelectQuery($query_conferencia, $unique, [$id]);
        		$result_conselho = $this->executeSelectQuery($query_conselho, $unique, [$id]);
        		$result_outra = $this->executeSelectQuery($query_outra, $unique, [$id]);
				
        		$result = array();        		
        		if($result_conferencia){
        			$result = array_merge($result, ["conferencia" => json_decode($result_conferencia)]);
    			}
        		
        		if($result_conselho){
        			$result = array_merge($result, ["conselho" => json_decode($result_conselho)]);
        		}
        		
        		if($result_outra){
        			$result = array_merge($result, ["outra" => json_decode($result_outra)]);
        		}
        		
    			break;
    			
    		case "recursos":
    			$query_recursos = "SELECT * FROM portal.get_osc_recursos(?::INTEGER);";
    			$query_conselho_contabil = "SELECT * FROM portal.get_osc_conselho_contabil(?::INTEGER);";
    			$unique_recursos = true;
    			$unique_conselho_contabil = false;
    			
    			$result_recursos = $this->executeSelectQuery($query_recursos, $unique, [$id]);
    			$result_conselho_contabil = $this->executeSelectQuery($query_conselho_contabil, $unique_conselho_contabil, [$id]);
    			
    			$result = array();
    			if($query_recursos){
    				$result = array_merge($result, ["conferencia" => json_decode($query_recursos)]);
    			}
    			
    			if($query_conselho_contabil){
    				$result = array_merge($result, ["conselho" => json_decode($query_conselho_contabil)]);
    			}
    			
    			break;
    		default:
    			$result = null;
    	}
    	return $result;
    }
    
    public function getOsc($id)
    {    	
    	$result_dados_gerais = $this->getComponentOsc("dados_gerais", $id);
    	$result_participacao_social = $this->getComponentOsc("participacao_social", $id);
    	
    	$result = array();
    	
    	if($result_dados_gerais){
    		$result = array_merge($result, ["dados_gerais" => json_decode($result_dados_gerais)]);
    	}
    	if($result_participacao_social){
    		$result = array_merge($result, ["participacao_social" => $result_participacao_social]);
    	}
    	
    	return $result;
    }
}
