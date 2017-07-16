<?php

namespace App\Http\Services\Login;

use App\Http\Services\Service;

class Logout extends Service
{
	public function run($service, $object = [])
	{
		$content = ['msg' => 'Usuário saiu do sistema.'];
		$this->response->setResponse($content, 200);
		
		return $this->response;
	}
}