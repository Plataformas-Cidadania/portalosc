<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\Login\LoginService;
use App\Http\Services\Login\LogoutService;

class LoginController extends Controller
{
	public function login(Request $request, LoginService $service)
	{
		$content = $request->all();
		
		$response = $service->execute($content);
		
		return $this->setResponse($response);
	}
	
	public function logout(Request $request, $id_user, LogoutService $service)
	{
		$user = (array) $request->user();
		$content['id_usuario'] = $id_user;
		
		$response = $service->execute($content, $user);
		
		return $this->setResponse($response);
	}
}
