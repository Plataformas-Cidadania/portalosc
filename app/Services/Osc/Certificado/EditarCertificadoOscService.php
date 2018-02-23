<?php

namespace App\Services\Osc\Certificado;

use App\Util\FormatacaoUtil;
use App\Services\Log\LogService;
use App\Services\Service;
use App\Models\Osc\CertificadoOscModel;
use App\Dao\Osc\CertificadoOscDao;

class EditarCertificadoOscService extends Service
{
	public function executar()
	{
		$conteudoRequisicao = $this->requisicao->getConteudo();
		
		$flag = true;
		$listaCertificado = array();
		
		$idOsc = $conteudoRequisicao->id_osc;
		$naoPossui = $this->extrairNaoPossui($conteudoRequisicao);
		
		if($naoPossui){
			$certificadoNaoPossui = new \stdClass;
			$certificadoNaoPossui->certificado = 9;
			
			array_push($listaCertificado, $certificadoNaoPossui);
		}else{
			foreach($conteudoRequisicao->certificado as $certificado){
				$modelo = new CertificadoOscModel($certificado);
				$flag = $this->analisarModel($modelo);
				
				if($flag){
					$objetoAjustado = $this->aplicarRestricoes($modelo->getModel());
					
					if($objetoAjustado->certificado == 9){
						$listaCertificado = array();
						array_push($listaCertificado, $objetoAjustado);
						break;
					}else{
						array_push($listaCertificado, $objetoAjustado);
					}
				}else{
					break;
				}
			}
		}
		
		if($flag){
			$this->executarDao($idOsc, $listaCertificado);
		}
	}
	
	private function extrairNaoPossui($requisicao){
		$naoPossui = false;
		
		if(isset($requisicao->bo_nao_possui_certificacoes)){
			$naoPossui = (new FormatacaoUtil())->formatarBoolean($requisicao->bo_nao_possui_certificacoes);
		}
		
		return $naoPossui;
	}
	
	private function aplicarRestricoes($objeto){
		if($objeto->certificado == 7){
			if(isset($objeto->municipio)){
				$objeto->municipio = null;
			}
		}else if($objeto->certificado == 8){
			if(isset($objeto->estado)){
				$objeto->estado = null;
			}
		}else if($objeto->certificado == 9){
			if(isset($objeto->dataInicio)){
				$objeto->dataInicio = null;
			}
			if(isset($objeto->dataFim)){
				$objeto->dataFim = null;
			}
			if(isset($objeto->municipio)){
				$objeto->municipio = null;
			}
			if(isset($objeto->estado)){
				$objeto->estado = null;
			}
		}else{
			if(isset($objeto->municipio)){
				$objeto->municipio = null;
			}
			if(isset($objeto->estado)){
				$objeto->estado = null;
			}
		}
		
		return $objeto;
	}
	
	private function executarDao($idOsc, $listaCertificado){
		$resultadoDao = (new CertificadoOscDao)->editarCertificado($idOsc, $listaCertificado);
		$this->analisarDao($resultadoDao);
	}
}
