<?php

namespace App\Models;

use App\Models\Osc\RecursosOscModel;
use App\Models\Osc\FonteRecursosAnualOscModel;
use App\Util\FormatacaoUtil;

class AjusteDados
{
    public function ajustar($dado, $tipo, $modelo = null)
    {
        $resultado = $dado;
        
    	$this->formatacaoUtil = new FormatacaoUtil();
    	
        switch($tipo){
            case 'float':
                $resultado = str_replace(',', '.', $dado);
                break;
                
            case 'date':
                if(strlen($dado) == 4){
                    $resultado = '01-01-' . $dado;
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
        }
        
        return $resultado;
    }
}