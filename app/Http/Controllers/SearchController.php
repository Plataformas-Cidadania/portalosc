<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
	
    public function getSearch($type_search, $type_result, $param, $limit = 0, $offset = 0, $similarity = '05')
    {
    	$param = trim($param);
		
    	$similarity = '0.' . $similarity;
    	
    	if($type_search == 'osc'){
    		$param = [$param, $limit, $offset, $similarity];
    	}else{
    		$param = [$param, $limit, $offset];
    	}
		
    	$resultDao = $this->dao->search($type_search, $type_result, $param);
    	$this->configResponse($resultDao);
    	
    	return $this->response();
    }
}
