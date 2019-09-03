<?php

class LoginUserTest extends TestCase
{
    use HasLoginTests;

    /**
     * Login User
     * GET /api/user/login
     * @param {tx_email_usuario} teste2@gmail.com
     * @param {tx_senha_usuario} 654321
     */
    public function testLoginUser()
    {
        $parameters = $this->getLoginCredentials();

        $headers = [
            'Content-Type' => 'application/json'
        ];

        echo "\nPOST - /api/user/login: Iniciado\n";
        $this->json('POST', '/api/user/login', $parameters, $headers);
        $this->seeStatusCode(200);
        echo "POST - /api/user/login: Finalizado\n";
    }
}
