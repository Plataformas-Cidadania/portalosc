<?php

namespace App\Services;

use App\Util\ValidacaoDadosUtil;

class ValidadorDados{
    public function validarDado($dado, $tipo){
        $resultado = true;
        
        $validacaoDados = new ValidacaoDadosUtil();

        switch($tipo){
            case 'string':
                $resultado = true;
                break;
                
            case 'integer':
                $resultado = ctype_digit($dado) || is_int($dado);
                break;
                
            case 'double':
                $resultado = is_float($dado);
                break;
                
            case 'date':
                $resultado = $validacaoDados->validarData($dado);
                break;
                
            case 'boolean':
                $resultado = $validacaoDados->validarBooleano($dado);
                break;
                
            case 'array':
                $resultado = is_array($dado);
                break;
                
            case 'arrayInteger':
                $resultado = $validacaoDados->validarArrayInteiro($dado);
                break;
                
            case 'arrayArray':
                $resultado = $validacaoDados->validarArrayArray($dado);
                break;
                
            case 'arrayObject':
                $resultado = $validacaoDados->validarArrayObject($dado);
                break;
                
            case 'email':
                $resultado = $validacaoDados->validarEmail($dado);
                break;
                
            case 'cpf':
                $resultado = $validacaoDados->validarCpf($dado);
                break;
                
            case 'senha':
                $resultado = (strlen($dado) >= 6);
                break;
                
            case 'localidade':
                $resultado = (strlen($dado) == 7 || strlen($dado) == 2);
                break;
                
            case 'arquivo':
                $resultado = $validacaoDados->validarArquivo($dado);
                break;
        }
		
        return $resultado;
    }
}