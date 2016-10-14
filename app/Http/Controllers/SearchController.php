<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Dao\SearchDao;

class SearchController extends Controller{
	private $dao;

	public function __construct() {
		$this->dao = new SearchDao();
	}

    public function getSearchOsc($param){
		$param = trim(urldecode($param));
		
		$resultDao = $this->dao->searchOsc();
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function getSearchRegion($region, $param){
		$region = trim(urldecode($region));
		$param = trim(urldecode($param));

		$resultDao = $this->dao->searchRegion($region, $param);
		$this->configResponse($resultDao);
        return $this->response();
    }
}
