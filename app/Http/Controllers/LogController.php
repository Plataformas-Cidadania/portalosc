<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Dao\LogDao;

class LogController extends Controller
{
	public function __construct()
	{
		$this->log = new LogDao();
	}
	
	public function saveLog($table_name, $id_osc, $id_user, $tx_dado_anterior, $tx_dado_posterior){
		if($tx_dado_anterior != '' && $tx_dado_posterior != ''){
    		if($tx_dado_anterior != null && substr($tx_dado_anterior, 0, 1) != '{') $tx_dado_anterior = '{' . rtrim($tx_dado_anterior, ',') . '}';
    		if($tx_dado_posterior != null && substr($tx_dado_posterior, 0, 1) != '{') $tx_dado_posterior = '{' . rtrim($tx_dado_posterior, ',') . '}';
    		
	   		$params = [$table_name, $id_osc, $id_user, date("Y-m-d H:i:s"), $tx_dado_anterior, $tx_dado_posterior];
	   		$resultDaoLog = $this->log->insertLog($params);
    	}
    }
}