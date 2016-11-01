<?php

namespace App\Dao;

use App\Dao\Dao;

class MenuDao extends Dao
{
	private $queriesOsc = array(
		/* Estrutura: nome_componente => [query_sql, is_unique] */
		"classe_atividade_economica" => ["SELECT * FROM syst.dc_classe_atividade_economica;", false],
		"subclasse_atividade_economica" => ["SELECT * FROM syst.dc_situacao_imovel;", false],
		"certificado" => ["SELECT * FROM syst.dc_certificado;", false],
		"conselho" => ["SELECT * FROM syst.dc_conselho;", false],
		"natureza_juridica" => ["SELECT * FROM syst.dc_natureza_juridica;", false],
		"situacao_imovel" => ["SELECT * FROM syst.dc_situacao_imovel;", false],
		"tipo_participacao" => ["SELECT * FROM syst.dc_tipo_participacao;", false],
		"abrangencia_projeto" => ["SELECT * FROM syst.dc_abrangencia_projeto;", false],
		"fonte_recursos_projeto" => ["SELECT * FROM syst.dc_fonte_recursos;", false],
		"zona_atuacao_projeto" => ["SELECT * FROM syst.dc_zona_atuacao_projeto;", false]
	);

	private $queriesRegion = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
        "municipio" => ["SELECT * FROM portal.obter_menu_municipio(?::TEXT);", false],
        "estado" => ["SELECT * FROM portal.obter_menu_estado(?::TEXT);", false],
        "regiao" => ["SELECT * FROM portal.obter_menu_regiao(?::TEXT);", false]
    );

    public function getMenuOsc($menu)
    {
        if(array_key_exists($menu, $this->queriesOsc)){
            $query_info = $this->queriesOsc[$menu];
            $query = $query_info[0];
            $unique = $query_info[1];
			
            $result = $this->executeQuery($query, $unique, null);
        }else{
            $result = null;
        }
        return $result;
    }

    public function getMenuRegion($region, $param)
    {
        if(array_key_exists($region, $this->queriesRegion)){
            $query_info = $this->queriesRegion[$region];
            $query = $query_info[0];
            $unique = $query_info[1];
			
            $result = $this->executeQuery($query, $unique, [$param]);
        }else{
            $result = null;
        }
        return $result;
    }
}
