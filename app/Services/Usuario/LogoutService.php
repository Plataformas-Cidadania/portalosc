<?php

namespace App\Services\Usuario;

use App\Services\Service;

class LogoutService extends Service
{
    public function executar()
	{
		$this->resposta->prepararResposta(['msg' => 'Usuário saiu do sistema.'], 200);
	}
}
