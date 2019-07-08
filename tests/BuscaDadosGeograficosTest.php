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
        $this->get('/osc/listaatualizadas');

        $resposta = json_decode($this->response->content());

        echo($resposta);
    }
}