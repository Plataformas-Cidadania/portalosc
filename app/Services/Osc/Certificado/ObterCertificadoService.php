<?php

namespace App\Services\Osc\Certificado;

use App\Util\FormatacaoUtil;
use App\Services\Log\LogService;
use App\Services\Service;
use App\Models\Osc\CertificadoOscModel;
use App\Dao\Osc\CertificadoOscDao;

class ObterCertificadoOscService extends Service
{
	public function executar()
	{
		$this->resposta->prepararResposta(null, 204);
	}
}
