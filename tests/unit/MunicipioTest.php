<?php

class MunicipioTest extends TestCase
{
    /**
     * Todos Municipios
     * GET /api/geo/cluster/municipio
     * @return void
     */
    public function testGetMunicipio()
    {
        echo "\nGET - /api/geo/cluster/municipio: Iniciado";

        $this->get("/api/geo/cluster/municipio");
        $this->seeStatusCode(200);

        echo "\nGET - /api/geo/cluster/municipio: Finalizado";
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
        echo "\nGET - /api/menu/geo/municipio/Luziania: Iniciado\n";
        $this->get("/api/menu/geo/municipio/Luziania");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'edmu_cd_municipio',
                'edmu_nm_municipio',
                'eduf_sg_uf'
            ]
        ]);
        echo "GET - /api/menu/geo/municipio/Luziania: Finalizado\n";

        echo "GET - /api/menu/geo/municipio/Teresina: Iniciado\n";
        $this->get("/api/menu/geo/municipio/Teresina");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'edmu_cd_municipio',
                'edmu_nm_municipio',
                'eduf_sg_uf'
            ]
        ]);
        echo "GET - /api/menu/geo/municipio/Teresina: Finalizado\n";

        echo "GET - /api/menu/geo/municipio/Goiania: Iniciado\n";
        $this->get("/api/menu/geo/municipio/Goiania");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'edmu_cd_municipio',
                'edmu_nm_municipio',
                'eduf_sg_uf'
            ]
        ]);
        echo "GET - /api/menu/geo/municipio/Goiania: Finalizado\n";

        echo "GET - /api/menu/geo/municipio/Brasilia: Iniciado\n";
        $this->get("/api/menu/geo/municipio/Brasilia")
            ->seeStatusCode(200)
            ->seeJsonStructure([
                '*' => [
                    'edmu_cd_municipio',
                    'edmu_nm_municipio',
                    'eduf_sg_uf'
                ]
            ]);
        echo "GET - /api/menu/geo/municipio/Brasilia: Finalizado\n";
    }
}
