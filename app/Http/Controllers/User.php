<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\User\Login as LoginService;
use App\Http\Services\User\Logout as LogoutService;
use App\Http\Services\User\GetUserOsc as GetUserOscService;

class UserController2 extends Controller
{
	public function loginUser(Request $request, LoginService $service)
	{
		$object = $request->all();
		$response = $service->run($object);
		
		return $this->setResponse($response);
	}
	
	public function logoutUser(Request $request, LogoutService $service)
	{
		$response = $service->run($service);
		
		return $this->setResponse($response);
	}
	
	public function getUserOsc(Request $request, $id_user, GetUserOscService $service)
	{
		$object['id_user'] = $id_user;
		$response = $service->run($object);
		
		return $this->setResponse($response);;
	}
}
