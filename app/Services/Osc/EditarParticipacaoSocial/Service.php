<?php

namespace App\Services\Osc\EditarParticipacaoSocial;

use App\Services\BaseService;
use App\Dao\Osc\RecursosDao;

class Service extends BaseService{
    public function executar(){
        $conteudoRequisicao = $this->requisicao->getConteudo();

		$idOsc = $conteudoRequisicao->id_osc;

		$modelo = new Model($conteudoRequisicao);
        
		$listaObjetivo = array();
		if($modelo->obterCodigoResposta() === 200){
            $requisicao = $modelo->obterRequisicao();
            
            $requisicao = $this->ajustarObjeto($requisicao);
            
            $dao = (new RecursosDao)->editarRecursos($idOsc, $requisicao);
            
		    $this->analisarDao($dao);
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }

    private function ajustarObjeto($requisicao){
        $requisicaoAjustada = new \stdClass();

        $requisicaoAjustada->bo_nao_possui = $requisicao->bo_nao_possui;
        $requisicaoAjustada->dt_ano_recursos_osc = $requisicao->dt_ano_recursos_osc;

        if($requisicao->bo_nao_possui === true){
            $requisicaoAjustada->bo_nao_possui = $requisicao->bo_nao_possui;
            $requisicaoAjustada->recursos = array();
        }else{
            $recursos = $requisicao->recursos;

            if($requisicao->bo_nao_possui_recursos_publicos === true){
                $recurso = new \stdClass();
                $recurso->cd_origem_fonte_recursos_osc = 1;
                $recurso->bo_nao_possui = true;
                array_push($recursos, $recurso);    
            }
            if($requisicao->bo_nao_possui_recursos_privados === true){
                $recurso = new \stdClass();
                $recurso->cd_origem_fonte_recursos_osc = 2;
                $recurso->bo_nao_possui = true;
                array_push($recursos, $recurso);    
            }
            if($requisicao->bo_nao_possui_recursos_nao_financeiros === true){
                $recurso = new \stdClass();
                $recurso->cd_origem_fonte_recursos_osc = 3;
                $recurso->bo_nao_possui = true;
                array_push($recursos, $recurso);    
            }
            if($requisicao->bo_nao_possui_recursos_proprios === true){
                $recurso = new \stdClass();
                $recurso->cd_origem_fonte_recursos_osc = 4;
                $recurso->bo_nao_possui = true;
                array_push($recursos, $recurso);    
            }

            $requisicaoAjustada->recursos = $recursos;
        }
        
        return $requisicaoAjustada;
    }
}