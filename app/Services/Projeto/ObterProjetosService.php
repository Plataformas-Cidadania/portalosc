<?php

namespace App\Services\Projeto;

use App\Services\Service;
use App\Dao\Projeto\ProjetoDao;

class ObterProjetosService extends Service
{
	public function executar()
	{
        $requisicao = $this->requisicao->getConteudo();
		$dao = (new ProjetoDao)->obterProjetos($requisicao->id_osc);
		
		if($dao->resultado){
			$this->resposta->prepararResposta(json_decode($dao->resultado), 200);
		}else{
			$this->resposta->prepararResposta(null, 204);
		}
	}
}