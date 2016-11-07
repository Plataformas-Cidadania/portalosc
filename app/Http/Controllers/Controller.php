<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController{
    private $content_response = ["msg" => "Recurso não encontrado"];
    private $http_code = 404;

    private function configHttpCode(){
        if($this->content_response){
            $this->http_code = 200;
        }else{
            $this->http_code = 204;
        }
    }

    public function configResponse($result, $code_http = 0){
    	$this->content_response = $result;
    	if($code_http){
    		$this->http_code = $code_http;
    	}else{
    		$this->configHttpCode();
    	}
    }

    public function response($paramsHeader = []){
        $response = Response($this->content_response, $this->http_code);
        $response->header('Content-Type', 'application/json');
        foreach ($paramsHeader as $key => $value){
            $response->header($key, $value);
        }
        return $response;
    }
}
