<?php

namespace App\Services\Osc\Certificado;

use App\Util\FormatacaoUtil;
use App\Services\Log\LogService;
use App\Services\BaseService;
use App\Models\Osc\CertificadoOscModel;
use App\Dao\Osc\CertificadoOscDao;

class ObterCertificadoOscService extends BaseService
{
	public function executar()
	{
		$this->resposta->prepararResposta(null, 204);
	}
}
