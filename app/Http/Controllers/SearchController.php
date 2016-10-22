<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Dao\SearchDao;

class SearchController extends Controller{
	private $dao;

	public function __construct() {
		$this->dao = new SearchDao();
	}

    public function getSearchOsc($type, $param, $limit = 0){
		$param = trim($param);
		
		if($type == "osc"){
			$param = [$param, $limit];
		}else{
			$param = [$param];
		}
		
		$resultDao = $this->dao->searchOsc($type, $param);
		$this->configResponse($resultDao);
        return $this->response();
    }
}
