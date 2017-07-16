<?php

namespace App\Http\Dao\User;

use App\Http\Dao\Dao;

class UpdateUserOscDao extends Dao
{	
	public function run($object)
	{
		$resultQuery = array();
		
		$listOsc = array();
		foreach($object['representacao'] as $key => $value) {
			array_push($listOsc, $value['id_osc']);
		}
		$object['representacao'] = '{'.implode(',', $listOsc).'}';
		
		$query = 'SELECT * FROM portal.atualizar_representante(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?);';
		$params = [$object['id_usuario'], $object['tx_email_usuario'], sha1($object['tx_senha_usuario']), $object['tx_nome_usuario'], $object['representacao']];
		$resultQuery = $this->execute($query, true, $params);
		
		$novaRepresentacao = array();
		if($resultQuery->nova_representacao){
			foreach(explode(',', substr($resultQuery->nova_representacao, 1, -1)) as $id_osc){
				$query = 'SELECT tx_razao_social_osc, tx_email FROM portal.vw_osc_dados_gerais WHERE id_osc = ?::INTEGER;';
				$params = [$id_osc];
				$result = $this->execute($query, true, $params);
				
				array_push($novaRepresentacao, ['id_osc' => $id_osc, 'tx_razao_social_osc' => $result->tx_razao_social_osc, 'tx_email' => $result->tx_email]);
			};
			$resultQuery->nova_representacao = $novaRepresentacao;
		}
		
		return $resultQuery;
	}
}