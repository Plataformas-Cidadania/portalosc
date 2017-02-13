<?php

namespace App\Dao;

use App\Dao\Dao;

class MenuDao extends Dao
{
	private $queriesOsc = array(
		/* Estrutura: nome_componente => [query_sql, is_unique] */
		"area_atuacao" => ["SELECT * FROM syst.dc_area_atuacao ORDER BY cd_area_atuacao;", false],
		"subarea_atuacao" => ["SELECT * FROM syst.dc_subarea_atuacao;", false],
		"classe_atividade_economica" => ["SELECT * FROM syst.dc_classe_atividade_economica;", false],
		"subclasse_atividade_economica" => ["SELECT * FROM syst.dc_subclasse_atividade_economica;", false],
		"certificado" => ["SELECT * FROM syst.dc_certificado;", false],
		"conselho" => ["SELECT * FROM syst.dc_conselho;", false],
		"conferencia" => ["SELECT * FROM syst.dc_conferencia;", false],
		"natureza_juridica" => ["SELECT * FROM syst.dc_natureza_juridica;", false],
		"situacao_imovel" => ["SELECT * FROM syst.dc_situacao_imovel;", false],
		"tipo_participacao" => ["SELECT * FROM syst.dc_tipo_participacao;", false],
		"abrangencia_projeto" => ["SELECT * FROM syst.dc_abrangencia_projeto;", false],
		"origem_fonte_recursos_osc" => ["SELECT * FROM syst.dc_origem_fonte_recursos_osc;", false],
		"fonte_recursos_osc" => ["SELECT * FROM syst.dc_fonte_recursos_osc;", false],
		"origem_fonte_recursos_projeto" => ["SELECT * FROM syst.dc_origem_fonte_recursos_projeto;", false],
		"fonte_recursos_projeto" => ["SELECT * FROM syst.dc_fonte_recursos_projeto;", false],
		"zona_atuacao_projeto" => ["SELECT * FROM syst.dc_zona_atuacao_projeto;", false],
		"objetivo_projeto" => ["SELECT cd_objetivo_projeto, tx_codigo_objetivo_projeto || '. ' || tx_nome_objetivo_projeto AS tx_nome_objetivo_projeto FROM syst.dc_objetivo_projeto ORDER BY cd_objetivo_projeto;", false],
		"meta_projeto" => ["SELECT cd_meta_projeto, tx_codigo_meta_projeto || ' ' || tx_nome_meta_projeto AS tx_nome_meta_projeto FROM syst.dc_meta_projeto ORDER BY cd_meta_projeto;", false],
		"status_projeto" => ["SELECT * FROM syst.dc_status_projeto;", false]
	);

	private $queriesOscWithParam = array(
		"subarea_atuacao" => ["SELECT * FROM syst.dc_subarea_atuacao WHERE cd_area_atuacao = ?::INTEGER;", false],
		"subclasse_atividade_economica" => ["SELECT * FROM syst.dc_subclasse_atividade_economica WHERE cd_classe_atividade_economica = '?'::CHARACTER VARYING;", false],
		"meta_projeto" => ["SELECT cd_meta_projeto, tx_codigo_meta_projeto || ' ' || tx_nome_meta_projeto AS tx_nome_meta_projeto FROM syst.dc_meta_projeto WHERE cd_objetivo_projeto = ?::INTEGER ORDER BY cd_meta_projeto;", false],
		"fonte_recursos_osc" => ["SELECT * FROM syst.dc_fonte_recursos_osc WHERE cd_origem_fonte_recursos_osc = ?::INTEGER;", false],
		"fonte_recursos_projeto" => ["SELECT * FROM syst.dc_fonte_recursos_projeto WHERE cd_origem_fonte_recursos_projeto = ?::INTEGER;", false],
	);

	private $queriesRegion = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
        "municipio" => ["SELECT * FROM portal.obter_menu_municipio(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
        "estado" => ["SELECT * FROM portal.obter_menu_estado(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
        "regiao" => ["SELECT * FROM portal.obter_menu_regiao(?::TEXT, ?::INTEGER, ?::INTEGER);", false]
    );

    public function getMenuOsc($menu, $param = null)
    {
    	if($param && array_key_exists($menu, $this->queriesOscWithParam)){
            $query_info = $this->queriesOscWithParam[$menu];
            $query = $query_info[0];
            $unique = $query_info[1];

            $result = $this->executeQuery($query, $unique, [$param]);

    	}elseif(array_key_exists($menu, $this->queriesOsc)){
            $query_info = $this->queriesOsc[$menu];
            $query = $query_info[0];
            $unique = $query_info[1];

            $result = $this->executeQuery($query, $unique);

        }else{
            $result = null;
        }

        return $result;
    }

    public function getMenuRegion($region, $param, $limit, $offset)
    {
        if(array_key_exists($region, $this->queriesRegion)){
            $query_info = $this->queriesRegion[$region];
            $query = $query_info[0];
            $unique = $query_info[1];

            $result = $this->executeQuery($query, $unique, [$param, $limit, $offset]);
        }else{
            $result = null;
        }
        return $result;
    }
}
