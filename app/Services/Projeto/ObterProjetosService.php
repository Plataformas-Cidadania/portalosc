<?php

namespace App\Services\Projeto;

use App\Services\Service;
use App\Models\Model;
use App\Dao\Projeto\ProjetoDao;

class ObterProjetosService extends Service
{
	public function executar()
	{
		$estrutura = array(
	        'id_osc' => [
				'apelidos' => ['id_osc', 'idOsc', 'id', 'osc'], 
				'obrigatorio' => true, 
				'tipo' => 'integer'
			]
		);
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
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