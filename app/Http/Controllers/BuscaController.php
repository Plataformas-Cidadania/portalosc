<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Busca\BuscaComum\Service as BuscaComum;

class BuscaController extends Controller{
	public function obterBuscaComum(Request $request, $recurso, $tipoResultado, $parametro, $limite = 0, $deslocamento = 0, $tipoBusca = 0, BuscaComum $service){
    	$extensaoConteudo = ['recurso' => $recurso, 'tipoResultado' => $tipoResultado, 'parametro' => $parametro, 'limite' => $limite, 'deslocamento' => $deslocamento, 'tipoBusca' => $tipoBusca];
        $this->executarService($service, $request, $extensaoConteudo);
        
        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);
        
        return $response;
	}
}