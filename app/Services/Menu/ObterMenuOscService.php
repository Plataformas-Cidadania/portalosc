<?php

namespace App\Services\Menu;

use App\Services\BaseService;
use App\Services\BaseModel;
use App\Dao\MenuDao;

class ObterMenuOscService extends BaseService
{
	public function executar()
	{
	    $estrutura = array(
	        'menu' => [
                'apelidos' => ['menu'], 
                'obrigatorio' => true, 
                'tipo' => 'string'
            ],
            'parametro' => [
                'apelidos' => ['parametro'], 
                'obrigatorio' => false, 
                'tipo' => 'string'
            ]
		);
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
	    if($modelo->obterCodigoResposta() === 200){
	        $requisicao = $modelo->obterRequisicao();
	        $resultadoDao = (new MenuDao())->obterMenuOsc($requisicao->menu, $requisicao->parametro);
    	    
	        if($resultadoDao){
                $this->resposta->prepararResposta($resultadoDao, 200);
	        }else{
	            $mensagem = 'Este menu não existe ou não contém dados cadastrados no banco de dados.';
	            $this->resposta->prepararResposta(['msg' => $mensagem], 400);
	        }
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}