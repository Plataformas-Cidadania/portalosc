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
        try {

            $this->json('POST', '/api/user/login', $parameters, $headers);
            $this->seeStatusCode(200);

            echo ("### Pesquisar Osc Lista '/api/user/login' OK ###.. \n");
            echo (".### Login com Sucesso !!! ###");
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer login "/api/user/login".' . "\n");
            Log::warning('DADOS DO USUARIO :', $parameters);
            echo ("Erro ao fazer login, consulte o log!!!");
            return die;
        }
    }
}
