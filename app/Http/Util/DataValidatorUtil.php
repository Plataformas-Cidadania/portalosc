<?php

namespace App\Http\Util;

class DataValidatorUtil
{
	public function validateCPF($cpf = null)
	{
		$result = true;
		
		$invalidData = ['00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'];
		
		$cpf = preg_replace('/[^0-9]/', '', $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		
		if(strlen($cpf) != 11) {
			$result = false;
		}else if(in_array($cpf, $invalidData)){
			$result = false;
		}else{
			for($t = 9; $t < 11; $t++){
				for($d = 0, $c = 0; $c < $t; $c++){
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				
				$d = ((10 * $d) % 11) % 10;
				if($cpf{$c} != $d){
					$result = false;
				}
			}
		}
		
		return $result;
	}
	
    public function validateEmail($email = null)
    {
    	$result = true;
    	
    	$pattern = '/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/';
    	if(!preg_match($pattern, $email)){
			$result = false;
        }
        
        return $result;
    }
}
