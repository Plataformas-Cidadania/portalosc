<?php

use Illuminate\Support\Facades\Log;

class ProjectTest extends TestCase
{
    /**
     * Pesquisar Projeto
     * GET /api/geo/osc/{id_osc}
     * @param {id_osc} 785606
     * @param {id_osc} 987654
     */
    public function testSearchOscGeo()
    {
        echo ("#8 Pesquisar Projeto.. \n");
        Log::info('#8 Pesquisar Projeto');
        $this->get("/api/osc/no_project/785606");
        $this->seeStatusCode(200);

        $this->get("/api/osc/no_project/987654");
        $this->seeStatusCode(200);

        $this->assertTrue(true);
        echo ("#8 Pesquisar Projeto '/api/osc/no_project/785606 && 987654' OK #.. \n");
        echo ("..#8 Requisição feita com sucesso !!! #");
    }
}
