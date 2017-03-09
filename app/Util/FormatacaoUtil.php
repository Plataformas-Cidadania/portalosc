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

    function converMoneyToDouble($data_original)
    {
        $result = $data_original;

        $result = str_replace(".", "", $result);
        $result = str_replace(",", ".", $result);

        return $result;
    }
    
    function removerAcento($str){
    	$result = preg_replace(array("/(�|�|�|�|�)/","/(�|�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�|�)/","/(�|�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�)/","/(�)/"), explode(" ","a A e E i I o O u U n N"), $str);
    	
    	return $result;
    }
}
