<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\User\GetUserOscService;
use App\Http\Services\User\UpdateUserOscService;
use App\Http\Services\User\GetUserGovService;
use App\Http\Services\User\UpdateUserGovService;

class UserController extends Controller
{
	public function getUserOsc(Request $request, $id_user, GetUserOscService $service)
	{
		$object['id_usuario'] = $id_user;
		$response = $service->run($object);
		
		return $this->setResponse($response);;
	}
	
	public function setUserOsc(Request $request, $id_user, UpdateUserOscService $service)
	{
		$object = $request->all();
		$object['id_usuario'] = $id_user;
		$response = $service->run($object);
		
		return $this->setResponse($response);;
	}
	
	public function getUserGov(Request $request, $id_user, GetUserGovService$service)
	{
		$object['id_usuario'] = $id_user;
		$response = $service->run($object);
		
		return $this->setResponse($response);;
	}
	
	public function setUserGov(Request $request, $id_user, UpdateUserGovService$service)
	{
		$object = $request->all();
		$object['id_usuario'] = $id_user;
		$object['cd_tipo_usuario'] = $request->user()->tipo;
		$object['cd_localidade'] = $request->user()->localidade;
		$response = $service->run($object);
		
		return $this->setResponse($response);;
	}
}
