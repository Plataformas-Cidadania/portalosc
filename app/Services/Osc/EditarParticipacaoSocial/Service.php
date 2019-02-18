<?php

namespace App\Services\Osc\EditarParticipacaoSocial;

use App\Services\BaseService;
use App\Dao\Analises\BarraTransparenciaOscDao;
use App\Dao\Osc\ParticipacaoSocialDao;

class Service extends BaseService{
    public function executar(){
        $conteudoRequisicao = $this->requisicao->getConteudo();

		$idOsc = $conteudoRequisicao->id_osc;

		$modelo = new Model($conteudoRequisicao);
        
		$listaObjetivo = array();
		if($modelo->obterCodigoResposta() === 200){
            $requisicao = $modelo->obterRequisicao();
            
            $requisicao = $this->ajustarObjeto($requisicao);
            
            $dao = (new ParticipacaoSocialDao)->editarParticipacaoSocial($idOsc, $requisicao);
            $this->analisarDao($dao);
            
            (new BarraTransparenciaOscDao)->atualizarBarraTransparenciaOsc($idOsc);
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }

    private function ajustarObjeto($requisicao){
        $requisicaoAjustada = new \stdClass();

        $requisicaoAjustada->conferencia = null;
        $requisicaoAjustada->conselho = null;
        $requisicaoAjustada->outra = null;

        if($requisicao->bo_nao_possui_conferencia === true){
            $conferencia = new \stdClass();
            $conferencia->cd_conferencia = 9;
            $requisicaoAjustada->conferencia = $conferencia;
        }else{
            if($requisicao->conferencia !== null){
                $requisicaoAjustada->conferencia = $requisicao->conferencia;
            }
        }

        if($requisicao->bo_nao_possui_conselho === true){
            $conselho = new \stdClass();
            $conselhoInterno = new \stdClass();
            $conselhoInterno->cd_conselho = 108;
            $conselho->conselho = $conselhoInterno;
            $requisicaoAjustada->conselho = $conselho;
        }else{
            if($requisicao->conselho !== null){
                $requisicaoAjustada->conselho = $requisicao->conselho;
            }
        }

        if($requisicao->bo_nao_possui_outra === true){
            $outra = new \stdClass();
            $outra->bo_nao_possui = true;
            $requisicaoAjustada->outra = $outra;
        }else{
            if($requisicao->outra !== null){
                $requisicaoAjustada->outra = $requisicao->outra;
            }
        }
        
        return $requisicaoAjustada;
    }
}