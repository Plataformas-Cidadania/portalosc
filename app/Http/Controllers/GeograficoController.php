<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Geografico\ObterOscService;
use App\Services\Geografico\ObterTodasOscsService;
use App\Services\Geografico\ObterOscsRegiaoService;
use App\Services\Geografico\ObterOscsAreaService;
use App\Services\Geografico\ObterClusterService;
use App\Services\Geografico\ObterNomeLocalidadeService;

class GeograficoController extends Controller
{
    
    public function obterOsc(Request $request, $id_osc, ObterOscService $service)
    {
        $extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterTodasOscs(Request $request, ObterTodasOscsService $service)
    {
        $this->executarService($service, $request);
        return $this->getResponse();
    }
    
    public function obterOscsRegiao(Request $request, $tipo_regiao, $id_regiao, ObterOscsRegiaoService $service)
    {
        $extensaoConteudo = ['tipo_regiao' => $tipo_regiao, 'id_regiao' => $id_regiao];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterOscsArea(Request $request, $norte, $sul, $leste, $oeste, ObterOscsAreaService $service)
    {
        $extensaoConteudo = ['norte' => $norte, 'sul' => $sul, 'leste' => $leste, 'oeste' => $oeste];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterCluster(Request $request, $tipo_regiao, $id_regiao = null, ObterClusterService $service)
    {
        $extensaoConteudo = ['tipo_regiao' => $tipo_regiao, 'id_regiao' => $id_regiao];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterNomeLocalidade(Request $request, $tipo_regiao, $latitude, $longitude, ObterNomeLocalidadeService $service)
    {
        $extensaoConteudo = ['tipo_regiao' => $tipo_regiao, 'latitude' => $latitude, 'longitude' => $longitude];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
}
