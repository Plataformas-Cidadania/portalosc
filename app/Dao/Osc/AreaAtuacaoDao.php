<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class AreaAtuacaoDao extends DaoPostgres{
    public function obterAreaAtuacao($modelo){
        $result = array();
        
        $query = "SELECT * FROM portal.obter_osc_area_atuacao(?::TEXT);";
        $params = [$modelo->id_osc];
    	$result_query = $this->executarQuery($query, false, $params);
		
		if($result_query){
			$area_atuacao = array();
			foreach ($result_query as $key_query => $value_query) {
				$flag_insert = true;
				
				$area = array();
				if($value_query->cd_area_atuacao != 10){
					foreach($area_atuacao as $key_area => $value_area){
						if($value_area['cd_area_atuacao'] == $value_query->cd_area_atuacao){
							unset($area_atuacao[$key_area]);
							$area = $value_area;
							$flag_insert = false;
						}
					}
				}
				
				if($flag_insert){
					$area = array();
					$area['cd_area_atuacao'] = $value_query->cd_area_atuacao;
					$area['tx_nome_area_atuacao'] = $value_query->tx_nome_area_atuacao;
					$area['tx_nome_area_atuacao_outra'] = $value_query->tx_nome_area_atuacao_outra;
					$area['ft_area_atuacao'] = $value_query->ft_area_atuacao;
					$area['bo_oficial'] = $value_query->bo_oficial;
					
					if($value_query->cd_subarea_atuacao){
						$subarea = ['cd_subarea_atuacao' => $value_query->cd_subarea_atuacao, 'tx_nome_subarea_atuacao' => $value_query->tx_nome_subarea_atuacao, 'tx_nome_subarea_atuacao_outra' => $value_query->tx_nome_subarea_atuacao_outra, 'ft_subarea_atuacao' => $value_query->ft_area_atuacao, 'bo_oficial' => $value_query->bo_oficial];
						$area['subarea_atuacao'] = array($subarea);
					}else{
					    $area['subarea_atuacao'] = array();
					}
                    
					array_push($area_atuacao, $area);
				}else{
					$subarea = ['cd_subarea_atuacao' => $value_query->cd_subarea_atuacao, 'tx_nome_subarea_atuacao' => $value_query->tx_nome_subarea_atuacao, 'tx_nome_subarea_atuacao_outra' => $value_query->tx_nome_subarea_atuacao_outra, 'ft_subarea_atuacao' => $value_query->ft_area_atuacao, 'bo_oficial' => $value_query->bo_oficial];
					array_push($area['subarea_atuacao'], $subarea);
					
					array_push($area_atuacao, $area);
				}
			}
			
			$area_atuacao_adjusted = array();
			foreach($area_atuacao as $key => $value){
    			array_push($area_atuacao_adjusted, $value);
			}
			
			$result = array_merge($result, ["area_atuacao" => $area_atuacao_adjusted]);
    	}
		
        if(count($result) == 0){
            $result = null;
        }
        
        return $result;
    }
}