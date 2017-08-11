<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Menu\ObterMenuOscService;
use App\Services\Menu\ObterMenuGeograficoService;

class MenuController extends Controller
{
	public function getMenuOsc(Request $request, $menu, $parametro = null, ObterMenuOscService $service)
	{
	    $menu = trim(urldecode($menu));
	    $parametro = trim(urldecode($parametro));
	    
	    $extensaoConteudo = ['menu' => $menu, 'parametro' => $parametro];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
    }
    
    public function getMenuGeo(Request $request, $tipo_regiao, $parametro, $limit = 0, $offset = 0, ObterMenuGeograficoService $service)
    {
        $tipo_regiao = trim(urldecode($tipo_regiao));
        $parametro = trim(urldecode($parametro));
        $limit = trim(urldecode($limit));
        $offset = trim(urldecode($offset));
        
        $extensaoConteudo = ['tipo_regiao' => $tipo_regiao, 'parametro' => $parametro, 'limit' => $limit, 'offset' => $offset];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
}
