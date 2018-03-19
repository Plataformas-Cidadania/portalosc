<?php

namespace App\Services\Geografico;

use App\Services\Service;
use App\Models\Model;
use App\Dao\GeograficoDao;

class ObterClusterService extends Service
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
	        'id_regiao' => [
				'apelidos' => ['id_regiao', 'idRegiao', 'id'], 
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
	        $geolocalizacaoOsc = (new GeograficoDao())->obterCluster($requisicao->tipo_regiao, $requisicao->id_regiao);
    	    
	        $this->resposta->prepararResposta($geolocalizacaoOsc, 200);
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}