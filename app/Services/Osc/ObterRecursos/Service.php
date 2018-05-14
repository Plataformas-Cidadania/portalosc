<?php

namespace App\Services\Osc\ObterRecursos;

use App\Services\BaseService;
use App\Dao\Osc\RecursosDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
		
	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
			$resultadoDao = (new RecursosDao())->obterRecursos($requisicao);
	    	
	    	if($resultadoDao){
	    	    $this->resposta->prepararResposta($resultadoDao, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a atualização desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}

	private function ajustarObjeto($param){
    	$result = array();
        
    	$query = 'SELECT * FROM syst.dc_origem_fonte_recursos_osc a INNER JOIN syst.dc_fonte_recursos_osc b ON a.cd_origem_fonte_recursos_osc = b.cd_origem_fonte_recursos_osc;';
    	$dict_fonte_recursos_osc = $this->executarQuery($query, false, null);
		
    	$array_recursos = array();
        for ($ano = 2017; $ano >= 2014; $ano--) {
            $recursos = $this->obterRecursosAno($ano, $dict_fonte_recursos_osc, $param);
            
            if($recursos){
                array_push($array_recursos, $recursos);
            }
        }
        
        if($array_recursos){
    	    $result = array_merge($result, ["recursos" => $array_recursos]);
        }
        
    	$query = 'SELECT * FROM portal.obter_osc_recursos_outro_osc(?::TEXT);';
    	$result_query = $this->executarQuery($query, false, [$param]);
    	if($result_query){
    		$result = array_merge($result, ["recursos_outro" => $result_query]);
    	}
        
        if(count($result) == 0){
            return null;
        }else{
            return $result;
        }
	}
}