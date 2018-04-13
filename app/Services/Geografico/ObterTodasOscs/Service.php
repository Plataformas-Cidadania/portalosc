<?php

namespace App\Services\Geografico\ObterTodasOscs;

use App\Services\BaseService;
use App\Dao\GeograficoDao;

class ObterTodasOscsService extends BaseService{
	public function executar(){
		$geolocalizacaoOscs = (new GeograficoDao())->obterGeolocalizacaoOscs();
		
		if($geolocalizacaoOscs){
			$this->resposta->prepararResposta($geolocalizacaoOscs, 200);
		}else{
			$this->resposta->prepararResposta(null, 204);
		}
	}
}