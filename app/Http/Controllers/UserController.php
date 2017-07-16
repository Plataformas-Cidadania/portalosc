<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\User\GetUserOscService;

class UserController extends Controller
{
	public function getUserOsc(Request $request, $id_user, GetUserOscService $service)
	{
		$object['id_user'] = $id_user;
		$response = $service->run($object);
		
		return $this->setResponse($response);;
	}
}
