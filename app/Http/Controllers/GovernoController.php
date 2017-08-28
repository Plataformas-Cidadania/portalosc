<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Governo\CarregarArquivoParceriasService;

class GovernoController extends Controller
{
    public function carregarArquivo(Request $request, CarregarArquivoParceriasService $service)
    {
        $this->executarService($service, $request);
        return $this->getResponse();
    }
}
