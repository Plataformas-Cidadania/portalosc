<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Componente\ObterComponente\Service as ObterComponente;

class ComponenteController extends Controller{
	public function obterComponente(Request $request, $componente, $parametro = '', ObterComponente $service){
        $extensaoConteudo = ['componente' => $componente, 'parametro' => $parametro];
        $this->executarService($service, $request, $extensaoConteudo);
        
        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);

	    return $this->getResponse();
	}
}