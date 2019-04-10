<?php

use Illuminate\Support\Facades\Log;

class GeoOscTest extends TestCase
{
    /**
     * Pesquisar Osc Geolocalização
     * /api/geo/osc/{id_osc}
     * @param {id_osc} 785606
     * @param {id_osc} 987654
     */
    public function testSearchOscGeo()
    {
        try {
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
            echo ("### Pesquisar Osc Geo '/api/menu/geo/municipio/785606' OK ###.. \n");
            echo ("..### Requisição feita com sucesso !!! ###");
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer requisição para rota "/api/menu/geo/municipio/785606".' . "\n");
            echo ("Erro a fazer a requisição, consulte o log!!!");
            return die;
        }
    }
}
