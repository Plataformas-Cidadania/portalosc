<?php

namespace App\Services\Geografico;

use App\Services\Service;
use App\Dao\GeograficoDao;

class ObterTodasOscsService extends Service
{
	public function executar()
	{
		$geolocalizacaoOscs = (new GeograficoDao())->obterGeolocalizacaoOscs();
		
		if($geolocalizacaoOscs){
			$this->resposta->prepararResposta($geolocalizacaoOscs, 200);
		}else{
			$this->resposta->prepararResposta(null, 204);
		}
	}
}