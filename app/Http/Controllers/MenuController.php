<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Menu\ObterMenuOscService;
use App\Services\Menu\ObterMenuGeograficoService;

class MenuController extends Controller
{
	public function obterMenuOsc(Request $request, $menu, $parametro = '', ObterMenuOscService $service)
	{
	    $extensaoConteudo = ['menu' => $menu, 'parametro' => $parametro];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
    }
    
    public function obterMenuGeografico(Request $request, $tipo_regiao, $parametro, $limit = 0, $offset = 0, ObterMenuGeograficoService $service)
    {
        $extensaoConteudo = ['tipo_regiao' => $tipo_regiao, 'parametro' => $parametro, 'limit' => $limit, 'offset' => $offset];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
}
