<?php

namespace App\Util;

class ValidacaoUtil
{
    public function validarCPF($cpf = null)
    {
        // Verifica se um número foi informado
        if(empty($cpf)) {
            return false;
        }
		
        // Elimina possivel mascara
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		
        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }
        
        // Verifica se nenhuma das sequências invalidas abaixo foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999') {
            return false;
         // Calcula os digitos verificadores para verificar se o CPF é válido
         }else{
            for($t = 9; $t < 11; $t++) {
                for($d = 0, $c = 0; $c < $t; $c++) {
                	$d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if($cpf{$c} != $d) {
                	return false;
                }
            }
			
            return true;
        }
    }

    function validarEmail($email = null)
    {
        $er = '/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/';
        if(preg_match($er, $email)){
			return true;
        }else{
			return false;
        }
    }
}
