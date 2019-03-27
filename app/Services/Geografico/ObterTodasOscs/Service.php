<?php

namespace App\Services\Geografico\ObterTodasOscs;

use App\Services\BaseService;
use App\Dao\Geografico\GeolocalizacaoDao;

class Service extends BaseService{
	public function executar(){
		$geolocalizacaoOscs = (new GeolocalizacaoDao())->obterGeolocalizacaoOscs();
		
		if($geolocalizacaoOscs){
			$this->resposta->prepararResposta($geolocalizacaoOscs, 200);
		}else{
			$this->resposta->prepararResposta(null, 204);
		}
	}
}