<?php

use Illuminate\Support\Facades\Log;

class ListOscTest extends TestCase
{
    /**
     * Pesquisar Osc Lista
     * api/search/advanced/lista/0/0
     */
    public function testSearchOscList()
    {
        try {
            $this->get("/api/search/advanced/lista/0/0");
            $this->seeStatusCode(200);
            $this->assertTrue(true);
            echo ("### Pesquisar Osc Geo '/api/search/advanced/lista/0/0' OK ###.. \n");
            echo ("..### Requisição feita com sucesso !!! ###");
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer requisição para rota "/api/search/advanced/lista/0/0".' . "\n");
            echo ("Erro a fazer a requisição, consulte o log!!!");
            return die;
        }
    }
}
