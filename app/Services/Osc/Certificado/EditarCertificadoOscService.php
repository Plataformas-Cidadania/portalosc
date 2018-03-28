<?php

namespace App\Services\Osc\Certificado;

use App\Services\BaseService;
use App\Models\Osc\CertificadoOscModel;
use App\Dao\Osc\CertificadoOscDao;
use App\Util\FormatacaoUtil;

class EditarCertificadoOscService extends BaseService
{
	public function executar()
	{
		$conteudoRequisicao = $this->requisicao->getConteudo();
		
		$listaCertificados = array();
		
		$idOsc = $conteudoRequisicao->id_osc;
		$naoPossui = $this->extrairNaoPossui($conteudoRequisicao);
		
		if($naoPossui){
			$certificadoNaoPossui = new \stdClass;
			$certificadoNaoPossui->cd_certificado = 9;
			array_push($listaCertificados, $certificadoNaoPossui);
		}
		
		$conteudoRequisicao->certificado = isset($conteudoRequisicao->certificado) ? $conteudoRequisicao->certificado : null;
		if(is_array($conteudoRequisicao->certificado)){
			foreach($conteudoRequisicao->certificado as $certificado){
				$modelo = new CertificadoOscModel($certificado);
				
				if($modelo->obterCodigoResposta() === 200){
					$requisicao = $modelo->obterRequisicao();
					array_push($listaCertificados, $requisicao);
				}else{
					break;
				}
			}
		}
		
		$this->executarDao($idOsc, $listaCertificados);
	}
	
	private function extrairNaoPossui($requisicao){
		$naoPossui = false;
		
		if(isset($requisicao->bo_nao_possui_certificacoes)){
			$naoPossui = (new FormatacaoUtil())->formatarBoolean($requisicao->bo_nao_possui_certificacoes);
		}
		
		return $naoPossui;
	}
	
	private function executarDao($idOsc, $listaCertificados){
		$resultadoDao = (new CertificadoOscDao)->editarCertificado($idOsc, $listaCertificados);
		$this->analisarDao($resultadoDao);
	}
}