<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UsuarioTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUsuario()
    {
        $dados = [
            'cd_tipo_usuario' => '2',
            'tx_email_usuario' => 'teste@gmail.com',
            'tx_senha_usuario' => '123',
            'tx_nome_usuario' => 'teste',
            'nr_cpf_usuario' => '10110177070',
            'bo_lista_email' => 'true',
            'bo_ativo' => 'true',
            'dt_cadastro' => date("d/m/Y"),
            'dt_atualizacao',
            'bo_email_confirmado' => 'true',
            'tx_telefone_1' => 'true',
            ];

        $this->post('/api/user', $dados);

        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());

        $this->assertArrayHasKey('tx_nome_usuario', $resposta);
        $this->assertArrayHasKey('tx_email_usuario', $resposta);
        $this->assertArrayHasKey('tx_senha_usuario', $resposta);
    }
}
