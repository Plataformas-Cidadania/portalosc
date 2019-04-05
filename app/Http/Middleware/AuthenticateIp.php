<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Dao\Usuario\UsuarioDao;
use App\Enums\TipoUsuarioEnum;

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
        $dao = (new UsuarioDao())->verificarAcessoIp($ip);

        if($dao->flag){
            $result = $next($request);
        }else{
            $mensagem = 'Acesso não autorizado.';
            $codigo = 401;
            $result = response(['message' => $mensagem], $codigo);
        }

        return $result;
    }
}
