<?php

class HomeTest extends TestCase
{
    /**
     * Pagina Home
     * GET /
     * @return void
     */
    public function testPageHome()
    {
        echo "\nGET - /: Iniciado\n";

        $response = $this->get('/');
        $response->seeStatusCode(200);

        echo "GET - /: Finalizado\n";
    }

    /**
     * Pagina App Info
     * GET /api/sobre
     * @return void
     */
    public function testAppInfo()
    {
        echo "\nGET - /api/sobre: Iniciado\n";

        $response = $this->get('/api/sobre');
        $response->seeStatusCode(200);

        echo "GET - /api/sobre: Finalizado\n";
    }
}
