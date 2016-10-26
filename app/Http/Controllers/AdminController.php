<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dao\AdminDao;

class AdminController extends Controller
{
	private $dao;
	
	public function __construct()
	{
		$this->dao = new AdminDao();
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