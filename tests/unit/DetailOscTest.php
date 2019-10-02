<?php

class DetailOscTest extends TestCase
{
    use HasOscTests;

    /**
     * Detalhe Geral Osc
     * GET /api/osc/dados_gerais/789809
     * Detail Osc
     */
    public function testDetailOsc()
    {
        $idOsc = $this->getIdOscDadosGerais();

        echo "\nGET - /api/osc/dados_gerais/$idOsc: Iniciado\n";

        $response = $this->json('GET', "/api/osc/dados_gerais/$idOsc");
        $response->seeStatusCode(200);

        echo "GET - /api/osc/dados_gerais/$idOsc: Finalizado\n";
    }
}