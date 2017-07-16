<?php

namespace App\Http\Dao\User;

use App\Http\Dao\Dao;

class LoginDao extends Dao
{
	public function loginUser($object)
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
		$result_query = $this->execute($query, true, $params);
		
		if($result_query){
			foreach($result_query as $key => $value){
				$result = array_merge($result, [$key => $value]);
			}
			
			$representacao = ['representacao' => null];
			if($result_query->cd_tipo_usuario == 2){
				$query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
				$result_query = $this->execute($query, false, [$result['id_usuario']]);
				
				$string_representacao = '';
				foreach($result_query as $value){
					$string_representacao = $string_representacao.$value->id_osc.',';
				}
				$string_representacao = rtrim($string_representacao, ",");
				$representacao = ['representacao' => $string_representacao];
			}
			$result = array_merge($result, $representacao);
		}
		
		return $result;
	}
}