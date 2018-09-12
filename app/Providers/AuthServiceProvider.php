<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;
use App\Enums\TipoUsuarioEnum;

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
    		$user_header = null;

    		if($request->header('Authorization')){
                $token_header = $request->header('Authorization');
            }else if($request->input('headers')){
                $headers = $request->input('headers');
                $token_header = $headers['Authorization'];
            }else if($request->input('Authorization')){
                $token_header = $request->input('Authorization');
            }
            $token_header = str_replace('Bearer ', '', $token_header);

            $separador = strpos($token_header, '|');
            if($separador){
                $user_header = substr($token_header, 0, $separador);
                $token_header = substr($token_header, $separador + 1);
            }

            if($token_header && $user_header){
	            $token_decrypted = openssl_decrypt($token_header, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));

				if (strpos($token_decrypted, '_') !== false) {
	                $token_array = explode('_', $token_decrypted);

	                if(count($token_array) == 3 || count($token_array) == 4){
		                $id_usuario_token = $token_array[0];
		                $tipo_usuario_token = $token_array[1];

		                $token_extension = null;
		                if($tipo_usuario_token == 1){
		                    $date_expires_token = $token_array[2];
		                }else if($tipo_usuario_token == TipoUsuarioEnum::OSC) {
		                    $token_extension = str_replace(['[', ']'], '', $token_array[2]);
		                    $token_extension = explode(',', $token_extension);
		        			$date_expires_token = $token_array[3];
		                }else if($tipo_usuario_token == TipoUsuarioEnum::GOVERNO_MUNICIPAL || $tipo_usuario_token == TipoUsuarioEnum::GOVERNO_ESTADUAL){
		                	$token_extension = $token_array[2];
		                	$date_expires_token = $token_array[3];
		                }

		    			$user = new User();
		    			if($user_header == $id_usuario_token){
		                    $user->id = $id_usuario_token;
		                    $user->tipo = $tipo_usuario_token;
		                    if($tipo_usuario_token == TipoUsuarioEnum::OSC){
		                        $user->representacao = $token_extension;
		                    }else if($tipo_usuario_token == TipoUsuarioEnum::GOVERNO_MUNICIPAL || $tipo_usuario_token == TipoUsuarioEnum::GOVERNO_ESTADUAL){
		                    	$user->localidade = $token_extension;
		                    }
		    			}

		            	$result = $user;
	                }
				}
            }

			if($result === null){
				$verificador = substr($token_header, 0, 2);
				if($verificador == '__'){
					$token = substr($token_header, 2);
					$tokenDecrypted = openssl_decrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
					$tokenArray = explode('_', $tokenDecrypted);

					if(count($tokenArray) == 3){
						$ip = $tokenArray[0];
						$dataCriacao = $tokenArray[1];
						$quantidadeAcessos = $tokenArray[2];

						$dataExecucao = date("Y-m-d H:i:s");
						
						$dataVencimento = strtotime($dataCriacao . ' +1 day');
						$quantidadeAcessoLimite = 100;

						if($dataExecucao <= $dataVencimento){
							if($quantidadeAcessos <= $quantidadeAcessoLimite){
								print_r('ACESSO PERMITIDO');

								$quantidadeAcessos++;

								$stringToken = $ip . '_' . $dataCriacao . '_' . $quantidadeAcessos;
								$tokenEncrypted = openssl_encrypt($stringToken, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
								$token = '__' . $tokenEncrypted;
							}else{
								print_r('QUANTIDADE DE ACESSOS EXCEDIDA');
							}
						}else{
							print_r('VENCIMENTO EXCEDIDO');
						}
					}
				}
			}

    		return $result;
    	});
    }
}
