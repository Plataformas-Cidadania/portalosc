<?php

use Illuminate\Support\Facades\Log;

class LoginUserTest extends TestCase
{
    /**
     * Login User
     * GET /api/user/login
     * @param {tx_email_usuario} teste2@gmail.com
     * @param {tx_senha_usuario} 654321
     */
    public function testLoginUser()
    {
        $parameters = [
            'tx_email_usuario' => 'teste2@gmail.com',
            'tx_senha_usuario' => '654321'
        ];

        $headers = [
            'Content-Type' => 'application/json'
        ];
        echo ("#7 Login User.. \n");
        Log::info('#7 Login User');
        Log::warning('DADOS DO USUARIO :', $parameters);
        $this->json('POST', '/api/user/login', $parameters, $headers);
        $this->seeStatusCode(200);

        echo ("#7 Login User '/api/user/login' OK #.. \n");
        echo (".#7 Login com Sucesso !!! #");
    }
}
