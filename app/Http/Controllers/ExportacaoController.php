<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Exportacao\ExportarBusca\Service as ExportarBusca;

class ExportacaoController extends Controller{
	public function exportarBusca(Request $request, ExportarBusca $service){
        $listaOscAjustado = array();

        if($request->input('lista_osc')){
            $listaOsc = $request->input('lista_osc');

            if(gettype($listaOsc) == 'string'){
                $listaOscAjustado = explode(',', $listaOsc);
			}
        }

        $request['lista_osc'] = $listaOscAjustado;

	    $this->executarService($service, $request);

        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);

        return $response;
    }
}