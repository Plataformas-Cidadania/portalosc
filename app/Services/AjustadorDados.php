<?php

namespace App\Services;

use App\Util\FormatacaoUtil;

class AjustadorDados{
    public function ajustarDado($dado, $tipo, $modelo = null){
        $resultado = $dado;

    	$this->formatacaoUtil = new FormatacaoUtil();

        if($resultado !== null){
            switch($tipo){
                case 'integer':
                    $padrao = '/[0-9]/';
                    if(preg_match($padrao, $resultado)){
                        $resultado = intval($dado);
                    }else{
                        $resultado = null;
                    }

                    break;

                case 'double':
                    $padrao = '/[0-9,\.]/';
                    if(preg_match($padrao, $resultado)){
                        $resultado = str_replace(',', '.', $resultado);
                        $resultado = floatval($resultado);
                    }else{
                        $resultado = null;
                    }

                    break;

                case 'date':
                    $separador = '(\/|-|\.)';
                    $padraoAno = '/^[0-9]{4}$/';
                    $padraoDataNormal = '/^(0[1-9]|[1-2][0-9]|3[0-1])' . $separador . '(0[1-9]|1[0-2])' . $separador . '[0-9]{4}$/';

                    if(preg_match($padraoAno, $resultado)){
                        $resultado = $resultado . '-01-01';
                    }else if(preg_match($padraoDataNormal, $resultado)){
                        $resultado = $this->formatacaoUtil->formatarDataInversa($resultado);
                    }else{
                        $resultado = null;
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
                    
                    if(is_array($dado)){
                        foreach($dado as $key => $value){
                            $resultadoAjustado = $value;
                            
                            if(gettype($resultadoAjustado) === 'array'){
                                $resultadoAjustado = (object) $resultadoAjustado;
                            }
                            
                            $resultado[$key] = $this->analisarModelo($resultadoAjustado, $modelo);
                        }
                    }else{
                        $resultado = [];
                    }

                    break;
            }
        }

        return $resultado;
    }

    private function analisarModelo($dados, $modelo){
        $resultado = null;
        
        if(gettype($dados) === 'object'){
            $dadosAjustado = $this->objectParaArray($dados);
            $classe = new \ReflectionClass($modelo);
            $resultado = $classe->newInstanceArgs($dadosAjustado);
        }

        return $resultado;
    }
    
    private function objectParaArray($dados){
        $resultado = array();
        
        if(is_object($dados)){
            $dado = array();
            foreach($dados as $key => $value){
                if(is_object($value)){
                    $dado[$key] = $this->objectParaArray($value);
                }else{
                    $dado[$key] = $value;
                }
            }
            array_push($resultado, $dado);
        }else{
            $resultado = $dados;
        }
        
        return $resultado;
    }
}