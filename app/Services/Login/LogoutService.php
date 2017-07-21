<?php

namespace App\Services\Login;

use App\Services\Service;

class LogoutService extends Service
{
	public function execute($contentRequest, $user = null)
	{
		$contentResponse = ['msg' => 'Usuário saiu do sistema.'];
		$this->response->setResponse($contentResponse, 200);
		
		return $this->response;
	}
}
