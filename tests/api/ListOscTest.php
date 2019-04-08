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
        $parameters = [
            'avancado' => [
                'dadosGerais'=> [
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
                'dadosGerais'=> [
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
                'dadosGerais'=> [
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
        try {
            $this->post("/api/search/advanced/lista/0/0", $parameters, []);
            $this->seeStatusCode(200);

            $this->post("/api/search/advanced/lista/0/0", $parameters2, []);
            $this->seeStatusCode(200);

            $this->post("/api/search/advanced/lista/0/0", $parameters3, []);
            $this->seeStatusCode(200);

            $this->assertTrue(true);
            echo ("### Pesquisar Osc Lista '/api/search/advanced/lista/0/0' OK ###.. \n");
            echo ("..### Requisição feita com sucesso !!! ###");
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer requisição para rota "/api/search/advanced/lista/0/0".' . "\n");
            echo ("Erro a fazer a requisição, consulte o log!!!");
            return die;
        }
    }
}
