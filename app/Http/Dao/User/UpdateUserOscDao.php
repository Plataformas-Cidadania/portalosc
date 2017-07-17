<?php

namespace App\Http\Dao\User;

use App\Http\Dao\Dao;

class UpdateUserOscDao extends Dao
{
	private function getCpfUser($id_usuario){
		$query = 'SELECT nr_cpf_usuario FROM portal.obter_representante(?::INTEGER);';
		$params = [$id_usuario];
		$resultQuery = $this->executeQuery($query, true, $params);
		return $resultQuery;
	}
	
	private function getDataOsc($id_osc){
		$query = 'SELECT tx_razao_social_osc, tx_email FROM portal.vw_osc_dados_gerais WHERE id_osc = ?::INTEGER;';
		$params = [$id_osc];
		$resultQuery = $this->executeQuery($query, true, $params);
		return $resultQuery;
	}
	
	public function execute($object)
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
		
		$resultQuery = $this->getCpfUser($object['id_usuario']);
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
}