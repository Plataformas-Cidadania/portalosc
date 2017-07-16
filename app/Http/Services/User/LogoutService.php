<?php

namespace App\Http\Services\User;

use App\Http\Services\Service;

class LogoutService extends Service
{
	public function run($service, $object = [])
	{
		$content = ['msg' => 'Usuário saiu do sistema.'];
		$this->response->setResponse($content, 200);
		
		return $this->response;
	}
}