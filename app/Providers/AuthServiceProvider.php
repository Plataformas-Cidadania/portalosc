<?php

namespace App\Providers;

use App\User;
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
    		if ($request->header('Api-Token') && $request->header('User')) {
    			$token = (string) DB::select('SELECT * FROM portal.tb_token WHERE id_usuario = (?::INTEGER);', [$request->header('User')])[0]->cd_token;
    			if($request->header('Api-Token') == $token){
                    $user = new User();
                    $user->id = $request->header('User');
    			}
    		}
            */

            $user = new User();
            $user->id = 1;

            return $user;
    	});
    }
}
