<?php

namespace App\Services\Osc;

use App\Services\Log\LogService;
use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\OscDao;

class EditarRecursosOscService extends Service
{
    public function executar()
    {
        $contrato = [
            'id_osc' => ['apelidos' => NomenclaturaAtributoEnum::ID_OSC, 'obrigatorio' => true, 'tipo' => 'integer'],
            'fonte_recursos' => ['apelidos' => ['fonterecursos, fonteRecursos', 'fonte_recursos'], 'obrigatorio' => true, 'tipo' => 'arrayObject']
        ];
        
        $model = new Model($contrato, $this->requisicao->getConteudo());
        $flagModel = $this->analisarRequisicao($model);
        
        if($flagModel){
            $recursosExistente = (new OscDao())->obterRecursosOsc($model->getRequisicao()->id_osc);
            
            $arrayInsert = array();
            $arrayUpdate = array();
            $arrayDelete = $recursosExistente;
            
            $idusuario = $this->requisicao->getusuario()->id_usuario;
            
            foreach($model->getRequisicao()->fonte_recursos as $fonteRecursosRequisicao){
                $recursos = new \stdClass();
                
                $flagInsert = true;
                
                if($fonteRecursosRequisicao->bo_nao_possui != true){
                    foreach($fonteRecursosRequisicao->recursos as $recursosRequisicao){
                        $recursos->dt_ano_recursos_osc = $fonteRecursosRequisicao->dt_ano_recursos_osc;
                        $recursos->cd_fonte_recursos_osc = $recursosRequisicao['cd_fonte_recursos_osc'];
                        $recursos->nr_valor_recursos_osc = $recursosRequisicao['nr_valor_recursos_osc'];
                        $recursos->bo_nao_possui = false;
                        
                        foreach ($recursosExistente as $keyRecursosBd => $recursosBd) {
                            if($recursosBd->cd_fonte_recursos_osc == $recursosRequisicao['cd_fonte_recursos_osc'] && $recursosBd->dt_ano_recursos_osc == $fonteRecursosRequisicao->dt_ano_recursos_osc){
                                $flagInsert = false;
                                
                                unset($arrayDelete[$keyRecursosBd]);
                                
                                if($recursosBd->nr_valor_recursos_osc != $recursosRequisicao->nr_valor_recursos_osc){
                                    $recursos->id_recursos_osc = $recursosBd->id_recursos_osc;
                                    $recursos->id_osc = $model->getRequisicao()->id_osc;
                                    $recursos->ft_fonte_recursos_osc = 'Representante de OSC';
                                    $recursos->ft_ano_recursos_osc = 'Representante de OSC';
                                    $recursos->ft_valor_recursos_osc = 'Representante de OSC';
                                    $recursos->ft_nao_possui = 'Representante de OSC';
                                    array_push($arrayUpdate, $recursos);
                                }
                            }
                        }
                    }
                }
                
                if($flagInsert){
                    $recursos->id_osc = $model->getRequisicao()->id_osc;
                    $recursos->ft_fonte_recursos_osc = 'Representante de OSC';
                    $recursos->ft_ano_recursos_osc = 'Representante de OSC';
                    $recursos->ft_valor_recursos_osc = 'Representante de OSC';
                    $recursos->ft_nao_possui = 'Representante de OSC';
                    array_push($arrayInsert, $recursos);
                }
            }
            
            $recursosDelete = $this->excluirListaRecursosOsc($arrayDelete);
            $recursosUpdate = $this->atualizarListaRecursosOsc($arrayUpdate);
            $recursosInsert = $this->inserirListaRecursosOsc($arrayInsert);
            
            $mensagensErro = $this->analisarResultadosDao($recursosDelete, $recursosUpdate, $recursosInsert);
            
            (new LogService())->salvarLog('osc.tb_recursos_osc', $model->getRequisicao()->id_osc, $idusuario, $recursosExistente, $model->getRequisicao()->fonte_recursos);
            
            if($mensagensErro){
                $this->resposta->prepararResposta(['msg' => 'Recursos de OSC foram atualizados, mas não completamente. Ocorreu algum erro na atualização dos dados.'], 202);
            }else{
                $this->resposta->prepararResposta(['msg' => 'Recursos de OSC foram atualizados.'], 200);
            }
        }
    }
    
    private function analisarResultadosDao($recursosDelete, $recursosUpdate, $recursosInsert)
    {
        $mensagensErro = array();
        
        foreach($recursosDelete as $resultadoDao){
            if(!$resultadoDao->flag){
                array_push($mensagensErro, $resultadoDao);
            }
        }
        
        foreach($recursosUpdate as $resultadoDao){
            if(!$resultadoDao->flag){
                array_push($mensagensErro, $resultadoDao);
            }
        }
        
        foreach($recursosInsert as $resultadoDao){
            if(!$resultadoDao->flag){
                array_push($mensagensErro, $resultadoDao);
            }
        }
        
        return $mensagensErro;
    }
    
    private function excluirListaRecursosOsc($arrayDelete)
    {
        $arrayResultadoDao = array();
        
        foreach($arrayDelete as $recursosOsc){
            $resultadoDao = (new OscDao())->excluirRecursosOsc($recursosOsc->id_recursos_osc);
            array_push($arrayResultadoDao, $resultadoDao);
        }
        
        return $arrayResultadoDao;
    }
    
    private function atualizarListaRecursosOsc($arrayUpdate)
    {
        $arrayResultadoDao = array();
        
        foreach($arrayUpdate as $recursosOsc){
            $resultadoDao = (new OscDao())->atualizarRecursosOsc($recursosOsc);
            array_push($arrayResultadoDao, $resultadoDao);
        }
        
        return $arrayResultadoDao;
    }
    
    private function inserirListaRecursosOsc($arrayInsert)
    {
        $arrayResultadoDao = array();
        
        foreach($arrayInsert as $recursosOsc){
            $resultadoDao = (new OscDao())->inserirRecursosOsc($recursosOsc);
            array_push($arrayResultadoDao, $resultadoDao);
        }
        
        return $arrayResultadoDao;
    }
    
    private function analisarRequisicao($model)
    {
        $flagModel = $this->analisarModel($model);
        
        foreach($model->getRequisicao()->fonte_recursos as $key => $recurso){
            $recursoModel = $this->validarRecurso($recurso);
            $flagModel = $this->analisarModel($recursoModel);
            
            if($flagModel == false){
                break;
            }
            
            $model->getRequisicao()->fonte_recursos[$key] = $recursoModel->getRequisicao();
        }
        
        return $flagModel;
    }
    
    private function validarRecurso($recurso)
    {
        $contrato = [
            //'cd_fonte_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::CD_FONTE_RECURSOS_OSC, 'obrigatorio' => true, 'tipo' => 'integer'],
            //'nr_valor_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::VALOR_RECURSOS_OSC, 'obrigatorio' => false, 'tipo' => 'float'],
            'dt_ano_recursos_osc' => ['apelidos' => NomenclaturaAtributoEnum::ANO_RECURSOS_OSC, 'obrigatorio' => true, 'tipo' => 'date'],
            'recursos' => ['apelidos' => ['recursos'], 'obrigatorio' => true, 'tipo' => 'Array'],
            'bo_nao_possui' => ['apelidos' => NomenclaturaAtributoEnum::NAO_POSSUI, 'obrigatorio' => false, 'tipo' => 'bollean']
        ];
        
        return new Model($contrato, $recurso);
    }
}
