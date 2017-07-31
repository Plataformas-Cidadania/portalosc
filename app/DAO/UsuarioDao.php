<?php

namespace App\Dao;

use App\Dao\Dao;

class UsuarioDao extends Dao
{
    public function login($requisicao)
    {
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
        
        $params = [$requisicao->tx_email_usuario, $requisicao->tx_senha_usuario];
        $resposta = $this->executarQuery($query, true, $params);
        
        return $resposta;
    }
    
    public function carregarRepresentacaoUsuario($requisicao)
    {
        $query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
        
        $params = [$requisicao->id_usuario];
        $resposta = $this->executarQuery($query, false, $params);
        
        return $resposta;
    }
}
