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

    public function getSearchOsc($type_search, $type_result, $param, $limit = 0, $offset = 0)
    {
		$param = trim($param);
		
		$param = [$param, $limit, $offset];
		
		$resultDao = $this->dao->searchOsc($type_search, $type_result, $param, $offset);
		$this->configResponse($resultDao);
        return $this->response();
    }
}
