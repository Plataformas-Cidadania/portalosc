<?php

class GeoOscTest extends TestCase
{
    use HasOscTests;

    /**
     * Pesquisa Osc Geo
     * GET /api/geo/osc/{id_osc}
     * Pesquisar Osc Geolocalização
     * /api/geo/osc/{id_osc}
     * @param {id_osc} 785606
     * @param {id_osc} 987654
     */
    public function testSearchOscGeo()
    {
        $idsOsc = $this->getIdsGeoOsc();

        foreach ($idsOsc as $id) {
            echo "\nGET - /api/geo/osc/$id: Iniciado\n";
            $response = $this->get("/api/geo/osc/$id");
            $response->seeStatusCode(200);
            $response->seeJsonStructure([
                '*' => [
                    'geo_lat',
                    'geo_lng'
                ]
            ]);
            echo "GET - /api/geo/osc/$id: Finalizado\n";
        }
    }
}
