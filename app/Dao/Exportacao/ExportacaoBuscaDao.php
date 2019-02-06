<?php

namespace App\Dao\Exportacao;

use App\Dao\DaoPostgres;

class ExportacaoBuscaDao extends DaoPostgres{
    public function ExportarBusca($modelo){
        $listaOsc = '{' . implode(",", $modelo->listaOsc) . '}';
        $variaveisAdicionais = '{' . implode(",", $modelo->variaveisAdicionais) . '}';

        $query = 'SELECT a.id_osc, a.tx_razao_social_osc, c.tx_nome_natureza_juridica, b.edmu_nm_municipio, b.eduf_nm_uf
                    FROM osc.tb_dados_gerais AS a
                    LEFT JOIN (
                        osc.tb_localizacao AS a
                        INNER JOIN spat.ed_municipio AS b
                        ON a.cd_municipio = b.edmu_cd_municipio
                        INNER JOIN spat.ed_uf AS c
                        ON b.eduf_cd_uf = c.eduf_cd_uf
                    ) AS b
                    ON a.id_osc = b.id_osc
                    LEFT JOIN syst.dc_natureza_juridica AS c
                    ON a.cd_natureza_juridica_osc = c.cd_natureza_juridica
                    WHERE a.id_osc = ANY (?::INTEGER[])';
        $params = [$listaOsc];

        return $this->executarQuery($query, false, $params);
    }
}