<?php

namespace App\Services\Projeto\ObterProjetos;

use App\Services\BaseService;
use App\Dao\Projeto\ProjetoDao;

class Service extends BaseService
{
	public function executar()
	{
		$requisicao = $this->requisicao->getConteudo();
		$modelo = new Model($requisicao);
	    
	    if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();
			$dao = (new ProjetoDao)->obterProjetos($requisicao->id_osc);
			
			if($dao->resultado){
				$this->resposta->prepararResposta(json_decode($dao->resultado), 200);
			}else{
				$this->resposta->prepararResposta(null, 204);
			}
		}else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}