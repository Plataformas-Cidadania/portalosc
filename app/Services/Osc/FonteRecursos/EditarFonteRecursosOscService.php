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
        $requisicaoAjustada = array();

        foreach($fontesRecursos as $fonteRecursos){
            $ano = $fonteRecursos->dt_ano_recursos_osc;

            $naoPossui = false;
            $naoPossuiRecursosPublicos = false;
            $naoPossuiRecursosPrivados = false;
            $naoPossuiRecursosNaoFinanceiros = false;
            $naoPossuiRecursosProprios = false;

            if(isset($fonteRecursos->bo_nao_possui)){
                $naoPossui = $fonteRecursos->bo_nao_possui;
            }

            if(isset($fonteRecursos->bo_nao_possui_recursos_publicos)){
                $naoPossuiRecursosPublicos = $fonteRecursos->bo_nao_possui_recursos_publicos;
            }

            if(isset($fonteRecursos->bo_nao_possui_recursos_privados)){
                $naoPossuiRecursosPrivados = $fonteRecursos->bo_nao_possui_recursos_privados;
            }

            if(isset($fonteRecursos->bo_nao_possui_recursos_nao_financeiros)){
                $naoPossuiRecursosNaoFinanceiros = $fonteRecursos->bo_nao_possui_recursos_nao_financeiros;
            }

            if(isset($fonteRecursos->bo_nao_possui_recursos_proprios)){
                $naoPossuiRecursosProprios = $fonteRecursos->bo_nao_possui_recursos_proprios;
            }

            if($naoPossui){
                $fonteRecursoAjustado = new \stdClass();
                $fonteRecursoAjustado->dt_ano_recursos_osc = $ano;
                $fonteRecursoAjustado->bo_nao_possui = true;
                array_push($requisicaoAjustada, $fonteRecursoAjustado);
            }else{
                if($naoPossuiRecursosPublicos || $naoPossuiRecursosPrivados || $naoPossuiRecursosNaoFinanceiros || $naoPossuiRecursosProprios){
                    if($naoPossuiRecursosPublicos){
                        $fonteRecursoAjustado = new \stdClass();
                        $fonteRecursoAjustado->dt_ano_recursos_osc = $ano;
                        $fonteRecursoAjustado->cd_origem_fonte_recursos_osc = 1;
                        $fonteRecursoAjustado->bo_nao_possui = true;
                        array_push($requisicaoAjustada, $fonteRecursoAjustado);
                    }
                    if($naoPossuiRecursosPrivados){
                        $fonteRecursoAjustado = new \stdClass();
                        $fonteRecursoAjustado->dt_ano_recursos_osc = $ano;
                        $fonteRecursoAjustado->cd_origem_fonte_recursos_osc = 2;
                        $fonteRecursoAjustado->bo_nao_possui = true;
                        array_push($requisicaoAjustada, $fonteRecursoAjustado);
                    }
                    if($naoPossuiRecursosNaoFinanceiros){
                        $fonteRecursoAjustado = new \stdClass();
                        $fonteRecursoAjustado->dt_ano_recursos_osc = $ano;
                        $fonteRecursoAjustado->cd_origem_fonte_recursos_osc = 3;
                        $fonteRecursoAjustado->bo_nao_possui = true;
                        array_push($requisicaoAjustada, $fonteRecursoAjustado);
                    }
                    if($naoPossuiRecursosProprios){
                        $fonteRecursoAjustado = new \stdClass();
                        $fonteRecursoAjustado->dt_ano_recursos_osc = $ano;
                        $fonteRecursoAjustado->cd_origem_fonte_recursos_osc = 4;
                        $fonteRecursoAjustado->bo_nao_possui = true;
                        array_push($requisicaoAjustada, $fonteRecursoAjustado);
                    }
                }else{
                    foreach($fonteRecursos->recursos as $recurso){
                        $fonteRecursoAjustado = new \stdClass();
                        $fonteRecursoAjustado->dt_ano_recursos_osc = $ano;

                        if(isset($recurso->cd_origem_fonte_recursos_osc)){
                            $fonteRecursoAjustado->cd_origem_fonte_recursos_osc = $recurso->cd_origem_fonte_recursos_osc;
                        }

                        if(isset($recurso->cd_fonte_recursos_osc)){
                            $fonteRecursoAjustado->cd_fonte_recursos_osc = $recurso->cd_fonte_recursos_osc;
                        }

                        if(isset($recurso->nr_valor_recursos_osc)){
                            $fonteRecursoAjustado->nr_valor_recursos_osc = $recurso->nr_valor_recursos_osc;
                        }

                        $fonteRecursoAjustado->bo_nao_possui = false;

                        array_push($requisicaoAjustada, $fonteRecursoAjustado);
                    }
                }
            }
        }
        
        return $requisicaoAjustada;
    }
}