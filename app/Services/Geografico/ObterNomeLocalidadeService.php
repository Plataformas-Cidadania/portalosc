<?php

namespace App\Services\Geografico;

use App\Services\Service;
use App\Models\Model;
use App\Dao\GeograficoDao;

class ObterNomeLocalidadeService extends Service
{
	public function executar()
	{
	    $estrutura = array(
	        'tipo_regiao' => [
				'apelidos' => ['tipo_regiao', 'tipoRegiao', 'tipo'], 
				'obrigatorio' => true, 
				'tipo' => 'string', 
				'default' => ''
			],
	        'latitude' => [
				'apelidos' => ['latitude', 'lat'], 
				'obrigatorio' => false, 
				'tipo' => 'integer', 
				'default' => 0
			],
	        'longitude' => [
				'apelidos' => ['longitude', 'long', 'lon', 'lng'], 
				'obrigatorio' => false, 
				'tipo' => 'integer', 
				'default' => 0
			]
		);
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
	    	if(in_array($requisicao->tipo_regiao, ['regiao', 'estado', 'municipio'])){
		        $nomeLocalidade = (new GeograficoDao())->obterNomeLocalidade($requisicao->tipo_regiao, $requisicao->latitude, $requisicao->longitude);
	    	    
		        $this->resposta->prepararResposta($nomeLocalidade, 200);
	    	}else{
	    		$this->resposta->prepararResposta(['msg' => 'Não existe este tipo de região.'], 403);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}