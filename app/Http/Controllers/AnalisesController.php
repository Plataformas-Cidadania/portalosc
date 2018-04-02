<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Analises\BarraTransparenciaOsc\Service as ObterBarraTransparencia;
use App\Services\Analises\ObterGraficoService;

class AnalisesController extends Controller
{
	public function obterGrafico(Request $request, ObterGraficoService $service)
    {
    	$this->executarService($service, $request);
    	return $this->getResponse();
    }
    
    public function obterBarraTransparencia(Request $request, $id_osc, ObterBarraTransparencia $service)
    {
    	$extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
}