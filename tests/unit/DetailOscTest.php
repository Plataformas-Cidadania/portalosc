<?php

use Illuminate\Support\Facades\Log;

class DetailOscTest extends TestCase
{
    /**
     * Detalhe Geral Osc
     * GET /api/osc/dados_gerais/789809
     * Detail Osc
     */
    public function testDetailOsc()
    {
        echo ("#3 Dados Gerais Osc.. \n");
        Log::info('#3 Dados Gerais Osc');
        $response = $this->json('GET', "/api/osc/dados_gerais/789809");
        $response->seeStatusCode(200);
        echo ("#3 Dados Gerais Osc '/api/osc/dados_gerais/789809' OK #.. \n");
        echo ("..#3 Requisição feita com sucesso !!! # \n");
    }
}
