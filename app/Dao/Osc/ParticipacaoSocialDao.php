<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class ParticipacaoSocialDao extends DaoPostgres{
    public function obterParticipacaoSocial($modelo){
		$result = array();
		
		$param = $modelo->id_osc;

    	$query = "SELECT
					id_conferencia,
					cd_conferencia,
					tx_nome_conferencia,
					null AS tx_nome_conferencia_outro,
					ft_conferencia,
					dt_ano_realizacao,
					ft_ano_realizacao,
					cd_forma_participacao_conferencia,
					tx_nome_forma_participacao_conferencia,
					ft_forma_participacao_conferencia
				FROM
					portal.vw_osc_participacao_social_conferencia
				WHERE
					id_osc::TEXT = ?::TEXT AND cd_conferencia <> 132
    			OR
    				tx_apelido_osc = ?::TEXT
				UNION
				SELECT
					id_conferencia_outra AS id_conferencia,
					132 AS cd_conferencia,
					'Outra Conferência' AS tx_nome_conferencia,
					tx_nome_conferencia AS tx_nome_conferencia_outro,
					ft_nome_conferencia AS ft_conferencia,
					dt_ano_realizacao,
					ft_ano_realizacao,
					cd_forma_participacao_conferencia,
					tx_nome_forma_participacao_conferencia,
					ft_forma_participacao_conferencia
				FROM
					portal.vw_osc_participacao_social_conferencia_outra
				WHERE
					id_osc::TEXT = ?::TEXT
    			OR
    				tx_apelido_osc = ?::TEXT;";
    	$result_query = $this->executarQuery($query, false, [$param, $param, $param, $param]);
    	
    	$nao_possui_conf = null;
    	$json_conf = array();
		
    	if($result_query){
    		foreach($result_query as $key => $value){
    			$cd_conferencia = $value->cd_conferencia;
    			if($cd_conferencia == 133){
    				$nao_possui_conf = true;
    			}else{
    				array_push($json_conf, $result_query[$key]);
    			}
    		}
			
    		if(count($json_conf) == 0){
    			$result = array_merge($result, ["conferencia" => null]);
    		}else{
    			$nao_possui_conf = false;
    			$result = array_merge($result, ["conferencia" => $json_conf]);
    		}
    	}else{
    		$result = array_merge($result, ["conferencia" => null]);
    	}
		
    	$query = 'SELECT * FROM portal.obter_osc_participacao_social_conselho(?::TEXT)';
    	$result_query_conselho = $this->executarQuery($query, false, [$param]);
    	
    	$nao_possui_cons = null;
    	$json_cons = array();
    	
    	if($result_query_conselho){
    		$result_partial = array();
    		
    		foreach($result_query_conselho as $key => $value){
    			$cd_conselho = $value->cd_conselho;
    			if($cd_conselho == 105){
    				$nao_possui_cons = true;
    			}else{
    				array_push($json_cons, $result_query_conselho[$key]);
    			}
    		}
    		
    		if(count($json_cons) == 0){
    			$result = array_merge($result, ["conselho" => null]);
    		}else{
	    		foreach($json_cons as $key => $conselho){
	    			$result_conselho = array();
	    			$result_conselho = array_merge($result_conselho, ["conselho" => $conselho]);
	    			$query = "SELECT * FROM portal.obter_osc_representante_conselho(?::TEXT);";
	    			$result_query_representante = $this->executarQuery($query, false, [$conselho->id_conselho]);
	    			if($result_query_representante){
	    				$result_conselho = array_merge($result_conselho, ["representante" => $result_query_representante]);
	    			}
	    			$result_partial = array_merge($result_partial, [$key => $result_conselho]);
	    		}
	    		$nao_possui_cons = false;
	    		$result = array_merge($result, ['conselho' => $result_partial]);
    		}
    	}else{
    		$result = array_merge($result, ["conselho" => null]);
    	}
		
    	$query = "SELECT * FROM portal.obter_osc_participacao_social_outra(?::TEXT);";
	    $result_query = $this->executarQuery($query, false, [$param]);
	    
	    $nao_possui_outra = null;
	    $json_outra = array();
	    
	    if($result_query){
	    	foreach($result_query as $key => $value){
	    		$nao_possui_outra = $value->bo_nao_possui;
	    		if(!$nao_possui_outra){
	    			array_push($json_outra, $result_query[$key]);
	    		}
	    	}
			
	    	if(count($json_outra) == 0){
	    		$result = array_merge($result, ["outra" => null]);
	    	}else{
	    		$nao_possui_outra = false;
	    		$result = array_merge($result, ["outra" => $json_outra]);
	    	}
	    }else{
	    	$result = array_merge($result, ["outra" => null]);
	    }
    	
    	if($result){
    		$result = array_merge($result, ["bo_nao_possui_conferencias" => $nao_possui_conf,
    										"bo_nao_possui_conselhos" => $nao_possui_cons,
    										"bo_nao_possui_outros_part" => $nao_possui_outra]);
    	}
    	
        if(count($result) == 0){
            return null;
        }else{
            return $result;
        }
    }
	
    public function editarParticipacaoSocial($identificador, $modelo){
    	$fonte = 'Representante de OSC';
		$tipoIdentificador = 'id_osc';
    	$json = json_encode($modelo);
		$nullValido = true;
    	$erroLog = true;
		$idCarga = null;
		
		$query = 'SELECT * FROM portal.atualizar_participacao_social_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER)';
		$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $erroLog, $idCarga];
		$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
    }
}