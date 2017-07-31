<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Usuario\ObterUsuarioService;
use App\Services\Usuario\EditarRepresentanteOscService;
use App\Services\Usuario\EditarRepresentanteGovernoService;
use App\Services\Usuario\LoginService;
use App\Services\Usuario\LogoutService;

class UsuarioController extends Controller
{
    public function obterUsuario(Request $request, $id_usuario, ObterUsuarioService $service)
    {
        $parametrosURL = ['id_usuario' => $id_usuario];
        $this->executarService($service, $request, $parametrosURL);
        return $this->obterResponse();
	}
	
	public function editarRepresentanteOsc(Request $request, $id_usuario, EditarRepresentanteOscService $service)
	{
	    $parametrosURL = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $parametrosURL);
	    return $this->obterResponse();
	}
	
	public function editarRepresentanteGoverno(Request $request, $id_usuario, EditarRepresentanteGovernoService $service)
	{
	    $parametrosURL = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $parametrosURL);
	    return $this->obterResponse();
	}
	
	public function login(Request $request, LoginService $service)
	{
	    $this->executarService($service, $request);
	    return $this->obterResponse();
	}
	
	public function logout(Request $request, $id_usuario, LogoutService $service)
	{
	    $parametrosURL = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $parametrosURL);
	    return $this->obterResponse();
	}
}
