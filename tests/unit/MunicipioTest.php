<?php

use Illuminate\Support\Facades\Log;

class MunicipioTest extends TestCase
{
    /**
     * Todos Municipios
     * GET /api/geo/cluster/municipio
     */
    public function testGetMunicipio()
    {
        echo ("#2 Buscar todos municipios.. \n");
        Log::info('#2 Buscar todos municipios');
        $this->get("/api/geo/cluster/municipio");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'id_regiao',
                'tx_nome_regiao',
                'tx_sigla_regiao',
                'geo_lat_centroid_regiao',
                'geo_lng_centroid_regiao',
                'nr_quantidade_osc_regiao'
            ]
        ]);
        echo ("#2 Buscar todos municipios '/api/geo/cluster/municipio' OK #.. \n");
        echo ("..#2 Requisição feita com sucesso !!! # \n");
    }

    /**
     * Pesquisar Município
     * GET /api/menu/geo/municipio/{nome_municipio}
     * @param {nome_municipio} Luziania
     * @param {nome_municipio} Teresina
     * @param {nome_municipio} Goiania
     * @param {nome_municipio} Brasilia
     */
    public function testSearchMunicipio()
    {
        echo ("#2 Pesquisar por municipio.. \n");
        Log::info('#2 Pesquisar por municipio');
        $this->get("/api/menu/geo/municipio/Luziania");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'edmu_cd_municipio',
                'edmu_nm_municipio',
                'eduf_sg_uf'
            ]
        ]);
        $this->get("/api/menu/geo/municipio/Teresina");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'edmu_cd_municipio',
                'edmu_nm_municipio',
                'eduf_sg_uf'
            ]
        ]);
        $this->get("/api/menu/geo/municipio/Goiania");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'edmu_cd_municipio',
                'edmu_nm_municipio',
                'eduf_sg_uf'
            ]
        ]);
        $this->get("/api/menu/geo/municipio/Brasilia");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'edmu_cd_municipio',
                'edmu_nm_municipio',
                'eduf_sg_uf'
            ]
        ]);
        echo ("#2 Pesquisar por municipio '/api/menu/geo/municipio/{nome_municipio}' OK #.. \n");
        echo ("..#2 Requisição feita com sucesso !!! #");
    }
}
