<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Usuario\Services\ObterUsuarioService;
use App\Modules\Usuario\Services\EditarUsuarioOSCService;
use App\Modules\Usuario\Services\EditarUsuarioEstatalService;
use App\Modules\Usuario\Services\LoginService;
use App\Modules\Usuario\Services\LogoutService;

class UsuarioController extends Controller
{
    public function obterUsuario(Request $request, $id_usuario, ObterUsuarioService $service)
    {
        $parametrosURL = ['id_usuario' => $id_usuario];
        $this->executarService($service, $request, $parametrosURL);
        return $this->obterResponse();
	}
	
	public function editarRepresentanteOSC(Request $request, $id_usuario, EditarUsuarioOSCService $service)
	{
	    $parametrosURL = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $parametrosURL);
	    return $this->obterResponse();
	}
	
	public function editarRepresentanteGoverno(Request $request, $id_usuario, EditarUsuarioEstatalService $service)
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
