<?php

use Illuminate\Support\Facades\Log;

class LoginUserTest extends TestCase
{
    /**
     * Pagina Home
     * GET /
     * @return void
     */
    public function testPageHome()
    {
        echo ("#1 Home Portal '/' #.. \n");
        Log::info('#1 Home Portal');
        $response = $this->get('/');
        $response->seeStatusCode(200);
        echo ("#1 Home Portal '/' #.. \n");
        echo (".### Requisição feita com sucesso OK !!! ### \n \n");
        echo $response->response->original;
        echo ("\n");
    }

    /**
     * Pagina App Info
     * GET /api/sobre
     * @return void
     */
    public function testAppInfo()
    {
        echo ("#1 APP Version '/' #.. \n");
        Log::info('#1 APP Version');
        $response = $this->get('/api/sobre');
        $response->seeStatusCode(200);
        echo ("#1 APP Version '/api/sobre' #.. \n");
        echo (".#1 Requisição feita com sucesso OK !!! # \n \n");
        echo $response->response->original;
    }
}
