<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use DB;

class Controller extends BaseController
{
    private $content_response = ["message" => "Recurso não encontrado"];
    private $http_code = 404;

    private function configHttpCode(){
        if($this->content_response){
            $this->http_code = 200;
        }else{
            $this->http_code = 204;
        }
    }

    public function executeSelectQuery($query, $unique, $params){
        $result = null;
        if($params){
    		$result_query = DB::select($query, $params);
        }else{
        	$result_query = DB::select($query);
        }
    	if($result_query){
	    	if($unique){
	    		$result = json_encode(reset($result_query));
			}else{
	    		$result = json_encode($result_query);
			}
    	}

    	return $result;
    }

    public function executeInsertQuery($query, $params){
        DB::insert($query, $params);
    }

    public function configResponse($result){
    	$this->content_response = $result;
    	$this->configHttpCode();
        $response = Response($this->content_response, $this->http_code);
        $response->header('Content-Type', 'application/json');
        return $response;
    }
}
