<?php

namespace App\Services\Osc\EditarCertificados;

use App\Services\BaseService;
use App\Dao\Analises\BarraTransparenciaOscDao;
use App\Dao\Osc\CertificadoDao;
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

			$resultadoDao = (new CertificadoDao)->editarCertificado($idOsc, $requisicao->certificados);
			$this->analisarDao($resultadoDao);

			(new BarraTransparenciaOscDao)->atualizarBarraTransparenciaOsc($idOsc);
		}else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}