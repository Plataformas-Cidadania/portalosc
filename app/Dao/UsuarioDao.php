<?php

namespace App\Dao;

use App\Dao\Dao;

class UsuarioDao extends Dao
{
    public function login($requisicao)
    {
        $query = 'SELECT tb_usuario.id_usuario, tb_usuario.cd_tipo_usuario, tb_usuario.tx_nome_usuario,
        				tb_usuario.cd_municipio, tb_usuario.cd_uf, tb_usuario.bo_ativo
					FROM portal.tb_usuario
					WHERE tx_email_usuario = ?::TEXT AND tx_senha_usuario = ?::TEXT;';
        $params = [$requisicao->tx_email_usuario, $requisicao->tx_senha_usuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteOsc($requisicao)
    {
        $representacao = '{' . implode(",", $requisicao->representacao) . '}';
        
        $query = 'SELECT * FROM portal.inserir_representante_osc(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?::INTEGER[], ?::TEXT);';
        $params = [$requisicao->tx_email_usuario, $requisicao->tx_senha_usuario, $requisicao->tx_nome_usuario, 
            $requisicao->nr_cpf_usuario, $requisicao->bo_lista_email, $representacao, $requisicao->token];
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteGovernoMunicipio($requisicao)
    {
        $query = 'SELECT * FROM portal.inserir_representante_governo_municipio(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::INTEGER, ?::BOOLEAN, ?::TEXT);';
        $params = [$requisicao->cd_tipo_usuario, $requisicao->tx_email_usuario, $requisicao->tx_senha_usuario, $requisicao->tx_nome_usuario, 
            $requisicao->nr_cpf_usuario, $requisicao->cd_municipio, $requisicao->bo_lista_email, $requisicao->token];
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteGovernoEstado($requisicao)
    {
        $query = 'SELECT * FROM portal.inserir_representante_governo_estado(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::INTEGER, ?::BOOLEAN, ?::TEXT);';
        $params = [$requisicao->cd_tipo_usuario, $requisicao->tx_email_usuario, $requisicao->tx_senha_usuario, $requisicao->tx_nome_usuario, 
            $requisicao->nr_cpf_usuario, $requisicao->cd_uf, $requisicao->bo_lista_email, $requisicao->token];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterIdOscsDeRepresentante($requisicao)
    {
        $query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
        $params = [$requisicao->id_usuario];
        return $this->executarQuery($query, false, $params);
    }
    
    public function obterCpfUsuario($requisicao)
    {
        $query = 'SELECT tb_usuario.nr_cpf_usuario 
					FROM portal.tb_usuario 
					WHERE id_usuario = ?::INTEGER;';
        $params = [$requisicao->id_usuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterUsuario($requisicao)
    {
        $query = 'SELECT tb_usuario.id_usuario, tb_usuario.cd_tipo_usuario, tb_usuario.tx_email_usuario,
						tb_usuario.tx_nome_usuario, tb_usuario.nr_cpf_usuario, tb_usuario.bo_lista_email,
        				tb_usuario.cd_municipio, tb_usuario.cd_uf, tb_usuario.bo_ativo
					FROM portal.tb_usuario
					WHERE id_usuario = ?::INTEGER;';
        $params = [$requisicao->id_usuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function editarRepresentanteOsc($requisicao)
    {
        $representacao_insert = '{' . implode(",", $requisicao->representacao_insert) . '}';
        $representacao_delete = '{' . implode(",", $requisicao->representacao_delete) . '}';
    	
    	$query = 'SELECT * FROM portal.editar_representante_osc(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?, ?);';
    	$params = [$requisicao->id_usuario, $requisicao->tx_email_usuario, $requisicao->tx_senha_usuario, 
    	    $requisicao->tx_nome_usuario, $representacao_insert, $representacao_delete];
    	return $this->executarQuery($query, true, $params);
    }
}
