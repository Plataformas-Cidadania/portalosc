<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class ParticipacaoSocialDao extends DaoPostgres{
    public function obterParticipacaoSocial($modelo){
		$resultado = array();
		
    	$conferencias = $this->obterParticipacaoSocialConferencia($modelo);
    	$naoPossuiConferencia = $this->verificarNaoPossuiConferencia($conferencias);
		
    	if($conferencias == null || $naoPossuiConferencia){
    		$resultado = array_merge($resultado, ["conferencia" => null]);
    	}else{
			$resultado = array_merge($resultado, ["conferencia" => $conferencias]);
    	}
		
		$conselhos = $this->obterParticipacaoSocialConselho($modelo);
    	$naoPossuiConselho = $this->verificarNaoPossuiConselho($conselhos);
		
    	if($conselhos == null || $naoPossuiConselho){
    		$resultado = array_merge($resultado, ["conselho" => null]);
    	}else{
			$resultado = array_merge($resultado, ["conselho" => $conselhos]);
    	}
		
		$outras = $this->obterParticipacaoSocialOutra($modelo);
    	$naoPossuiOutra = $this->verificarNaoPossuiOutra($outras);
		
    	if($outras == null || $naoPossuiOutra){
    		$resultado = array_merge($resultado, ["outra" => null]);
    	}else{
			$resultado = array_merge($resultado, ["outra" => $outras]);
    	}
    	
    	$resultado = array_merge($resultado, ["bo_nao_possui_participacao_social_conferencia" => $naoPossuiConferencia, "bo_nao_possui_participacao_social_conselho" => $naoPossuiConselho, "bo_nao_possui_participacao_social_outra" => $naoPossuiOutra]);
    	
        if(count($resultado) == 0){
            $resultado = null;
		}
		
        return $resultado;
    }
	
	public function obterParticipacaoSocialConferencia($modelo){
		$query = 'SELECT * FROM portal.obter_osc_participacao_social_conferencia(?::TEXT)';
    	$resultado = $this->executarQuery($query, false, [$modelo->id_osc]);
    	
		return $resultado;
	}

	private function verificarNaoPossuiConferencia($conferencias){
		$resultado = false;
		
		foreach($conferencias as $key => $value){
			if($value->cd_conferencia == 133){
				$resultado = true;
				break;
			}
		}
		
		return $resultado;
	}
	
	public function obterParticipacaoSocialConselho($modelo){
		$query = 'SELECT * FROM portal.obter_osc_participacao_social_conselho(?::TEXT)';
    	$resultadoConselho = $this->executarQuery($query, false, [$modelo->id_osc]);
    	
		foreach($resultadoConselho as $key => $conselho){
			$query = "SELECT * FROM portal.obter_osc_representante_conselho(?::TEXT);";
			$resultadoRepresentanteConselho = $this->executarQuery($query, false, [$conselho->id_conselho]);
			
			if($resultadoRepresentanteConselho){
				$conselho->representante = $resultadoRepresentanteConselho;
			}
		}

		return $resultadoConselho;
	}

	private function verificarNaoPossuiConselho($conselhos){
		$resultado = false;
		
		foreach($conselhos as $key => $value){
			if($value->cd_conselho == 105){
				$resultado = true;
				break;
			}
		}
		
		return $resultado;
	}
	
	public function obterParticipacaoSocialOutra($modelo){
		$query = 'SELECT * FROM portal.obter_osc_participacao_social_outra(?::TEXT)';
    	$resultado = $this->executarQuery($query, false, [$modelo->id_osc]);
    	
		return $resultado;
	}

	private function verificarNaoPossuiOutra($outras){
		$resultado = false;
		
		foreach($outras as $key => $value){
			if($value->bo_nao_possui){
				$resultado = true;
				break;
			}
		}
		
		return $resultado;
	}

    public function editarParticipacaoSocial($identificador, $modelo){
    	$fonte = 'Representante de OSC';
		$tipoIdentificador = 'id_osc';
		$json = json_encode($modelo);
		$nullValido = true;
		$deleteValido = true;
    	$erroLog = true;
		$idCarga = null;
		$tipoBusca = 2;
		
		$query = 'SELECT * FROM portal.atualizar_participacao_social_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER, ?::INTEGER)';
		$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $deleteValido, $erroLog, $idCarga, $tipoBusca];
		$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
    }
}