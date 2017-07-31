<?php

namespace App\Providers;

use App\User;
#use App\Util\LoggerUtil;
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
    		$result = null;
    		
    		$token_header = null;
    		if($request->header('User') && $request->header('Authorization')){
    			$user_header = $request->header('User');
                $token_header = $request->header('Authorization');
                if(strpos($token_header, 'Bearer ') !== false){
                    $token_header = str_replace('Bearer ', '', $token_header);
                }
            }else if($request->input('headers')){
                $headers = $request->input('headers');
                $user_header = $headers['User'];
                $token_header = $headers['Authorization'];
            }else if($request->input('User') && $request->input('Authorization')){
                $user_header = $request->input('User');
                $token_header = $request->input('Authorization');
            }
            
            if($token_header){
	            $token_decrypted = openssl_decrypt($token_header, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
	            
				if (strpos($token_decrypted, '_') !== false) {
	                $token_array = explode('_', $token_decrypted);
					
	                if(count($token_array) == 3 || count($token_array) == 4){
		                $id_usuario_token = $token_array[0];
		                $tipo_usuario_token = $token_array[1];
						
		                $token_extension = null;
		                if($tipo_usuario_token == 1){
		                    $date_expires_token = $token_array[2];
		                }else if($tipo_usuario_token == 2) {
		                	$token_extension = explode(',', $token_array[2]);
		        			$date_expires_token = $token_array[3];
		                }else if($tipo_usuario_token == 3 || $tipo_usuario_token == 4){
		                	$token_extension = $token_array[2];
		                	$date_expires_token = $token_array[3];
		                }
		                
		    			$user = new User();
		    			if($user_header == $id_usuario_token){
		                    $user->id = $id_usuario_token;
		                    $user->tipo = $tipo_usuario_token;
		                    if($tipo_usuario_token == 2){
		                        $user->representacao = $token_extension;
		                    }else if($tipo_usuario_token == 3 || $tipo_usuario_token == 4){
		                    	$user->localidade = $token_extension;
		                    }
		    			}
		    			
		            	$result = $user;
	                }
				}
            }
            
    		return $result;
    	});
    }
}
