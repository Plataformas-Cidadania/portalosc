<?php

namespace App\Dao\Usuario;

use App\Dao\DaoPostgres;

class LoginDao extends DaoPostgres
{
    public function login($usuario)
    {
    	$query = 'SELECT * FROM portal.logar_usuario(?::TEXT, ?::TEXT);';
        $params = [$usuario->email, $usuario->senha];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterIdOscsDeRepresentante($idUsuario)
    {
        $query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
        $params = [$idUsuario];
        return $this->executarQuery($query, false, $params);
    }
}