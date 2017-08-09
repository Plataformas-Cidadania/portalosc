<?php

namespace App\Services;

use App\Services\Service;
use App\Dao\EditalDao;

class ObterEditaisService extends Service
{
	public function executar()
	{
		$resultDao = $this->dao->getEditais();
		
		$this->configResponse($resultDao);
		return $this->response();
	}
}
