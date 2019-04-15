<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dao\SearchDao;
use App\Dao\Cache\CacheExportarDao;

class SearchController extends Controller
{
	private $dao;
	
	public function __construct()
	{
		$this->dao = new SearchDao();
	}
	
    public function getSearchList($type_result, $limit = 0, $offset = 0)
    {
		$param = [$limit, $offset];
		
		$resultDao = $this->dao->searchList($type_result, $param);
		$this->configResponse($resultDao);
        return $this->response();
    }
	
    public function getSearch($type_search, $type_result, $param, $limit = 0, $offset = 0, $tipoBusca = 0)
    {
		$param = urldecode($param);
    	$param = trim($param);
		$param = str_replace("'", "''", $param);
		
    	if($type_search == 'osc'){
    	    $param = [$param, $limit, $offset, $tipoBusca];
    	}else{
    		$param = [$param, $limit, $offset];
    	}
		
    	$resultDao = $this->dao->search($type_search, $type_result, $param);
    	$this->configResponse($resultDao);
    	
    	return $this->response();
    }
    
    public function getAdvancedSearch(Request $request, $type_result, $limit = 0, $offset = 0)
    {
    	$param = [$limit, $offset];
    	
    	if($request->input('avancado')){
			$avancado = $request->input('avancado');
			
			if(gettype($avancado) == 'string'){
    			$avancadoAjustado = array();
    			
    			foreach(json_decode($avancado) as $key => $value){
    				$avancadoAjustado[$key] = (array) $value;
    			}
    			
    			$avancado = $avancadoAjustado;
    		}
    		
    		if(is_array($avancado)){
    			$busca = (object) $avancado;
    		}else{
    			$busca = json_decode($avancado);
			}
			
			if(
				isset($busca->dadosGerais) || isset($busca->areasSubareasAtuacao) || isset($busca->atividadeEconomica) || 
				isset($busca->titulacoesCertificacoes) || isset($busca->relacoesTrabalhoGovernanca) || isset($busca->espacosParticipacaoSocial) || 
				isset($busca->projetos) || isset($busca->fontesRecursos) || isset($busca->IDH)
			){
				$resultado = new \stdClass();

				$buscaAvancadoDao = $this->dao->searchAdvancedList($type_result, $param, $busca);
				$resultado->lista_osc = $buscaAvancadoDao;
				
				$listaId = array_keys($buscaAvancadoDao);
				array_shift($listaId);

				$listaChave = $busca;
				unset($listaChave->Adicionais);

				$cache = new \stdClass();
				$cache->chave = md5(serialize($listaChave));
				$cache->valor = '{' . implode(",", $listaId) . '}';

				$resultado->chave_cache_exportar = $cache->chave;

				(new CacheExportarDao())->inserirExportar($cache);

				$this->configResponse($resultado);
			}else{
				$resultado = ['msg' => 'Atributos(s) obrigatório(s) não enviado(s).'];
				$this->configResponse($resultado, 400);
			}
    	}else{
			$resultado = ['msg' => 'Dado(s) obrigatório(s) não enviado(s).'];
			$this->configResponse($resultado, 400);
    	}
		
    	return $this->response();
    }
}
