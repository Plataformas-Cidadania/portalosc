<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Projeto\EditarProjetoService;

class ProjetoController extends Controller
{
    public function editarProjeto(Request $request, $id_osc, EditarProjetoService $service)
    {
        $id_osc = $this->ajustarParametroUrl($id_osc);
        
    	$extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        
        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);
        
        return $response;
    }
}