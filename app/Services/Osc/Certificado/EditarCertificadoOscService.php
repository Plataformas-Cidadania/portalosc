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
				if($certificado['cd_certificado'] == 7){
					$certificado['cd_municipio'] = null;
				}else if($certificado['cd_certificado'] == 8){
					$certificado['cd_uf'] = null;
				}else{
					$certificado['cd_municipio'] = null;
					$certificado['cd_uf'] = null;
				}
				
				$modelo = new CertificadoOscModel($certificado);
				$flagModel = $this->analisarModel($modelo);
				
				if($flagModel){
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
