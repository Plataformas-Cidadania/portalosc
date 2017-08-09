<?php

namespace App\Http\Controllers;

use App\Services\Service;

class CriarEditalService extends Service
{
	public function executar(Request $request)
	{
		$orgao = $request->input('tx_orgao');
		$programa = $request->input('tx_programa');
		$areainteresse = $request->input('tx_area_interesse_edital');
		$dtvencimento = $request->input('dt_vencimento');
		$link = $request->input('tx_link_edital');
		$numerochamada = $request->input('tx_numero_chamada');

		$params = [$orgao, $programa, $areainteresse, $dtvencimento, $link, $numerochamada];
		$resultDao = $this->dao->createEdital($params);
	}
}
