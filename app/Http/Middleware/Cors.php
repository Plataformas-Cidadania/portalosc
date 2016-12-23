<?php

namespace App\Http\Middleware;

use Closure;

class Cors {
    public function handle($request, Closure $next)
    {
		header("Access-Control-Allow-Origin: *");

		$headers = [
			'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
			'Access-Control-Allow-Headers'=> 'Accept, Accept-Encoding, Accept-Language, Connection, Content-Length, Content-Type, Host, Origin, Referer, User-Agent, Authorization, User'
		];
		
		if($request->getMethod() == "OPTIONS") {
			return Response::make('OK', 200, $headers);
		}

		$response = $next($request);
		foreach($headers as $key => $value){
			$response->header($key, $value);
		}
		
		return $response;
    }
}
