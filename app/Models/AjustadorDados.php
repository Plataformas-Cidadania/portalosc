<?php

namespace App\Models;

use App\Models\Osc\RecursosOscModel;
use App\Models\Osc\FonteRecursosAnualOscModel;
use App\Models\Projeto\ProjetoModel;
use App\Util\FormatacaoUtil;

class AjustadorDados
{
    public function ajustarDado($dado, $tipo, $modelo = null)
    {
        $resultado = $dado;
        
    	$this->formatacaoUtil = new FormatacaoUtil();
    	
        if($resultado !== null){
            switch($tipo){
                case 'integer':
                    $resultado = intval($dado);
                    break;

                case 'double':
                    $resultado = str_replace(',', '.', $resultado);
                    $resultado = floatval($resultado);
                    break;
                    
                case 'date':
                    if(strlen($resultado) == 4){
                        $resultado = '01-01-' . $resultado;
                    }else{
                        $separator = '(\/|-|\.)';
                        $padrao = '/^[0-9]{4}' . $separator . '(0[1-9]|1[0-2])' . $separator . '(0[1-9]|[1-2][0-9]|3[0-1])$/';
                        if(preg_replace($padrao, '', $resultado)){
                            $resultado = $this->formatacaoUtil->formatarDataInversa($resultado);
                        }
                    }
                    break;
                    
                case 'boolean':
                    $resultado = $this->formatacaoUtil->formatarBoolean($resultado);
                    break;
                    
                case 'cpf':
                    $resultado = preg_replace('/[^0-9]/', '', $resultado);
                    break;
                    
                case 'senha':
                    if(strlen($resultado) >= 6){
                        $resultado = sha1($resultado);
                    }
                    break;
                
                case 'object':
                    if(is_array($resultado)){
                        $resultado = (object) $resultado;
                    }
                    if(is_object($resultado)){
                        $resultado = $this->analisarModelo($resultado, $modelo);
                    }
                    break;
                    
                case 'arrayObject':
                    $resultado = array();
                    foreach($dado as $key => $value){
                        $resultadoAjustado = $value;
                        if(gettype($value) === 'array'){
                            $resultadoAjustado = (object) $resultadoAjustado;
                        }
                        $resultado[$key] = $this->analisarModelo($resultadoAjustado, $modelo);
                    }
                    break;
            }
        }
        
        return $resultado;
    }
    
    private function analisarModelo($dado, $modelo){
        $resultado = $dado;

        switch($modelo){
            case 'fonteRecursosAnualOsc':
                $resultado = (new FonteRecursosAnualOscModel($dado));
                break;
                
            case 'recursosOsc':
                $resultado = (new RecursosOscModel($dado));
                break;
                
            case 'projeto':
                $resultado = (new ProjetoModel($dado));
                break;
        }
        
        return $resultado;
    }
}