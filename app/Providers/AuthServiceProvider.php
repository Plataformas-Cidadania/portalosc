<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
    	$this->app['auth']->viaRequest('api', function ($request) {
            /*
    		if ($request->header('token') && $request->header('user')) {
    			$token = (string) DB::select('SELECT cd_token FROM portal.tb_token WHERE id_usuario = (?::INTEGER);', [$request->header('user')])[0]->cd_token;
    			if($request->header('token') == $token){
    				return true;
    			}
    		}
            */
            return true;
    	});
    }
}
