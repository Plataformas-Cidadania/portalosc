<?php

namespace App\Services\Geografico;

use App\Services\Service;
use App\Models\Model;
use App\Dao\GeograficoDao;

class ObterOscsAreaService extends Service
{
	public function executar()
	{
	    $estrutura = array(
	        'norte' => [
				'apelidos' => ['norte'], 
				'obrigatorio' => true, 
				'tipo' => 'double'
			],
	        'sul' => [
				'apelidos' => ['sul'], 
				'obrigatorio' => true, 
				'tipo' => 'double'
			],
	        'leste' => [
				'apelidos' => ['leste'], 
				'obrigatorio' => true, 
				'tipo' => 'double'
			],
	        'oeste' => [
				'apelidos' => ['oeste'], 
				'obrigatorio' => true, 
				'tipo' => 'double'
			]
		);
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
	    if($modelo->obterCodigoResposta() === 200){
	        $requisicao = $modelo->obterRequisicao();
	        $geolocalizacaoOsc = (new GeograficoDao())->obterGeolocalizacaoOscsArea($requisicao->norte, $requisicao->sul, $requisicao->leste, $requisicao->oeste);
			
			if($geolocalizacaoOsc){
				$this->resposta->prepararResposta($geolocalizacaoOsc, 200);
			}else{
				$this->resposta->prepararResposta(null, 204);
			}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}