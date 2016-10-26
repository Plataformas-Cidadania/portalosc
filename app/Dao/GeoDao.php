<?php

namespace App\Dao;

use App\Dao\Dao;

class GeoDao extends Dao
{
	private $queriesRegion = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
        "municipio" => ["SELECT * FROM portal.obter_geo_osc_municipio(?::NUMERIC);", false],
        "estado" => ["SELECT * FROM portal.obter_geo_osc_estado(?::SMALLINT);", false],
        "regiao" => ["SELECT * FROM portal.obter_geo_osc_regiao(?::SMALLINT);", false]
    );

    public function getOsc($id)
	{
	    $query = "SELECT * FROM portal.obter_geo_osc(?::INTEGER);";
        $result = json_decode($this->executeQuery($query, true, [$id]));
        return $result;
    }

	public function getOscRegion($region, $id)
	{
        if(array_key_exists($region, $this->queriesRegion)){
        	$query_info = $this->queriesRegion[$region];
	    	$query = $query_info[0];
	    	$unique = $query_info[1];
	    	if(($region == 'regiao' && intval($id) <= 5) || ($region == 'estado' && intval($id) <= 53) || ($region == 'municipio' && strlen($id) <= 7)){
        		$result = json_decode($this->executeQuery($query, $unique, [$id]));
	    	}else{
	    		$result = null;
	    	}
        }
        return $result;
    }

    public function getOscCountry()
	{
	    $query = "SELECT * FROM portal.obter_geo_osc_pais();";
        $result = json_decode($this->executeQuery($query, false, null));
        return $result;
    }

	public function getClusterRegion($region, $id)
	{
		if($id){
			if($region == 'regiao'){
			    $query = "SELECT count(*) FROM osc.tb_localizacao GROUP BY ;";
			}elseif ($region == 'estado') {
				$query = "SELECT
					(SELECT eduf_cd_uf FROM spat.ed_uf WHERE eduf_cd_uf = (SELECT eduf_cd_uf FROM spat.ed_municipio WHERE edmu_cd_municipio = cd_municipio)) AS tx_nome_municipio,
					(SELECT eduf_nm_uf FROM spat.ed_uf WHERE eduf_cd_uf = (SELECT eduf_cd_uf FROM spat.ed_municipio WHERE edmu_cd_municipio = cd_municipio)) AS tx_nome_municipio,
					(SELECT eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf = (SELECT eduf_cd_uf FROM spat.ed_municipio WHERE edmu_cd_municipio = cd_municipio)) AS tx_uf,
					count(*) AS nr_quantidade_osc
				FROM osc.tb_localizacao
				WHERE tb_localizacao.cd_municipio
				IN (SELECT edmu_cd_municipio FROM spat.ed_municipio WHERE eduf_cd_uf = 33)
				GROUP BY tb_localizacao.cd_municipio;";
			}elseif ($region == 'municipio') {
				$query = "SELECT
					cd_municipio,
					(SELECT edmu_nm_municipio FROM spat.ed_municipio WHERE edmu_cd_municipio = cd_municipio) AS tx_nome_municipio,
					(SELECT eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf = (SELECT eduf_cd_uf FROM spat.ed_municipio WHERE edmu_cd_municipio = cd_municipio)) AS tx_uf,
					count(*) AS nr_quantidade_osc
				FROM osc.tb_localizacao
				WHERE tb_localizacao.cd_municipio
				IN (SELECT edmu_cd_municipio FROM spat.ed_municipio WHERE eduf_cd_uf = 33)
				GROUP BY tb_localizacao.cd_municipio;";
			}
		}
        $result = json_decode($this->executeQuery($query, false, null));
        return $result;
	}
}
