<?php

namespace App\Dao\Exportacao;

use App\Dao\DaoPostgres;

class ExportacaoBuscaDao extends DaoPostgres{
    public function ExportarBusca($modelo){
        $listaOsc = '{' . implode(",", $modelo->listaOsc) . '}';
        $variaveisAdicionais = $modelo->variaveisAdicionais;

        $colunasAdicionais = $this->montarSqlColunasAdicionais($variaveisAdicionais);

        $query = '
            SELECT
                a.id_osc AS id_osc,
                a.tx_razao_social_osc AS tx_razao_social,
                b.tx_nome_natureza_juridica AS tx_natureza_juridica,
                c.tx_nome_classe_atividade_economica AS tx_classe_atividade_economica,
                d.edmu_nm_municipio AS tx_municipio,
                d.eduf_nm_uf AS tx_estado
                ' . $colunasAdicionais . '
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

        return $this->executarQuery($query, false, $params);
    }

    private function montarSqlColunasAdicionais($variaveisAdicionais){
        $sql = '';

        foreach($variaveisAdicionais as $variavel){
            $indice = '';
            $apelido = '';

            switch($variavel){
                case 'idh':
                    $indice .= '1';
                    $apelido = 'idh';
                    break;

                case 'var2':
                    $indice .= '2';
                    $apelido = 'param2';
                    break;

                case 'var3':
                    $indice .= '3';
                    $apelido = 'param3';
                    break;

                case 'var4':
                    $indice .= '4';
                    $apelido = 'param4';
                    break;

                case 'var5':
                    $indice .= '5';
                    $apelido = 'param5';
                    break;

                case 'var6':
                    $indice .= '6';
                    $apelido = 'param6';
                    break;

                case 'var7':
                    $indice .= '7';
                    $apelido = 'param7';
                    break;

                case 'var8':
                    $indice .= '8';
                    $apelido = 'param8';
                    break;
            }

            if($indice){
                $sql .= ', (
                    SELECT nr_valor AS ' . $apelido . '
                    FROM ipeadata.tb_ipeadata
                    WHERE cd_indice = ' . $indice . '
                    AND cd_municipio = d.cd_municipio
                )';
            }
        }

        return $sql;
    }
}