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
        echo ("#6 Pesquisar Osc Geo.. \n");
        Log::info('#6 Pesquisar Osc Geo');
        $this->get("/api/geo/osc/785606");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
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
        echo ("#6 Pesquisar Osc Geo '/api/menu/geo/municipio/785606' OK #.. \n");
        echo ("..#6 Requisição feita com sucesso !!! #");
    }
}
