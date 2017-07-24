<?php

namespace App\DAO\Usuario;

use App\DAO\DAO;

class ObterUsuarioDAO extends DAO
{	
	public function executar($object)
	{
	    $resultado = array();
		
		$query = 'SELECT * FROM portal.obter_representante(?::INTEGER);';
		$params = [$object->id_usuario];
		$resultado = $this->executeQuery($query, true, $params);
		
		return $resultado;
	}
}