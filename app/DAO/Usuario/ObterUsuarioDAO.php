<?php

namespace App\DAO\Usuario;

use App\DAO\DAO;

class ObterUsuarioDAO extends DAO
{
	private function buscarOSCsDe($id_usuario)
	{
		$result = array();
		
		$query = 'SELECT * FROM portal.obter_representacao(?::INTEGER);';
		$params = [$id_usuario];
		$result = $this->executeQuery($query, false, $params);
		
		return $result;
	}
	
	private function buscarMunicipioPor($cd_municipio)
	{
		$result = array();
		
		$query = 'SELECT * FROM spat.ed_municipio WHERE edmu_cd_municipio == ?::NUMERIC;';
		$params = [$cd_municipio];
		$result = $this->executeQuery($query, false, $params);
		
		return $result;
	}
	
	private function buscarEstadoPor($cd_uf)
	{
		$result = array();
		
		$query = 'SELECT * FROM spat.ed_municipio WHERE ed_uf == ?::NUMERIC;';
		$params = [$cd_uf];
		$result = $this->executeQuery($query, false, $params);
		
		return $result;
	}
	
	public function executar($object)
	{
		$result = array();
		
		$query = 'SELECT * FROM portal.obter_representante(?::INTEGER);';
		$params = [$object['id_usuario']];
		$resultQuery = (array) $this->executeQuery($query, true, $params);
		
		if($resultQuery){
			if($object['cd_tipo_usuario'] == 2){
				$representacao = $this->searchOsc($object['id_usuario']);
				$result = array_merge($resultQuery, ['representacao' => $representacao]);
			}else if($object['cd_tipo_usuario'] == 3){
				$localidade = $this->searchCity($object['id_usuario']);
				$result = array_merge($resultQuery, ['localidade' => $localidade]);
			}else if($object['cd_tipo_usuario'] == 4){
				$localidade = $this->searchState($object['id_usuario']);
				$result = array_merge($resultQuery, ['localidade' => $localidade]);
			}
		}
		
		return $result;
	}
}