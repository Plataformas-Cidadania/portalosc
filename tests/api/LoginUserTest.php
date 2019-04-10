<?php

use Illuminate\Support\Facades\Log;

class LoginUserTest extends TestCase
{
    /**
     * Login User
     * /api/user/login
     * @param {tx_email_usuario} teste2@gmail.com
     * @param {tx_senha_usuario} 654321
     */
    public function testLoginUser()
    {
        $parameters = [
            'tx_email_usuario' => 'teste2@gmail.com',
            'tx_senha_usuario' => '654321'
        ];

        try {
            $this->post("/api/user/login", $parameters, []);
            $this->seeStatusCode(200);

            echo ("### Pesquisar Osc Lista '/api/user/login' OK ###.. \n");
            echo ("..### Requisição feita com sucesso !!! ###");
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer requisição para rota "/api/user/login".' . "\n");
            echo ("Erro a fazer a requisição, consulte o log!!!");
            return die;
        }
    }
}
