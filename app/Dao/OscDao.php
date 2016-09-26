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
        "relacoes_trabalho" => ["SELECT * FROM portal.get_osc_relacoes_trabalho(?::INTEGER);", true]
    );

    public function getComponentOsc($component, $id)
    {
        if(array_key_exists($component, $this->componentQueries)){
        	$query_info = $this->componentQueries[$component];
	    	$query = $query_info[0];
	    	$unique = $query_info[1];
        	$result = $this->executeSelectQuery($query, $unique, [$id]);
        }
        return $result;
    }

    public function getOsc($id)
    {
    	$result = array();
    	foreach ($this->componentQueries as $component => $query){
    		$query_info = $this->componentQueries[$component];
	    	$query = $query_info[0];
	    	$unique = $query_info[1];
    		$result_query = json_decode($this->executeSelectQuery($query, $unique, [$id]));
    		if($result_query){
                $result = array_merge($result, [$component => $result_query]);
    		}
		}
        return $result;
    }
}
