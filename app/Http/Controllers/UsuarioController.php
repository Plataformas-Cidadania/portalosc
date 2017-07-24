<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Components\Usuario\Services\ObterUsuarioService;
use App\Components\Usuario\Services\EditarUsuarioOSCService;
use App\Components\Usuario\Services\EditarUsuarioEstatalService;

class UsuarioController extends Controller
{
    public function obterUsuario(Request $request, $id_usuario, ObterUsuarioService $service)
	{
	    $parametrosURL = ['id_usuario' => $id_usuario];
		$this->prepararRequisicao($request, $parametrosURL);
		$this->prepararService($service);
		$this->executar();
		
		//return $this->obterResponse();
	}
	
	public function editarUsuarioOSC(Request $request, $id_user, EditarUsuarioOSCService $service)
	{
		$object = $request->all();
		$object['id_usuario'] = $id_user;
		
		$response = $service->executar($object);
		
		return $this->setResponse($response);;
	}
	
	public function editarUsuarioEstatal(Request $request, $id_user, EditarUsuarioEstatalService $service)
	{
		$object = $request->all();
		$object['id_usuario'] = $id_user;
		$object['cd_tipo_usuario'] = $request->user()->tipo;
		$object['cd_localidade'] = $request->user()->localidade;
		
		$response = $service->executar($object);
		
		return $this->setResponse($response);
	}
}
