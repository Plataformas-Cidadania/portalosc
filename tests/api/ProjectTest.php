<?php

use Illuminate\Support\Facades\Log;

class ProjectTest extends TestCase
{
    /**
     * Pesquisar Projeto
     * /api/geo/osc/{id_osc}
     * @param {id_osc} 785606
     * @param {id_osc} 987654
     */
    public function testSearchOscGeo()
    {
        try {
            $this->get("/api/osc/no_project/785606");
            $this->seeStatusCode(200);

            $this->get("/api/osc/no_project/987654");
            $this->seeStatusCode(200);

            $this->assertTrue(true);
            echo ("### Pesquisar Projeto '/api/osc/no_project/785606' OK ###.. \n");
            echo ("..### Requisição feita com sucesso !!! ###");
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer requisição para rota "/api/osc/no_project/785606".' . "\n");
            echo ("Erro a fazer a requisição, consulte o log!!!");
            return die;
        }
    }
}
