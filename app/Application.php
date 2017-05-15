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
        return (new StreamHandler(env('APP_LOG_PATH', 'mapaosc.log'), Logger::DEBUG))
            ->setFormatter(new LineFormatter(null, null, true, true));
    }
}
