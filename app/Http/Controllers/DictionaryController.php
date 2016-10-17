<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Dao\DictionaryDao;

class DictionaryController extends Controller{
	private $dao;

	public function __construct() {
		$this->dao = new DictionaryDao();
	}

    public function getDictionaryGeo($region, $param){
		$region = "'".trim(urldecode($region))."'";
		$param = "'".trim(urldecode($param))."'";

		$resultDao = $this->dao->getDictionaryRegion($region, $param);
		$this->configResponse($resultDao);
        return $this->response();
    }
}
