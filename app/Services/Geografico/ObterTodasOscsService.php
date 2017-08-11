<?php

namespace App\Services\Geografico;

use App\Services\Service;
use App\Services\Model;
use App\Dao\GeograficoDao;

class ObterTodasOscsService extends Service
{
	public function executar()
	{
	    $geolocalizacaoOscs = (new GeograficoDao())->obterGeolocalizacaoOscs();
	    
	    $this->resposta->prepararResposta($geolocalizacaoOscs, 200);
	}
}
