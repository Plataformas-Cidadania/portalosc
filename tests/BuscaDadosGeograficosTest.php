<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class BuscaDadosGeograficosTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBuscaDadosGeograficos()
    {
        $this->get('api/analises/idhgeo/3304557');
        //$this->get('api/analises/localidade/3304557');
        $resposta = ($this->response->content());

        echo($resposta);
    }
}