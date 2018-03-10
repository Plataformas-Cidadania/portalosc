<?php

namespace App\Services\Osc\FonteRecursos;

use App\Services\Service;
use App\Models\Osc\FonteRecursosOscModel;
use App\Dao\Osc\FonteRecursosOscDao;

class EditarFonteRecursosOscService extends Service
{
    public function executar()
    {
        $usuario = $this->requisicao->getUsuario();
        $requisicao = $this->requisicao->getConteudo();

        $modelo = new FonteRecursosOscModel($requisicao);

        if($modelo->obterCodigoResposta() === 200){
            $requisicao = $modelo->obterRequisicao();

            $requisicao->fonte_recursos = $this->ajustarObjeto($requisicao->fonte_recursos);
            $dao = (new FonteRecursosOscDao)->editarRecursos($usuario->id_usuario, $requisicao->id_osc, $requisicao->fonte_recursos);
		    $this->analisarDao($dao);
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }

    private function ajustarObjeto($fontesRecursos){
        $requisicaoAjustado = array();

        foreach($fontesRecursos as $fonteRecursos){
            $fonteRecursoAjustado = new \stdClass();

            $fonteRecursoAjustado->dt_ano_recursos_osc = $fonteRecursos->dt_ano_recursos_osc;

            if(isset($fonteRecursos->bo_nao_possui)){
                $fonteRecursoAjustado->bo_nao_possui = $fonteRecursos->bo_nao_possui;
            }

            if(isset($fonteRecursos->bo_nao_possui_recursos_proprios)){
                $fonteRecursoAjustado->bo_nao_possui_recursos_proprios = $fonteRecursos->bo_nao_possui_recursos_proprios;
            }

            if(isset($fonteRecursos->bo_nao_possui_recursos_publicos)){
                $fonteRecursoAjustado->bo_nao_possui_recursos_publicos = $fonteRecursos->bo_nao_possui_recursos_publicos;
            }

            if(isset($fonteRecursos->bo_nao_possui_recursos_privados)){
                $fonteRecursoAjustado->bo_nao_possui_recursos_privados = $fonteRecursos->bo_nao_possui_recursos_privados;
            }

            if(isset($fonteRecursos->bo_nao_possui_recursos_nao_financeiros)){
                $fonteRecursoAjustado->bo_nao_possui_recursos_nao_financeiros = $fonteRecursos->bo_nao_possui_recursos_nao_financeiros;
            }

            foreach($fonteRecursos->recursos as $recurso){
                if(isset($recurso->cd_fonte_recursos_osc)){
                    $fonteRecursoAjustado->cd_fonte_recursos_osc = $recurso->cd_fonte_recursos_osc;
                }

                if(isset($recurso->cd_origem_fonte_recursos_osc)){
                    $fonteRecursoAjustado->cd_origem_fonte_recursos_osc = $recurso->cd_origem_fonte_recursos_osc;
                }

                if(isset($recurso->nr_valor_recursos_osc)){
                    $fonteRecursoAjustado->nr_valor_recursos_osc = $recurso->nr_valor_recursos_osc;
                }

                array_push($requisicaoAjustado, $fonteRecursoAjustado);
            }
        }

        return $requisicaoAjustado;
    }
}