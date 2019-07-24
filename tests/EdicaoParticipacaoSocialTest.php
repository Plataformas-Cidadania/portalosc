<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class EdicaoParticipacaoSocialTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEdicaoParticipacao()
    {
        echo('...iniciando o teste ....');

        //$outra = $this->input('outra', []);
        //$this->request->add(['outra' => $outra]);

        $dados = ['outra' => [], 'bo_nao_possui_outros_part' => 'true'];

        $this->post('api/osc/participacaosocialoutra/987654', dados);

        $resposta = $this->response->content();

        echo($resposta);

        $this->assertResponseOk();


        //$resposta = (array)json_decode($this->response->content());



        //$this->assertArrayHasKey('geometry', $resposta);

        //print_r($resposta);
    }
}