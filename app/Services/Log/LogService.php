<?php

namespace App\Services\Log;

use App\Services\Service;
use App\Dao\LogDao;

class LogService extends Service
{
    public function salvarLog($nomeTabela, $idOsc, $idUsuario, $dadoAnterior, $dadoPosterior){
        print_r($dadoPosterior);
        print_r($dadoPosterior);
        print_r(strlen($dadoAnterior));
        print_r(strlen($dadoPosterior));
		if(strlen($dadoAnterior) >= 0 && strlen($dadoPosterior) >= 0){
    		if($dadoAnterior != null && substr($dadoAnterior, 0, 1) != '{') $dadoAnterior = '{' . rtrim($dadoAnterior, ',') . '}';
    		if($dadoPosterior != null && substr($dadoPosterior, 0, 1) != '{') $dadoPosterior = '{' . rtrim($dadoPosterior, ',') . '}';
    		
    		$dadoAnterior = json_encode($dadoAnterior);
    		$dadoPosterior = json_encode($dadoPosterior);
    		
	   		$params = [$nomeTabela, $idOsc, $idUsuario, date("Y-m-d H:i:s"), $dadoAnterior, $dadoPosterior];
	   		$resultDaoLog = $this->log->insertLog($params);
    	}
    }
}
