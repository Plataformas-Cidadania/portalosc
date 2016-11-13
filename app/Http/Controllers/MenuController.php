<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Dao\MenuDao;

class MenuController extends Controller
{
	private $dao;

	public function __construct()
	{
		$this->dao = new MenuDao();
	}

    public function getMenuOsc($menu, $param = null)
    {
		$region = trim($menu);

		$resultDao = $this->dao->getMenuOsc($menu, $param);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function getMenuGeo($region, $param)
    {
		$region = trim($region);
		$param = trim(urldecode($param));

		$resultDao = $this->dao->getMenuRegion($region, $param);
		$this->configResponse($resultDao);
        return $this->response();
    }
}
