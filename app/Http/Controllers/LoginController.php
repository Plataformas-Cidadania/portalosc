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
		$object = $request->all();
		$response = $service->execute($object);
		
		return $this->setResponse($response);
	}
	
	public function logout(Request $request, $id_user, LogoutService $service)
	{
		$object['id_user'] = $id_user;
		$response = $service->execute($object);
		
		return $this->setResponse($response);
	}
}
