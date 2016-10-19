<?php

namespace App\Dao;

use App\Dao\Dao;

class DictionaryDao extends Dao{
	public $queriesOsc = array(
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

	public $queriesRegion = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
        "municipio" => ["SELECT * FROM portal.obter_dicionario_municipio(?::TEXT);", false],
        "estado" => ["SELECT * FROM portal.obter_dicionario_estado(?::TEXT);", false],
        "regiao" => ["SELECT * FROM portal.obter_dicionario_regiao(?::TEXT);", false]
    );

    public function getDictionaryOsc($dictionary){
        if(array_key_exists($dictionary, $this->queriesOsc)){
            $query_info = $this->queriesOsc[$dictionary];
            $query = $query_info[0];
            $unique = $query_info[1];

            $result = json_decode($this->executeQuery($query, $unique, null));
        }else{
            $result = null;
        }
        return $result;
    }

    public function getDictionaryRegion($region, $param){
        if(array_key_exists($region, $this->queriesRegion)){
            $query_info = $this->queriesRegion[$region];
            $query = $query_info[0];
            $unique = $query_info[1];

            $result = json_decode($this->executeQuery($query, $unique, [$param]));
        }else{
            $result = null;
        }
        return $result;
    }
}
