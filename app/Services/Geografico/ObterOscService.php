<?php

namespace App\Services\Geografico;

use App\Services\Service;
use App\Models\Model;
use App\Dao\GeograficoDao;

class ObterOscService extends Service
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
	        $geolocalizacaoOsc = (new GeograficoDao())->obterGeolocalizacaoOsc($requisicao->id_osc);
			
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