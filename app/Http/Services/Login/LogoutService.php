<?php

namespace App\Http\Services\Login;

use App\Http\Services\Service;

class LogoutService extends Service
{
	public function execute($object)
	{
		$content = ['msg' => 'Usuário saiu do sistema.'];
		$this->response->setResponse($content, 200);
		
		return $this->response;
	}
}