<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dao\EditalDao;

class EditalController extends Controller
{
	private $dao;

	public function __construct()
	{
		$this->dao = new EditalDao();
	}

	public function getEditais()
	{
		$resultDao = $this->dao->getEditais();
		$this->configResponse($resultDao);
		return $this->response();
	}

	public function createEdital(Request $request)
	{
		$orgao = $request->input('tx_orgao');
		$programa = $request->input('tx_programa');
		$areainteresse = $request->input('tx_area_interesse_edital');
		$dtvencimento = $request->input('dt_vencimento');
		$link = $request->input('tx_link_edital');
		$numerochamada = $request->input('tx_numero_chamada');

		$params = [$orgao, $programa, $areainteresse, $dtvencimento, $link, $numerochamada];
		$resultDao = json_decode($this->dao->createEdital($params));
	}
}
