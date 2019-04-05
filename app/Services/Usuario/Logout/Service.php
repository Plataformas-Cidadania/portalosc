<?php

namespace App\Services\Usuario\Logout;

use App\Services\BaseService;

class Service extends BaseService
{
    public function executar()
	{
		$this->resposta->prepararResposta(['msg' => 'Usuário saiu do sistema.'], 200);
	}
}