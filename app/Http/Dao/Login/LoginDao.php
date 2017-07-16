<?php

namespace App\Http\Dao\Login;

use App\Http\Dao\Dao;

class LoginDao extends Dao
{
	public function run($object)
	{
		$result = array();
		
		$query = 'SELECT tb_usuario.id_usuario,
						tb_usuario.cd_tipo_usuario,
						tb_usuario.tx_nome_usuario,
        				tb_usuario.cd_municipio,
        				tb_usuario.cd_uf,
						tb_usuario.bo_ativo
					FROM
						portal.tb_usuario
					WHERE
						tx_email_usuario = ?::TEXT AND
						tx_senha_usuario = ?::TEXT;';
		$params = [$object['tx_email_usuario'], sha1($object['tx_senha_usuario'])];
		$resultQuery= $this->execute($query, true, $params);
		
		if($resultQuery){
			foreach($resultQuery as $key => $value){
				$result = array_merge($result, [$key => $value]);
			}
			
			$representacao = ['representacao' => null];
			if($resultQuery->cd_tipo_usuario == 2){
				$query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
				$resultQuery = $this->execute($query, false, [$result['id_usuario']]);
				
				$stringRepresentacao = '';
				foreach($resultQuery as $value){
					$stringRepresentacao = $stringRepresentacao.$value->id_osc.',';
				}
				$stringRepresentacao = rtrim($stringRepresentacao, ",");
				$representacao = ['representacao' => $stringRepresentacao];
			}
			$result = array_merge($result, $representacao);
		}
		
		return $result;
	}
}