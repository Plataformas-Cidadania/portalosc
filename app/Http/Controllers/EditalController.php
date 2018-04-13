<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Edital\CriarEdital\Service as CriarEdital;
use App\Services\Edital\ObterEditais\Service as ObterEditais;

class EditalController extends Controller{
	public function criarEdital(Request $request, CriarEdital $service){
        	$this->executarService($service, $request);
        	return $this->getResponse();
	}

	public function obterEditais(Request $request, ObterEditais $service){
        	$this->executarService($service, $request);
        	return $this->getResponse();
	}
}