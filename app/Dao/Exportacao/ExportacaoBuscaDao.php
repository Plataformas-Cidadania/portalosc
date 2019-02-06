<?php

namespace App\Dao\Exportacao;

use App\Dao\DaoPostgres;

class ExportacaoBuscaDao extends DaoPostgres{
    public function ExportarBusca($modelo){
        $listaOsc = '{' . implode(",", $modelo->listaOsc) . '}';
        $variaveisAdicionais = $modelo->variaveisAdicionais;

        $sqlColunasAdicionais = $this->montarSqlColunasAdicionais($variaveisAdicionais);

        $query = '
            SELECT
                a.id_osc AS id_osc,
                a.tx_razao_social_osc AS tx_razao_social,
                b.tx_nome_natureza_juridica AS tx_natureza_juridica,
                c.tx_nome_classe_atividade_economica AS tx_classe_atividade_economica,
                d.edmu_nm_municipio AS tx_municipio,
                d.eduf_nm_uf AS tx_estado
                ' . $sqlColunasAdicionais . '
            FROM osc.tb_dados_gerais AS a
            LEFT JOIN syst.dc_natureza_juridica AS b
            ON a.cd_natureza_juridica_osc = b.cd_natureza_juridica
            LEFT JOIN syst.dc_classe_atividade_economica AS c
            ON a.cd_classe_atividade_economica_osc = c.cd_classe_atividade_economica
            LEFT JOIN (
                osc.tb_localizacao AS a
                INNER JOIN spat.ed_municipio AS b
                ON a.cd_municipio = b.edmu_cd_municipio
                INNER JOIN spat.ed_uf AS c
                ON b.eduf_cd_uf = c.eduf_cd_uf
            ) AS d
            ON a.id_osc = d.id_osc
            WHERE a.id_osc = ANY (?::INTEGER[])
        ';

        $params = [$listaOsc];
        
        $resultadoQuery = $this->executarQuery($query, false, $params);

        return $resultadoQuery;
    }

    private function montarSqlColunasAdicionais($variaveisAdicionais){
        $sql = '';

        foreach($variaveisAdicionais as $idIndice){
            $apelido = $this->obterApelidoColuna($idIndice);

            $sql .= ', (
                SELECT nr_valor AS ' . $apelido . '
                FROM ipeadata.tb_ipeadata
                WHERE cd_indice = ' . $idIndice . '
            )';
        }

        return $sql;
    }

    private function obterApelidoColuna($idIndice){
        $query = '
            SELECT
                tx_nome_indice AS nome_indice,
                regexp_replace(reverse(split_part(reverse(tx_nome_indice), \' - \', 1)), \'^[0-9]*\', \'\') AS apelido
            FROM ipeadata.tb_indice
            WHERE cd_indice = ?::INTEGER
        ';

        $params = [$idIndice];
        $resultadoQuery = $this->executarQuery($query, true, $params);
        $resultado = $resultadoQuery->apelido;

        return $resultado;
    }
}