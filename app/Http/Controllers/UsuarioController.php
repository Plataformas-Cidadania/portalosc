<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Usuario\ObterUsuarioService;
use App\Services\Usuario\EditarUsuarioOSCService;
use App\Services\Usuario\EditarUsuarioEstatalService;

class UsuarioController extends Controller
{
	public function obterUsuario(Request $request, $id_user)
	{
		$service = new ObterUsuarioService();
		
		$atruibutosURL['id_usuario'] = $id_user;
		
		$resposta = $this->executar($service, $request, $atruibutosURL);
		return $this->setResponse($resposta);
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
