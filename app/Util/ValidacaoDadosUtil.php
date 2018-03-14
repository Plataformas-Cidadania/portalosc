<?php

namespace App\Util;

class ValidacaoDadosUtil
{
	public function validarArquivo($arquivo)
	{
		$result = false;
		
		if(method_exists($arquivo, 'isValid')){
			if($arquivo->isValid()){
				$result = true;
			}
		}
		
		return $result;
	}
	
	public function validarCpf($data = null)
	{
		$resultado = true;
		
		$invalidData = ['00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'];
		
		$data = preg_replace('/[^0-9]/', '', $data);
		$data = str_pad($data, 11, '0', STR_PAD_LEFT);
		
		if(strlen($data) != 11) {
			$resultado = false;
		}else if(in_array($data, $invalidData)){
			$resultado = false;
		}else{
			for($t = 9; $t < 11; $t++){
				for($d = 0, $c = 0; $c < $t; $c++){
					$d += $data{$c} * (($t + 1) - $c);
				}
				
				$d = ((10 * $d) % 11) % 10;
				if($data{$c} != $d){
					$resultado = false;
				}
			}
		}
		
		return $resultado;
	}
	
	public function validarEmail($dado = null)
    {
        $padrao = '/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/';
        $resultado = preg_match_all($padrao, $dado);
        
        return $resultado;
    }
    
    public function validarData($dado = null)
    {
        $separator = '(\/|-|\.)';
		$padrao = '/^[0-9]{4}' . $separator . '(0[1-9]|1[0-2])' . $separator . '(0[1-9]|[1-2][0-9]|3[0-1])$/';
        $resultado = preg_match_all($padrao, $dado);
        return $resultado;
    }
    
    public function validarBooleano($dado = null)
    {
    	$resultado = true;
    	
    	$validacao = $dado == false ? true : filter_var($dado, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    	if(!$validacao){
    		$resultado = false;
    	}
    	
    	return $resultado;
    }
    
    public function validarArrayInteiro($dado = null)
    {
    	$resultado = true;
    	
    	if($dado && is_array($dado)){
	    	foreach($dado as $value){
	    		if(!is_int($value)){
	    			$resultado = false;
	    			break;
	    		}
	    	}
    	}else{
    		$resultado = false;
    	}
    	
    	return $resultado;
    }
    
    public function validarArrayArray($dado = null)
    {
    	$resultado = true;
    	
    	if($dado && is_array($dado)){
	    	foreach($dado as $value){
	    		if(!is_array($value)){
	    			$resultado = false;
	    			break;
	    		}
	    	}
    	}else{
    		$resultado = false;
    	}
    	
    	return $resultado;
    }
    
    public function validarArrayObject($dado = null)
    {
    	$resultado = true;
    	
    	if($dado && is_array($dado)){
	    	foreach($dado as $value){
	    		if(!is_object($value)){
	    			$resultado = false;
	    			break;
	    		}
	    	}
    	}else{
    		$resultado = false;
    	}
    	
    	return $resultado;
    }
}
