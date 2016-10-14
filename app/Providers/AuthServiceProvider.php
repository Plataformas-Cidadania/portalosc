<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;

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
    		if($request->header('User') && $request->header('Authorization')){
    			$user_header = $request->header('User');
    			$token_header = mcrypt_decrypt($request->header('Authorization'));
    			
    			$user = $token_header.split(':')[0];
    			$date_expires = $token_header.split(':')[1];
    			
    			if($user_header == $user){
                    $user = new User();
                    $user->id = $user;
    			}
    		}
            return $user;
    	});
    }
}
