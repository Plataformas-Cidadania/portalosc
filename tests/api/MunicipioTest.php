<?php

use Illuminate\Support\Facades\Log;

class MunicipioTest extends TestCase
{
    /**
     * API Municipio
     * /api/geo/cluster/municipio
     */
    public function testGetMunicipio()
    {
        try {
            $response = $this->get("/api/geo/cluster/municipio");
            $response->seeStatusCode(200);
            $response->seeJsonStructure([
                '*' => [
                    'id_regiao',
                    'tx_nome_regiao',
                    'tx_sigla_regiao',
                    'geo_lat_centroid_regiao',
                    'geo_lng_centroid_regiao',
                    'nr_quantidade_osc_regiao'
                ]
            ]);
            echo ("### Fazendo requisição para '/api/geo/cluster/municipio' ###.. \n");
            echo ("..### Requisição feita com sucesso !!! ###");
            return true;
        } catch (\Exception $e) {
            $this->assertTrue(false);
            return false;
        }
    }
}
