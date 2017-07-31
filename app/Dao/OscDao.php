<?php

namespace App\Dao;

use App\Dao\Dao;

class OscDao extends Dao
{
    public function obterIdNomeOsc($requisicao)
    {
        $result = array();
        
        $query = 'SELECT 
        			vw_osc_dados_gerais.id_osc, 
        			COALESCE(vw_osc_dados_gerais.tx_nome_fantasia_osc, vw_osc_dados_gerais.tx_razao_social_osc) AS tx_nome_osc 
        		FROM 
        			portal.vw_osc_dados_gerais 
                WHERE id_osc = ?::INTEGER;';
        
        $params = [$requisicao->id_osc];
        $resposta = $this->executarQuery($query, true, $params);
        
        return $resposta;
    }
}
