<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Geografico\ObterOscService;
use App\Services\Geografico\ObterTodasOscsService;
use App\Services\Geografico\ObterOscsRegiaoService;

class GeograficoController extends Controller
{
    
    public function obterOsc(Request $request, $id_osc, ObterOscService $service)
    {
        $id_osc = trim(urldecode($id_osc));
        
        $extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterTodasOscs(Request $request, ObterTodasOscsService $service)
    {
        $this->executarService($service, $request);
        return $this->getResponse();
    }
    
    public function obterOsc(Request $request, $tipo_regiao, $id_regiao, ObterOscsRegiaoService $service)
    {
        $tipo_regiao = trim(urldecode($tipo_regiao));
        $id_regiao = trim(urldecode($id_regiao));
        
        $extensaoConteudo = ['tipo_regiao' => $id_osc, 'id_regiao' => $id_regiao];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
}
