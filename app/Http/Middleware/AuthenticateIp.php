<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class AuthenticateIp
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
		$ip = $request->ip();
		$ip_access = explode(';', getenv('IP_ACCESS'));
		$flag_auth = in_array($ip, $ip_access);

		if($flag_auth){
    		$result = $next($request);
		}else{
			$result = response(['message' => 'Acesso não autorizado.'], 401);
		}

        return $result;
    }
}
