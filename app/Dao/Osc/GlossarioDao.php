<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class GlossarioDao extends DaoPostgres{
    public function obterIdNomeOscs($representacao){
    	$representacao = '{' . implode(",", $representacao) . '}';
        
        $query = 'SELECT
            			vw_osc_dados_gerais.id_osc,
            			COALESCE(vw_osc_dados_gerais.tx_nome_fantasia_osc, vw_osc_dados_gerais.tx_razao_social_osc) AS tx_nome_osc
            		FROM
            			portal.vw_osc_dados_gerais
                    WHERE id_osc = ANY (?);';
        
        $params = [$representacao];
        return $this->executarQuery($query, false, $params);
    }
    
    public function obterNomeEmailOscs($representacao){
        $representacao = '{' . implode(",", $representacao) . '}';
        
        $query = 'SELECT
            			COALESCE(vw_osc_dados_gerais.tx_nome_fantasia_osc, vw_osc_dados_gerais.tx_razao_social_osc) AS tx_nome_osc,
        				vw_osc_dados_gerais.tx_email
            		FROM
            			portal.vw_osc_dados_gerais
                    WHERE id_osc = ANY (?);';
        
        $params = [$representacao];
        return $this->executarQuery($query, false, $params);
    }
}