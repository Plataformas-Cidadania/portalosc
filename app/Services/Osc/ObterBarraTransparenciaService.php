<?php

namespace App\Services\Osc;

use App\Services\BaseService;
use App\Services\BaseModel;
use App\Dao\OscDao;

class ObterBarraTransparenciaService extends BaseService
{
	public function executar()
	{
	    $estrutura = array(
	        'id_osc' => [
				'apelidos' => ['id_osc', 'idOsc', 'id', 'osc'], 
				'obrigatorio' => true, 
				'tipo' => 'numeric'
			]
		);
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
	    	$barraTransparenciaOsc = (new OscDao())->obterBarraTransparenciaOsc($requisicao->id_osc);
	    	
	    	if($barraTransparenciaOsc){
	    		$this->resposta->prepararResposta($barraTransparenciaOsc, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a barra de transparência desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}