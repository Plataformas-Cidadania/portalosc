<?php

namespace App\Services\Log;

use App\Services\Service;
use App\Dao\LogDao;

class LogService extends Service
{
    public function salvarLog($nomeTabela, $idOsc, $idUsuario, $dadoAnterior, $dadoPosterior){
        if($dadoAnterior && $dadoPosterior){
            $dadoAnterior = json_encode($dadoAnterior);
            $dadoPosterior = json_encode($dadoPosterior);
            
            $params = [$nomeTabela, $idOsc, $idUsuario, date("Y-m-d H:i:s"), $dadoAnterior, $dadoPosterior];
            $resultDaoLog = (new LogDao())->insertLog($params);
        }
    }
}
