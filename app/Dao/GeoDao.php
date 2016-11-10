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
				$result = $this->executeQuery($query, true, [$id]);
        return $result;
    }

		private function configResultGeo($result){
			$json = [[]];

			for ($i = 0; $i<count($result); $i++) {
				//print_r($result[$i]->geo_lat);
					$json[$result[$i]->id_osc][0] = $result[$i]->geo_lat;//lat
					$json[$result[$i]->id_osc][1] = $result[$i]->geo_lng;//lng
			}

			return $json;
		}

	public function getOscRegion($region, $id)
	{
        if(array_key_exists($region, $this->queriesRegion)){
        	$query_info = $this->queriesRegion[$region];
	    	$query = $query_info[0];
	    	$unique = $query_info[1];
	    	if(($region == 'regiao' && intval($id) <= 5) || ($region == 'estado' && intval($id) <= 53) || ($region == 'municipio' && strlen($id) <= 7)){
        		$result = $this->executeQuery($query, $unique, [$id]);
	    	}else{
	    		$result = null;
	    	}
        }
        return $result;
    }

    public function getOscCountry()
	{
	    	$query = "SELECT * FROM portal.obter_geo_osc_pais();";
        $result = $this->executeQuery($query, false, null);

        return $this->configResultGeo($result);
    }

	public function getClusterRegion($region, $id)
	{
		if($region == 'regiao'){
			$query = "SELECT
						vw_geo_osc.cd_regiao,
						vw_geo_osc.tx_nome_regiao,
						count(*) AS nr_quantidade_osc
					FROM portal.vw_geo_osc
					GROUP BY vw_geo_osc.cd_regiao, tx_nome_regiao;";
		}else{
			if($id){
				if ($region == 'estado') {
					$query = "SELECT
								vw_geo_osc.cd_estado,
								vw_geo_osc.tx_nome_estado,
								vw_geo_osc.tx_sigla_estado,
								count(*) AS nr_quantidade_osc
							FROM portal.vw_geo_osc
							WHERE vw_geo_osc.cd_regiao = " . $id . "
							GROUP BY vw_geo_osc.cd_estado, tx_nome_estado, tx_sigla_estado;";
				}elseif ($region == 'municipio') {
					$query = "SELECT
								vw_geo_osc.cd_municipio,
								vw_geo_osc.tx_nome_municipio,
								count(*) AS nr_quantidade_osc
							FROM portal.vw_geo_osc
							WHERE vw_geo_osc.cd_estado = " . $id . "
							GROUP BY vw_geo_osc.cd_municipio, tx_nome_municipio;";
				}
			}else{
				if ($region == 'estado') {
					$query = "SELECT
								vw_geo_osc.cd_estado,
								vw_geo_osc.tx_nome_estado,
								vw_geo_osc.tx_sigla_estado,
								count(*) AS nr_quantidade_osc
							FROM portal.vw_geo_osc
							GROUP BY vw_geo_osc.cd_estado, tx_nome_estado, tx_sigla_estado;";
				}elseif ($region == 'municipio') {
					$query = "SELECT
								vw_geo_osc.cd_municipio,
								vw_geo_osc.tx_nome_municipio,
								count(*) AS nr_quantidade_osc
							FROM portal.vw_geo_osc
							GROUP BY vw_geo_osc.cd_municipio, tx_nome_municipio;";
				}
			}
		}
        $result = $this->executeQuery($query, false, null);
        return $result;
	}
}
