<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    private $content_response = ["message" => "Recurso não encontrado"];
    private $http_code = 404;

    private function configHttpCode()
    {
        if($this->content_response){
            $this->http_code = 200;
        }else{
            $this->http_code = 204;
        }
    }

    public function configResponse($result)
    {
    	$this->content_response = $result;
    	$this->configHttpCode();
    }

    public function response()
    {
        $response = Response($this->content_response, $this->http_code);
        $response->header('Content-Type', 'application/json');
        return $response;
    }
}
