<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Analises\ObterGraficoService;

class AnalisesController extends Controller
{
	public function obterGrafico(Request $request, ObterGraficoService $service)
    {
    	$this->executarService($service, $request);
    	return $this->getResponse();
    }
}