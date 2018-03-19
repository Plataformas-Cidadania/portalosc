<?php

namespace App\Services\Geografico;

use App\Services\Service;
use App\Models\Model;
use App\Dao\GeograficoDao;

class ObterOscsRegiaoService extends Service
{
	public function executar()
	{
	    $estrutura = array(
	        'tipo_regiao' => [
				'apelidos' => ['tipo_regiao', 'tipoRegiao', 'tipo'], 
				'obrigatorio' => true, 
				'tipo' => 'integer'
			],
	        'id_regiao' => [
				'apelidos' => ['id_regiao', 'idRegiao', 'id'], 
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
			print_r('ola mundo');
	        $requisicao = $modelo->obterRequisicao();
	        $geolocalizacaoOsc = (new GeograficoDao())->obterGeolocalizacaoOscsRegiao($requisicao->tipo_regiao, $requisicao->id_regiao);
			
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