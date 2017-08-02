<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Governo\CarregarArquivoService;

class GovernoController extends Controller
{
    public function carregarArquivo(Request $request, CarregarArquivoService $service)
    {
    	$arquivo = $request->file('arquivo');
    	$extensaoConteudo = ['arquivo' => $arquivo];
        $this->executarService($service, $request);
        return $this->getResponse();
    }
}
