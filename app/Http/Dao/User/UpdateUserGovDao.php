<?php

namespace App\Http\Dao\User;

use App\Http\Dao\Dao;

class UpdateUserGovDao extends Dao
{	
	public function run($object)
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