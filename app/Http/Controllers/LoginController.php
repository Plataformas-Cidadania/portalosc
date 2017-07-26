<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Usuario\Services\LoginService;
use App\Modules\Usuario\Services\LogoutService;

class LoginController extends Controller
{
	public function login(Request $request, LoginService $service)
	{
	    $this->prepararService($service);
		$this->prepararRequisicao($request);
		$this->executar();
		return $this->obterResponse();
	}
	
	public function logout(Request $request, $id_user, LogoutService $service)
	{
		$user = (array) $request->user();
		$content['id_usuario'] = $id_user;
		
		$response = $service->execute($content, $user);
		
		return $this->setResponse($response);
	}
}
