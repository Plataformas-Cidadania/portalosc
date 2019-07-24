<?php

namespace App\Http\Controllers;

use App\Dao\Analises\DadosGeograficosIDHDao;
use Illuminate\Http\Request;

use App\Services\Analises\ObterBarraTransparenciaOsc\Service as ObterBarraTransparenciaOsc;
use App\Services\Analises\ObterGrafico\Service as ObterGrafico;
use App\Services\Analises\ObterListaOscsAtualizadas\Service as ObterListaOscsAtualizadas;
use App\Services\Analises\ObterListaOscsAreaAtuacao\Service as ObterListaOscsAreaAtuacao;
use App\Services\Analises\ObterPerfilLocalidade\Service as ObterPerfilLocalidade;
use App\Services\Analises\ObterDadosGeograficosIDH\Service as ObterDadosGeograficosIDH;
use Illuminate\Support\Facades\DB;

class AnalisesController extends Controller{
    public function obterBarraTransparenciaOsc(Request $request, $id_osc, ObterBarraTransparenciaOsc $service){
    	$extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
	public function obterGrafico(Request $request, ObterGrafico $service){
    	$this->executarService($service, $request);
    	return $this->getResponse();
    }
    
    public function obterListaOscsAtualizadas(Request $request, $limit = 10, ObterListaOscsAtualizadas $service)
    {
    	$extensaoConteudo = ['limit' => $limit];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }    
    
    public function obterListaOscsAreaAtuacao(Request $request, $cd_area_atuacao, $limit = 5, ObterListaOscsAreaAtuacao $service){
        $extensaoConteudo = ['cd_area_atuacao' => $cd_area_atuacao, 'limit' => $limit];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterListaOscsAreaAtuacaoMunicipio(Request $request, $cd_area_atuacao, $cd_municipio, $limit = 5, ObterListaOscsAreaAtuacao $service){
        $extensaoConteudo = ['cd_area_atuacao' => $cd_area_atuacao, 'cd_municipio' => $cd_municipio, 'limit' => $limit];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterListaOscsAreaAtuacaoGeolocalizacao(Request $request, $cd_area_atuacao, $latitude, $longitude, $limit = 5, ObterListaOscsAreaAtuacao $service){
        $extensaoConteudo = ['cd_area_atuacao' => $cd_area_atuacao, 'latitude' => $latitude, 'longitude' => $longitude, 'limit' => $limit];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
	public function obterPerfilLocalidade(Request $request, $id, ObterPerfilLocalidade $service){
    	$extensaoConteudo = ['id' => $id];
        $this->executarService($service, $request, $extensaoConteudo);
        
        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);
        
        return $response;
    }

    public function obterDadosGeograficosIDH(Request $request, $id, ObterDadosGeograficosIDH $service){
        $extensaoConteudo = ['id' => $id];
        $this->executarService($service, $request, $extensaoConteudo);

        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);

        return $response;

        /*
        $dao = new DadosGeograficosIDHDao();

        $resultado =  $dao->obterDadosGeograficosIDHDao();

        return $resultado;
        */
    }
}