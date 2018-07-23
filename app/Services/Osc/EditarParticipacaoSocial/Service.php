<?php

namespace App\Services\Osc\EditarParticipacaoSocial;

use App\Services\BaseService;
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
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }

    private function ajustarObjeto($requisicao){
        $requisicaoAjustada = new \stdClass();
        $objetoInterno = new \stdClass();

        $requisicaoAjustada->conferencia = null;
        $requisicaoAjustada->conselho = null;
        $requisicaoAjustada->outra = null;

        if($requisicao->bo_nao_possui_conferencia === true){
            $objetoInterno->cd_conferencia = 133;
            $requisicaoAjustada->outra = $objetoInterno;
        }else{
            if($requisicao->conferencia !== null){
                $requisicaoAjustada->conferencia = $requisicao->conferencia;
            }
        }

        if($requisicao->bo_nao_possui_conselho === true){
            $objetoInterno->cd_conselho = 108;
            $requisicaoAjustada->outra = $objetoInterno;
        }else{
            if($requisicao->conselho !== null){
                $requisicaoAjustada->conselho = $requisicao->conselho;
            }
        }

        if($requisicao->bo_nao_possui_outra === true){
            $objetoInterno->bo_nao_possui = true;
            $requisicaoAjustada->outra = $objetoInterno;
        }else{
            if($requisicao->outra !== null){
                $requisicaoAjustada->outra = $requisicao->outra;
            }
        }
        
        return $requisicaoAjustada;
    }
}