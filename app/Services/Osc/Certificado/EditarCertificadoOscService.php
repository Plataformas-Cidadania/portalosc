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
		
		$listaCertificado = array();
		$flagModel = true;
		
		$id_osc = $conteudoRequisicao->id_osc;
		$naoPossui = (new FormatacaoUtil())->formatarBoolean($conteudoRequisicao->bo_nao_possui_certificacoes);
		
		if($naoPossui === false){
			foreach($conteudoRequisicao->certificado as $certificado){
				$modelo = new CertificadoOscModel($certificado);
				$flagModel = $this->analisarModel($modelo);
				
				if($flagModel){
					$modeloAjustado = $modelo->getModel();
					
					if($modeloAjustado->certificado == 7){
						if(isset($modeloAjustado->municipio)){
							$modeloAjustado->municipio = null;
						}
					}else if($modeloAjustado->certificado == 8){
						if(isset($modeloAjustado->estado)){
							$modeloAjustado->estado = null;
						}
					}else{
						if(isset($modeloAjustado->municipio)){
							$modeloAjustado->municipio = null;
						}
						if(isset($modeloAjustado->estado)){
							$modeloAjustado->estado = null;
						}
					}
					
					array_push($listaCertificado, $modelo->getModel());
				}else{
					break;
				}
			}
		}else{
			$certificadoNaoPossui = new \stdClass;
			$certificadoNaoPossui->certificado = 9;
			array_push($listaCertificado, $certificadoNaoPossui);
		}
		
		if($flagModel){
			$resultadoDao = (new CertificadoOscDao)->editarCertificado($id_osc, $listaCertificado);
			
			$codigo = 200;
			if($resultadoDao->flag){
				$codigo = 200;
			}
			$mensagem = ['msg' => $resultadoDao->mensagem];
			
			$this->resposta->prepararResposta($mensagem, $codigo);
		}
	}
}
