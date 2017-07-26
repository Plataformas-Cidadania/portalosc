<?php

namespace App\Components\Usuario\DAO;

use App\Components\DAO\DAO;

class LoginDAO extends DAO
{
	public function execute($object)
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
		$result = $this->executeQuery($query, true, $params);

		if($result){
			$representacao = ['representacao' => null];
			if($result['cd_tipo_usuario'] == 2){
				$query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
				$params = [$result['id_usuario']];
				$resultRepresentacao = $this->executeQuery($query, false, $params);

				$stringRepresentacao = '';
				foreach($resultRepresentacao as $value){
					$stringRepresentacao = $stringRepresentacao.$value->id_osc.',';
				}
				$stringRepresentacao = '[' . rtrim($stringRepresentacao, ",") . ']';

				$result = array_merge($result, ['representacao' => $stringRepresentacao]);
			}
		}

		return $result;
	}
}
