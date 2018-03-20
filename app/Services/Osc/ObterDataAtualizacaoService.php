<?php

namespace App\Services\Osc;

use App\Services\Service;
use App\Models\Model;
use App\Dao\OscDao;

class ObterDataAtualizacaoService extends Service
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
	    	$dataAtualizacaoOsc = (new OscDao())->obterDataAtualizacao($model->getRequisicao()->id_osc);
	    	
	    	if($dataAtualizacaoOsc){
	    	    $this->resposta->prepararResposta($dataAtualizacaoOsc, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a atualização desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}