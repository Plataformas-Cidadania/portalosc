<?php

namespace App\Services\Osc\ObterCertificados;

use App\Services\BaseService;
use App\Dao\Osc\CertificadoDao;

class Service extends BaseService{
	public function executar(){
	    $conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);

	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
			$resultadoDao = (new CertificadoDao())->obterCertificados($requisicao);
	    	
	    	if($resultadoDao){
				$resultado = $this->ajustarObjeto(json_decode($resultadoDao->resultado));
				$this->resposta->prepararResposta($resultado, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a atualização desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}

	public function ajustarObjeto($objeto){
		$resultado = new \stdClass();

		$resultado->certificado = array();
		$resultado->bo_nao_possui_certificacoes = null;
		
		foreach($objeto as $certificado){
			if($certificado->cd_certificado == 9){
				$resultado->certificado = array();
				$resultado->bo_nao_possui_certificacoes = true;
				break;
			}else{
				$certificadoAjustado = $certificado;
				$resultado->bo_nao_possui_certificacoes = false;

				array_push($resultado->certificado, $certificadoAjustado);
			}
		}

		return $resultado;
	}
}