<?php

namespace App\Components\Usuario\DAO;

use App\Components\DAO;

class UsuarioDAO extends DAO
{	
	public function obterRepresentante($object)
	{
	    $resultado = array();
		
		$query = 'SELECT * FROM portal.obter_representante(?::INTEGER);';
		$params = [$object->id_usuario];
		$resultado = $this->executeQuery($query, true, $params);
		
		return $resultado;
	}
	
	public function editarRepresentanteOSC($object)
	{
		$result = array();
		
		$listOsc = array();
		foreach($object['representacao'] as $key => $value) {
			array_push($listOsc, $value['id_osc']);
		}
		$object['representacao'] = '{'.implode(',', $listOsc).'}';
		
		$query = 'SELECT * FROM portal.atualizar_representante(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?);';
		$params = [$object['id_usuario'], $object['tx_email_usuario'], sha1($object['tx_senha_usuario']), $object['tx_nome_usuario'], $object['representacao']];
		$result = $this->executeQuery($query, true, $params);
		
		$resultQuery = $this->obterUsuario($object);
		$result = array_merge($result, $resultQuery);
		
		if($result['nova_representacao']){
			$novaRepresentacao = array();
			foreach(explode(',', substr($result['nova_representacao'], 1, -1)) as $id_osc){
				$resultQuery = $this->getDataOsc($id_osc);
				array_push($novaRepresentacao, ['id_osc' => $id_osc, 'tx_razao_social_osc' => $resultQuery['tx_razao_social_osc'], 'tx_email' => $resultQuery['tx_email']]);
			};
			$result['nova_representacao'] = $novaRepresentacao;
		}
		
		return $result;
	}
	
	public function editarRepresentanteGoverno($object)
	{
		$resultQuery = array();
		/*
		$query = 'SELECT * FROM portal.atualizar_representante_governo(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::INTEGER);';
		$params = [$object['id_usuario'], $object['tx_email_usuario'], sha1($object['tx_senha_usuario']), $object['tx_nome_usuario'], $object['localidade']];
		$resultQuery = $this->execute($query, true, $params);
		*/
		return $resultQuery;
	}
}
