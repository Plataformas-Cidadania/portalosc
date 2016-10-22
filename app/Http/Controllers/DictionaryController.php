<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Dao\DictionaryDao;

class DictionaryController extends Controller{
	private $dao;

	public function __construct() {
		$this->dao = new DictionaryDao();
	}

    public function getDictionaryOsc($dictionary){
		$region = trim($dictionary);

		$resultDao = $this->dao->getDictionaryOsc($dictionary);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function getDictionaryGeo($region, $param){
		$region = trim($region);
		$param = trim($param);

		$resultDao = $this->dao->getDictionaryRegion($region, $param);
		$this->configResponse($resultDao);
        return $this->response();
    }
}
