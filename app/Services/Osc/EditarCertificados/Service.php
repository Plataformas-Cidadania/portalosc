<?php

namespace App\Services\Osc\EditarCertificados;

use App\Services\BaseService;
use App\Dao\Osc\CertificadoOscDao;
use App\Util\FormatacaoUtil;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);

		if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();

			if($requisicao->bo_nao_possui_certificacoes){
				$certificadoNaoPossui = new \stdClass;
				$certificadoNaoPossui->cd_certificado = 9;
	
				$requisicao->certificados = [$certificadoNaoPossui];
			}

			$idOsc = $conteudoRequisicao->id_osc;
			$this->executarDao($idOsc, $requisicao->certificados);
		}else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
	
	private function executarDao($idOsc, $certificados){
		$resultadoDao = (new CertificadoOscDao)->editarCertificado($idOsc, $certificados);
		$this->analisarDao($resultadoDao);
	}
}