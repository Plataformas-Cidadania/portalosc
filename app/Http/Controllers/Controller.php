<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function setResponse($response, $paramsHeader = [])
    {
    	$response = Response(json_encode($response->getContent()), $response->getCode());
    	
        $response->header('Content-Type', 'application/json');
        foreach ($paramsHeader as $key => $value){
            $response->header($key, $value);
        }
        
        return $response;
    }
}
