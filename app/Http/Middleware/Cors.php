<?php

namespace App\Http\Middleware;

use Closure;

class Cors {
    public function handle($request, Closure $next)
    {
		$headers = [
			'Access-Control-Allow-Origin' => '*',
			'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
			'Access-Control-Allow-Headers' => 'Accept, Accept-Encoding, Accept-Language, Connection, Content-Length, Content-Type, Host, Origin, Referer, User-Agent, Authorization, User',
			'Access-Control-Max-Age' => '1728000'
		];
		
		if($request->getMethod() == "OPTIONS") {
			$response = Response(null, 200, $headers);
		}else{
			$response = $next($request);
			foreach($headers as $key => $value){
				$response->header($key, $value);
			}
		}
		
		return $response;
    }
}
