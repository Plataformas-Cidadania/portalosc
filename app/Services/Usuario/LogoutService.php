<?php

namespace App\Services\Usuario;

use App\Services\Service;

class LogoutService extends Service
{
    public function executar($requisicao)
	{
		$this->resposta->prepararResposta(['msg' => 'Usuário saiu do sistema.'], 200);
		
		return $this->resposta;
	}
}
