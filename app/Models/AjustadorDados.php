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
    	
        switch($tipo){
            case 'integer':
                $resultado = intval($dado);
                break;

            case 'double':
                $resultado = str_replace(',', '.', $dado);
                $resultado = floatval($resultado);
                break;
                
            case 'date':
                if(strlen($dado) == 4){
                    $resultado = '01-01-' . $dado;
                }else{
                    $separator = '(\/|-|\.)';
                    $padrao = '/^[0-9]{4}' . $separator . '(0[1-9]|1[0-2])' . $separator . '(0[1-9]|[1-2][0-9]|3[0-1])$/';
                    if(preg_replace($padrao, '', $dado)){
                        $resultado = $this->formatacaoUtil->formatarDataInversa($dado);
                    }
                }

                break;
                
            case 'boolean':
            	$resultado = $this->formatacaoUtil->formatarBoolean($dado);
                break;
                
            case 'cpf':
                $resultado = preg_replace('/[^0-9]/', '', $dado);
                break;
                
            case 'senha':
                if(strlen($dado) >= 6){
                    $resultado = sha1($dado);
                }
                break;
            
            case 'object':
                $dadoAjustado = $value;
                if(gettype($value) === 'array'){
                    $dadoAjustado = (object) $dadoAjustado;
                }
                $resultado = $this->analisarModelo($dadoAjustado, $modelo);
                break;
                
            case 'arrayObject':
                $resultado = array();
            	foreach($dado as $key => $value){
                    $dadoAjustado = $value;
                    if(gettype($value) === 'array'){
                        $dadoAjustado = (object) $dadoAjustado;
                    }
                    $resultado[$key] = $this->analisarModelo($dadoAjustado, $modelo);
            	}
                break;
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