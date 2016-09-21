<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class OscController extends Controller{
    private $componentQueries = array(
    	/**
    	*	Estrutura: nome_componente => [query_sql, is_unique]
		*/
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

    private $content_response = ["message" => "Recurso não encontrado"];
    private $http_code = 404;

    private function executeQuery($component, $id){
        $result = null;
    	$query_info = $this->componentQueries[$component];
    	$query = $query_info[0];
    	$unique = $query_info[1];

    	$result_query = DB::select($query, [$id]);
    	if($result_query){
	    	if($unique){
	    		$result = json_encode(reset($result_query));
			}else{
	    		$result = json_encode($result_query);
			}
    	}

    	return $result;
    }

    private function configHttpCode(){
        if($this->content_response){
            $this->http_code = 200;
        }else{
            $this->http_code = 204;
        }
    }

    public function getOsc($id){
    	$this->content_response = array();
    	foreach ($this->componentQueries as $component => $query){
    		$result_query = json_decode($this->executeQuery($component, $id));
    		if($result_query){
                $this->content_response = array_merge($this->content_response, [$component => $result_query]);
    		}
		}
        $this->configHttpCode();
    	return Response($this->content_response, $this->http_code)->header('Content-Type', 'application/json');
    }

    public function getComponentOsc($component, $id){
        if(array_key_exists($component, $this->componentQueries)){
        	$this->content_response = $this->executeQuery($component, $id);
            $this->configHttpCode();
        }
        return Response($this->content_response, $this->http_code)->header('Content-Type', 'application/json');
    }
}
