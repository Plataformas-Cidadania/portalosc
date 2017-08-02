<?php

namespace App\Dao;

use App\Dao\Dao;

class OscDao extends Dao
{
    public function obterIdNomeOscs()
    {
        $this->requisicao->representacao = '{' . implode(",", $this->requisicao->representacao) . '}';
        
        $query = 'SELECT 
            			vw_osc_dados_gerais.id_osc, 
            			COALESCE(vw_osc_dados_gerais.tx_nome_fantasia_osc, vw_osc_dados_gerais.tx_razao_social_osc) AS tx_nome_osc 
            		FROM 
            			portal.vw_osc_dados_gerais 
                    WHERE id_osc = ANY (?);';
        
        $params = [$this->requisicao->representacao];
        $this->resposta = $this->executarQuery($query, false, $params);
    }
    
    public function obterNomeEmailOscs()
    {
        $representacao = '{' . implode(",", $this->requisicao->representacao) . '}';
        
        $query = 'SELECT  
            			COALESCE(vw_osc_dados_gerais.tx_nome_fantasia_osc, vw_osc_dados_gerais.tx_razao_social_osc) AS tx_nome_osc, 
        				vw_osc_dados_gerais.tx_email 
            		FROM 
            			portal.vw_osc_dados_gerais 
                    WHERE id_osc = ANY (?);';
        
        $params = [$representacao];
        $this->resposta = $this->executarQuery($query, false, $params);
    }
}
