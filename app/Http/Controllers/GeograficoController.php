<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Geografico\ObterOsc\Service as ObterOsc;
use App\Services\Geografico\ObterTodasOscs\Service as ObterTodasOscs;
use App\Services\Geografico\ObterOscsRegiao\Service as ObterOscsRegiao;
use App\Services\Geografico\ObterOscsArea\Service as ObterOscsArea;
use App\Services\Geografico\ObterCluster\Service as ObterCluster;
use App\Services\Geografico\ObterNomeLocalidade\Service as ObterNomeLocalidade;

class GeograficoController extends Controller{
    public function obterOsc(Request $request, $id_osc, ObterOsc $service){
        $extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterTodasOscs(Request $request, ObterTodasOscs $service){
        $this->executarService($service, $request);
        return $this->getResponse();
    }
    
    public function obterOscsRegiao(Request $request, $tipo_regiao, $id_regiao, ObterOscsRegiao $service){
        $extensaoConteudo = ['tipo_regiao' => $tipo_regiao, 'id_regiao' => $id_regiao];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterOscsArea(Request $request, $norte, $sul, $leste, $oeste, ObterOscsArea $service){
        $extensaoConteudo = ['norte' => $norte, 'sul' => $sul, 'leste' => $leste, 'oeste' => $oeste];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterCluster(Request $request, $tipo_regiao, $id_regiao = null, ObterCluster $service){
        $extensaoConteudo = ['tipo_regiao' => $tipo_regiao, 'id_regiao' => $id_regiao];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterNomeLocalidade(Request $request, $tipo_regiao, $latitude, $longitude, ObterNomeLocalidade $service){
        $extensaoConteudo = ['tipo_regiao' => $tipo_regiao, 'latitude' => $latitude, 'longitude' => $longitude];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
}