<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\User\GetUserService;
use App\Services\User\UpdateUserOscService;
use App\Services\User\UpdateUserGovService;

class UserController extends Controller
{
	public function getUser(Request $request, $id_user, GetUserService $service)
	{
		$object['id_usuario'] = $id_user;
		$object['cd_tipo_usuario'] = $request->user()->tipo;
		$object['localidade'] = $request->user()->localidade;
		
		$response = $service->execute($object);
		
		return $this->setResponse($response);;
	}
	
	public function updateUserOsc(Request $request, $id_user, UpdateUserOscService $service)
	{
		$object = $request->all();
		$object['id_usuario'] = $id_user;
		
		$response = $service->execute($object);
		
		return $this->setResponse($response);;
	}
	
	public function updateUserGov(Request $request, $id_user, UpdateUserGovService $service)
	{
		$object = $request->all();
		$object['id_usuario'] = $id_user;
		$object['cd_tipo_usuario'] = $request->user()->tipo;
		$object['cd_localidade'] = $request->user()->localidade;
		
		$response = $service->execute($object);
		
		return $this->setResponse($response);
	}
}
