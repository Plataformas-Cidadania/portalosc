<?php

use Illuminate\Support\Facades\Log;

class ListOscTest extends TestCase
{
    /**
     * Pesquisa Avançada Osc
     * POST api/search/advanced/lista/0/0
     * Pesquisar Osc Lista
     * @return void
     */
    public function testSearchOscList()
    {
        $parameters = [
            'avancado' => [
                'dadosGerais' => [
                    'tx_razao_social_osc' => "terra",
                    'tx_nome_uf' => 'Goiás',
                    'cd_uf' => '52'
                ],
                'ipeadata' => [
                    'tx_razao_social_osc' => "terra",
                    'tx_nome_uf' => 'Goiás',
                    'cd_uf' => '52'
                ]
            ]
        ];

        $parameters2 = [
            'avancado' => [
                'dadosGerais' => [
                    'tx_razao_social_osc' => "terra dos homens",
                    'tx_nome_uf' => 'Rio de Janeiro',
                    'cd_uf' => '33'
                ],
                'ipeadata' => [
                    'tx_razao_social_osc' => "terra dos homens",
                    'tx_nome_uf' => 'Rio de Janeiro',
                    'cd_uf' => '33'
                ]
            ]
        ];

        $parameters3 = [
            'avancado' => [
                'dadosGerais' => [
                    'tx_razao_social_osc' => "crianças",
                    'tx_nome_uf' => 'São Paulo',
                    'cd_uf' => '35'
                ],
                'ipeadata' => [
                    'tx_razao_social_osc' => "crianças",
                    'tx_nome_uf' => 'São Paulo',
                    'cd_uf' => '35'
                ]
            ]
        ];

        echo ("#4 Pesquisar Avançada.. \n");
        Log::info('#4 Pesquisar Avançada');
        $this->post("/api/search/advanced/lista/0/0", $parameters, []);
        $this->seeStatusCode(200);

        $this->post("/api/search/advanced/lista/0/0", $parameters2, []);
        $this->seeStatusCode(200);

        $this->post("/api/search/advanced/lista/0/0", $parameters3, []);
        $this->seeStatusCode(200);

        echo ("#4 Pesquisar Avançada '/api/search/advanced/lista/0/0' #.. \n");
        echo ("..#4 Requisição feita com sucesso OK !!! #");
    }
}
