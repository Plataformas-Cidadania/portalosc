<?php

use Illuminate\Support\Facades\Log;

class DetailOscTest extends TestCase
{
    /**
     * Detail Osc
     * /api/osc/dados_gerais/789809
     */
    public function testDetailOsc()
    {
        try {
            $response = $this->json('GET', "/api/osc/dados_gerais/789809");
            $response->seeStatusCode(200);
            echo ("### Dados Gerais '/api/osc/dados_gerais/789809' OK ###.. \n");
            echo ("..### Requisição feita com sucesso !!! ### \n");
            return true;
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer requisição para rota "/api/osc/dados_gerais/789809".' . "\n");
            echo ("Erro a buscar dados gerais da osc 789809, consulte o log!!!");
            return die;
        }
    }
}
