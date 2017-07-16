<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\User\GetUserOscService;
use App\Http\Services\User\SetUserOscService;

class UserController extends Controller
{
	public function getUserOsc(Request $request, $id_user, GetUserOscService $service)
	{
		$object['id_usuario'] = $id_user;
		$response = $service->run($object);
		
		return $this->setResponse($response);;
	}
	
	public function setUserOsc(Request $request, $id_user, SetUserOscService $service)
	{
		$object = $request->all();
		$object['id_usuario'] = $id_user;
		$response = $service->run($object);
		
		return $this->setResponse($response);;
	}
}
