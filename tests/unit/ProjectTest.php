<?php

class ProjectTest extends TestCase
{
    use HasOscTests;

    /**
     * Pesquisar Projeto
     * GET /api/geo/osc/{id_osc}
     * @param {id_osc} 785606
     * @param {id_osc} 987654
     */
    public function testSearchOscGeo()
    {
        $idsOsc = $this->getIdsGeoOsc();

        foreach ($idsOsc as $id) {
            echo "\nGET - /api/osc/no_project/$id: Iniciado\n";
            $this->get("/api/osc/no_project/$id")
                ->seeStatusCode(200);
            echo "GET - /api/osc/no_project/$id: Finalizado\n";
        }
    }
}
