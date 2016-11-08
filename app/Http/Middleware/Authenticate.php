<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
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
    	$result = $next($request);
        if ($this->auth->guard($guard)->guest()) {
            $result = response(['message' => 'Usuário não autorizado.'], 401);
        }else{
            $flag = false;
            $user = $request->user();

            // Autenticação para os serviços de usuário
            if($request->is('api/user/*')){
                if($request->method() == 'POST'){
                	$id_user = $request->input('id_usuario');
                }else{
                    $char_court = strrpos($request->path(), '/') + 1;
                    $id_user = substr($request->path(), $char_court);
            	}

                if($id_user == $user->id){
                    $flag = true;
                }
            }

            // Autenticação para os serviços de OSC
            if ($request->is('api/osc/*')) {
                if($request->method() == 'POST'){
                    $id_osc = $request->input('id_osc');
                }else{
                    $char_court = strrpos($request->path(), '/') + 1;
                    $id_osc = substr($request->path(), $char_court);
                }
				
                if(in_array($id_osc, $user->representacao)){
                    $flag = true;
                }
            }

            if($flag){
                $result = response(['message' => 'Usuário não autorizado a acessar este conteúdo.'], 401);
            }
        }
        return $result;
    }
}
