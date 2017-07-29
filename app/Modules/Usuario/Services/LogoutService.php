<?php

namespace App\Modules\Usuario\Services;

use App\Modules\Service;

class LogoutService extends Service
{
    public function executar($requisicao)
	{
		$this->resposta->prepararResposta(['msg' => 'Usuário saiu do sistema.'], 200);
		
		return $this->resposta;
	}
}
