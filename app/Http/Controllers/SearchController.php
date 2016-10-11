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
		$resultDao = $this->dao->searchOsc($param);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function getSearchRegion($region, $param){
		$resultDao = $this->dao->searchRegion($region, $param);
		$this->configResponse($resultDao);
        return $this->response();
    }
}
