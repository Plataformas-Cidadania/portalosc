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
        try {

            $response = $this->get('/');
            $response->seeStatusCode(200);
            echo ("### Home Portal '/' ###.. \n");
            echo (".### Requisição feita com sucesso OK !!! ### \n \n");
            echo $response->response->original;
        } catch (\Exception $e) {
            Log::warning('Falha ao acessar home "/".' . "\n");
            echo ("Erro ao acessar /, consulte o log!!!");
            return die;
        }
    }

    /**
     * Pagina App Info
     * GET /api/sobre
     * @return void
     */
    public function testAppInfo()
    {
        try {

            $response = $this->get('/api/sobre');
            $response->seeStatusCode(200);
            echo ("### APP Version '/api/sobre' ###.. \n");
            echo (".### Requisição feita com sucesso OK !!! ### \n \n");
            echo $response->response->original;
        } catch (\Exception $e) {
            Log::warning('Erro a buscar a info do APP "/api/sobre".' . "\n");
            echo ("Erro ao acessar info do APP /api/sobre, consulte o log!!!");
            return die;
        }
    }
}
