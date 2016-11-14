<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dao\ComponentDao;

class ComponentController extends Controller
{
	private $dao;

	public function __construct()
	{
		$this->dao = new ComponentDao();
	}

	public function getProjeto(Request $request, $id)
	{
		$id = trim($id);
		$resultDao = $this->dao->getProjeto($id);
		$this->configResponse($resultDao);
		return $this->response();
	}
}