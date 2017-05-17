<?php

namespace App;

use Laravel\Lumen\Application as LumenApplication;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Application extends LumenApplication
{
    protected function getMonologHandler()
    {
    	$log_path = env('LOG_PATH');
    	
    	if($log_path == null){
    		$log_path = storage_path('logs/mapaosc.log');
    	}
    	
    	return (new StreamHandler($log_path, Logger::DEBUG))->setFormatter(new LineFormatter(null, null, true, true));
    }
}
