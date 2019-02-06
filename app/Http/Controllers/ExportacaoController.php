<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Exportacao\ExportarBusca\Service as ExportarBusca;

class ExportacaoController extends Controller{
	public function exportarBusca(Request $request, ExportarBusca $service){
	    $this->executarService($service, $request);
        
        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);
        
        return $response;
    }
}