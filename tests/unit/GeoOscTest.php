<?php

use Illuminate\Support\Facades\Log;

class GeoOscTest extends TestCase
{
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
        echo ("#4 Pesquisar Osc Geo.. \n");
        Log::info('#6 Pesquisar Osc Geo');
        $response = $this->get("/api/geo/osc/785606");
        $response->seeStatusCode(200);
        $response->seeJsonStructure([
            '*' => [
                'geo_lat',
                'geo_lng'
            ]
        ]);
        $this->get("/api/geo/osc/987654");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'geo_lat',
                'geo_lng'
            ]
        ]);
        echo ("#4 Pesquisar Osc Geo '/api/menu/geo/municipio/785606' OK #.. \n");
        echo ("..#4 Requisição feita com sucesso OK !!! #");
    }
}
