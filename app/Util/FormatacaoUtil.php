<?php

namespace App\Util;

class FormatacaoUtil
{
    function formatarData($data_original)
    {
        $data_split = explode("-", $data_original);

        $dia = $data_split[0];
        $mes = $data_split[1];
        $ano = $data_split[2];

        $data_formatada = $dia . "-" . $mes . "-" . $ano;

        return $data_formatada;
    }
    
    function formatarDataInversa($data_original)
    {
        $data_split = explode("-", $data_original);
		
        $dia = $data_split[0];
        $mes = $data_split[1];
        $ano = $data_split[2];
		
        $data_formatada = $ano . "-" . $mes . "-" . $dia;
        
        return $data_formatada;
    }

    function converMoneyToDouble($data_original)
    {
        $result = $data_original;

        $result = str_replace(".", "", $result);
        $result = str_replace(",", ".", $result);

        return $result;
    }
    
    function formatarBoolean($data_original){
    	$data_formatada = true;
    	
    	if ($data_original && strtolower($data_original) !== "false") {
    		$data_formatada = true;
    	} else {
    		$data_formatada = false;
    	}
    	
    	return $data_formatada;
    }
}
