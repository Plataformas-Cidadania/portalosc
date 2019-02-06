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

            switch(strtolower($variavel)){
                case 'fam_pbf':
                    $indice .= '1';
                    $apelido = 'fam_pbf';
                    break;

                case 'bpc_idos':
                    $indice .= '2';
                    $apelido = 'bpc_idos';
                    break;

                case 'bpc_defi':
                    $indice .= '3';
                    $apelido = 'bpc_defi';
                    break;

                case '13mort1':
                case 'mort1':
                    $indice .= '4';
                    $apelido = 'mort1';
                    break;

                case '13mort5':
                case 'mort5':
                    $indice .= '5';
                    $apelido = 'mort5';
                    break;

                case '13pesorur':
                case 'pesorur':
                    $indice .= '6';
                    $apelido = 'pesorur';
                    break;

                case '13pesourb':
                case 'pesourb':
                    $indice .= '7';
                    $apelido = 'pesourb';
                    break;

                case '13idhm':
                case 'idhm':
                    $indice .= '8';
                    $apelido = 'idhm';
                    break;

                case '13idhm_e':
                case 'idhm_e':
                    $indice .= '9';
                    $apelido = 'idhm_e';
                    break;

                case '13idhm_l':
                case 'idhm_l':
                    $indice .= '10';
                    $apelido = 'idhm_l';
                    break;

                case '13idhm_r':
                case 'idhm_r':
                    $indice .= '11';
                    $apelido = '13idhm_r';
                    break;

                case 'medhab':
                    $indice .= '12';
                    $apelido = 'medhab';
                    break;

                case '13t_analf15m':
                case 't_analf15m':
                    $indice .= '13';
                    $apelido = 't_analf15m';
                    break;
                
                case 'meduca':
                    $indice .= '14';
                    $apelido = 'meduca';
                    break;

                case '13t_fund25m':
                case 't_fund25m':
                    $indice .= '15';
                    $apelido = 't_fund25m';
                    break;

                case '13t_med25m':
                case 't_med25m':
                    $indice .= '16';
                    $apelido = 't_med25m';
                    break;

                case '13t_super25m':
                case 't_super25m':
                    $indice .= '17';
                    $apelido = 't_super25m';
                    break;

                case '13t_fora4a5':
                case 't_fora4a5':
                    $indice .= '18';
                    $apelido = 't_fora4a5';
                    break;

                case '13t_fora6a14':
                case 't_fora6a14':
                    $indice .= '19';
                    $apelido = 't_fora6a14';
                    break;

                case '13i_freq_prop':
                case 'i_freq_prop':
                    $indice .= '20';
                    $apelido = 'i_freq_prop';
                    break;

                case '13t_des18m':
                case 't_des18m':
                    $indice .= '21';
                    $apelido = 't_des18m';
                    break;

                case '13trabcc':
                case 'trabcc':
                    $indice .= '22';
                    $apelido = 'trabcc';
                    break;

                case '13trabsc':
                case 'trabsc':
                    $indice .= '23';
                    $apelido = 'trabsc';
                    break;

                case '13pmpob':
                case 'pmpob':
                    $indice .= '24';
                    $apelido = 'pmpob';
                    break;

                case '13pind':
                case 'pind':
                    $indice .= '25';
                    $apelido = 'pind';
                    break;

                case '13ppob':
                case 'ppob':
                    $indice .= '26';
                    $apelido = 'ppob';
                    break;

                case '13gini':
                case 'gini':
                    $indice .= '27';
                    $apelido = 'gini';
                    break;
                
                case '13rdpc':
                case 'rdpc':
                    $indice .= '28';
                    $apelido = 'rdpc';
                    break;

                case '13rpob':
                case 'rpob':
                    $indice .= '29';
                    $apelido = 'rpob';
                    break;

                case '13rmpob':
                case 'rmpob':
                    $indice .= '30';
                    $apelido = 'rmpob';
                    break;

                case '13rind':
                case 'rind':
                    $indice .= '31';
                    $apelido = 'rind';
                    break;

                case '13t_mulchefefif014':
                case 't_mulchefefif014':
                    $indice .= '32';
                    $apelido = 't_mulchefefif014';
                    break;

                case '13t_agua':
                case 't_agua':
                    $indice .= '33';
                    $apelido = 't_agua';
                    break;

                case '13agua_esgoto':
                case 'agua_esgoto':
                    $indice .= '34';
                    $apelido = 'agua_esgoto';
                    break;

                case '13t_sluz':
                case 't_sluz':
                    $indice .= '35';
                    $apelido = 't_sluz';
                    break;

                case '13t_luz':
                case 't_luz':
                    $indice .= '36';
                    $apelido = 't_luz';
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