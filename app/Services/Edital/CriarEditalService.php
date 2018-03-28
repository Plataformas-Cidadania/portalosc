<?php

namespace App\Services\Edital;

use App\Services\BaseService;
use App\Services\BaseModel;
use App\Dao\EditalDao;

class CriarEditalService extends BaseService
{
	public function executar()
	{
	    $estrutura = array(
	        'tx_orgao' => [
				'apelidos' => ['tx_orgao', 'orgao'], 
				'obrigatorio' => true, 
				'tipo' => 'string'
			],
	        'tx_programa' => [
				'apelidos' => ['tx_programa', 'programa'], 
				'obrigatorio' => true, 
				'tipo' => 'string'
			],
	        'tx_area_interesse' => [
				'apelidos' => ['tx_area_interesse', 'area_interesse', 'areaInteresse', 'area'], 
				'obrigatorio' => true, 
				'tipo' => 'string'
			],
	        'dt_data_vencimento' => [
				'apelidos' => ['dt_data_vencimento', 'data_vencimento', 'dataVencimento', 'vencimento'], 
				'obrigatorio' => true, 
				'tipo' => 'date'
			],
	        'tx_link' => [
				'apelidos' => ['tx_link', 'link'], 
				'obrigatorio' => true, 
				'tipo' => 'string'
			],
	        'tx_numero_chamada' => [
				'apelidos' => ['tx_numero_chamada', 'numero_chamada', 'numeroChamada'], 
				'obrigatorio' => true, 
				'tipo' => 'string'
			]
		);
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new BaseModel();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
	    if($modelo->obterCodigoResposta() === 200){
	        $requisicao = $modelo->obterRequisicao();
	        $resultadoDao = (new EditalDao())->criarEdital($requisicao);
	        
	        if($resultadoDao->flag){
	            $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 200);
	        }else{
	            $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
	        }
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}