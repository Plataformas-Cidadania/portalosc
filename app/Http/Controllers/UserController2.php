<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\User\LoginService;

class UserController2 extends Controller
{
	private function run($service, $object)
	{
		$response = $service->check($object);
		if($response->getFlag()){
			$response = $service->execute($object);
		}
		
		$this->configResponse($response->getContent(), $response->getCode());
	}
	
	private function getObject($request)
	{
		foreach(array_keys($request->all()) as $key){
			$object[$key] = $request->{$key};
		}
		return $object;
	}
	
	public function loginUser(Request $request, LoginService $service){
		$object = $this->getObject($request);
		$this->run($service, $object);
    	return $this->response();
    }
}
