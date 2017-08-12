<?php

namespace App\Dao;

use App\Dao\Dao;

class UsuarioDao extends Dao
{
    public function login($usuario)
    {
        $query = 'SELECT tb_usuario.id_usuario, tb_usuario.cd_tipo_usuario, tb_usuario.tx_nome_usuario,
        				tb_usuario.cd_municipio, tb_usuario.cd_uf, tb_usuario.bo_ativo
					FROM portal.tb_usuario
					WHERE tx_email_usuario = ?::TEXT AND tx_senha_usuario = ?::TEXT;';
        $params = [$usuario->tx_email_usuario, $usuario->tx_senha_usuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteOsc($usuario)
    {
        $representacao = '{' . implode(",", $usuario->representacao) . '}';
        
        $query = 'SELECT * FROM portal.inserir_representante_osc(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?::INTEGER[], ?::TEXT);';
        $params = [$usuario->tx_email_usuario, $usuario->tx_senha_usuario, $usuario->tx_nome_usuario, 
            $usuario->nr_cpf_usuario, $usuario->bo_lista_email, $representacao, $usuario->token];
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteGovernoMunicipio($usuario)
    {
        $query = 'SELECT * FROM portal.inserir_representante_governo_municipio(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::INTEGER, ?::BOOLEAN, ?::TEXT);';
        $params = [$usuario->cd_tipo_usuario, $usuario->tx_email_usuario, $usuario->tx_senha_usuario, $usuario->tx_nome_usuario, 
            $usuario->nr_cpf_usuario, $usuario->cd_municipio, $usuario->bo_lista_email, $usuario->token];
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteGovernoEstado($usuario)
    {
        $query = 'SELECT * FROM portal.inserir_representante_governo_estado(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::INTEGER, ?::BOOLEAN, ?::TEXT);';
        $params = [$usuario->cd_tipo_usuario, $usuario->tx_email_usuario, $usuario->tx_senha_usuario, $usuario->tx_nome_usuario, 
            $usuario->nr_cpf_usuario, $usuario->cd_uf, $usuario->bo_lista_email, $usuario->token];
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarAssinanteNewsletter($assinante)
    {
        $query = 'SELECT * FROM portal.inserir_assinante_newsletter(?::TEXT, ?::TEXT);';
        $params = [$assinante->tx_email_usuario, $assinante->tx_nome_usuario];
        return $result = $this->executarQuery($query, true, $params);
    }
    
    public function obterIdOscsDeRepresentante($idUsuario)
    {
        $query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
        $params = [$idUsuario];
        return $this->executarQuery($query, false, $params);
    }
    
    public function obterCpfUsuario($idUsuario)
    {
        $query = 'SELECT tb_usuario.nr_cpf_usuario 
					FROM portal.tb_usuario 
					WHERE id_usuario = ?::INTEGER;';
        $params = [$idUsuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterUsuario($idUsuario)
    {
        $query = 'SELECT tb_usuario.id_usuario, tb_usuario.cd_tipo_usuario, tb_usuario.tx_email_usuario,
						tb_usuario.tx_nome_usuario, tb_usuario.nr_cpf_usuario, tb_usuario.bo_lista_email,
        				tb_usuario.cd_municipio, tb_usuario.cd_uf, tb_usuario.bo_ativo
					FROM portal.tb_usuario
					WHERE id_usuario = ?::INTEGER;';
        $params = [$idUsuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function editarRepresentanteOsc($usuario, $oscsInsert, $oscsDelete)
    {
        $oscsInsert = '{' . implode(",", $oscsInsert) . '}';
        $oscsDelete = '{' . implode(",", $oscsDelete) . '}';
    	
    	$query = 'SELECT * FROM portal.editar_representante_osc(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?, ?);';
    	$params = [$usuario->id_usuario, $usuario->tx_email_usuario, $usuario->tx_senha_usuario, 
    	    $usuario->tx_nome_usuario, $oscsInsert, $oscsDelete];
    	return $this->executarQuery($query, true, $params);
    }
    
    public function editarRepresentanteGoverno($usuario)
    {
        $query = 'SELECT * FROM portal.editar_representante_governo(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT);';
        $params = [$usuario->id_usuario, $usuario->tx_email_usuario, $usuario->tx_senha_usuario, $usuario->tx_nome_usuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterUsuarioParaTrocaSenha($emailUsuario)
    {
        $query = 'SELECT id_usuario, nr_cpf_usuario, tx_nome_usuario, bo_ativo FROM portal.tb_usuario WHERE tx_email_usuario = ?::TEXT;';
        $params = [$emailUsuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterUsuarioParaAtivacao($idUsuario)
    {
        $query = 'SELECT cd_tipo_usuario, tx_email_usuario, tx_nome_usuario FROM portal.tb_usuario WHERE id_usuario = ?::INTEGER;';
        $params = [$idUsuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarTokenUsuario($id_usuario, $token, $dataExpiracaoToken)
    {
        $query = 'SELECT * FROM portal.inserir_token_usuario(?::INTEGER, ?::TEXT, ?::DATE);';
        $params = [$id_usuario, $token, $dataExpiracaoToken];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterDadosToken($token)
    {
        $query = 'SELECT id_token, id_usuario, dt_data_expiracao_token FROM portal.tb_token WHERE tx_token = ?::TEXT;';
        $params = [$token];
        return $this->executarQuery($query, true, $params);
    }
    
    public function alterarSenhaUsuario($usuario)
    {
        $query = 'SELECT * FROM portal.alterar_senha_usuario(?::INTEGER, ?::TEXT);';
        $params = [$usuario->id_usuario, $usuario->tx_senha_usuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function excluirTokenUsuario($idToken)
    {
        $query = 'SELECT * FROM portal.excluir_token_usuario(?::INTEGER);';
        $params = [$idToken];
        return $this->executarQuery($query, true, $params);
    }
    
    public function ativarRepresentanteOsc($idUsuario)
    {
        $query = 'SELECT * FROM portal.ativar_representante_osc(?::INTEGER);';
        $params = [$idUsuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function ativarRepresentanteGoverno($idUsuario)
    {
        $query = 'SELECT * FROM portal.ativar_representante_governo(?::INTEGER);';
        $params = [$idUsuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function desativarUsuario($idUsuario)
    {
        $query = 'SELECT * FROM portal.desativar_usuario(?::INTEGER);';
        $params = [$idUsuario];
        return $this->executarQuery($query, true, $params);
    }
}
