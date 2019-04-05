<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dao\SearchDao;

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
    		
			$resultDao = $this->dao->searchAdvancedList($type_result, $param, $busca);
			$this->configResponse($resultDao);
    	}else{
			$resultDao = ['msg' => 'Dado(s) obrigatório(s) não enviado(s).'];
			$this->configResponse($resultDao, 400);
    	}
		
    	return $this->response();
    }
}
