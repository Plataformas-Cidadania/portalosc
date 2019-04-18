<?php

namespace App\Http\Controllers;

use App\Dao\GeoDao;

class GeoController extends Controller
{
	private $dao;

	public function __construct()
	{
		$this->dao = new GeoDao();
	}

    public function getOsc($id)
	{
		$id = trim($id);
		$result = $this->dao->getOsc($id);
		$this->configResponse($result);
        return $this->response();
    }

    public function getOscRegion($region, $id)
	{
		$region = trim($region);
		$id = trim($id);
		if(array_key_exists($region, $this->dao->queriesRegion)){
			$resultDao = $this->dao->getOscRegion($region, $id);
			$this->configResponse($resultDao);
		}
        return $this->response();
    }

    public function getOscCountry()
	{
		$result = $this->dao->getOscCountry();
		$this->configResponse($result);
        return $this->response();
    }

	public function getOscArea()
	{
		$result = $this->dao->getOscArea();
		$this->configResponse($result);
        return $this->response();
	}

    public function getClusterRegion($region, $id = 0)
	{
		$result = $this->dao->getClusterRegion($region, $id);
		$this->configResponse($result);
        return $this->response();
    }
}