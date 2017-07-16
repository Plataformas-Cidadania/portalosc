<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\User\LoginService;
use App\Http\Services\User\LogoutService;

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
	
	public function getUser(Request $request, LogoutService $service)
	{
		$object = $request->all();
		$response = $service->run($object);
		
		return $this->setResponse($response);;
	}
}
