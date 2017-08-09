<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Edital\ObterEditaisService;
use App\Services\Edital\CriarEditalService;

class EditalController extends Controller
{
	public function obterEditais(Request $request, ObterEditaisService $service)
	{
        $this->executarService($service, $request);
        return $this->getResponse();
	}

	public function criarEdital(Request $request, CriarEditalService $service)
	{
        $this->executarService($service, $request);
        return $this->getResponse();
	}
}
