<?php

namespace App\Dao\Usuario;

use App\Dao\DaoPostgres;

class UsuarioDao extends DaoPostgres
{
    public function criarRepresentanteOsc($representanteOsc)
    {
        $query = 'SELECT * FROM portal.inserir_representante_osc(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?::INTEGER[], ?::TEXT);';
        
        $representacao = '{' . implode(",", $representanteOsc->representacao) . '}';
        
        $params = array(
        		$representanteOsc->email,
        		$representanteOsc->senha,
        		$representanteOsc->nome,
        		$representanteOsc->cpf,
        		$representanteOsc->listaEmail,
        		$representacao,
        		$representanteOsc->token
        );
        
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteGovernoMunicipio($usuario)
    {
        $query = 'SELECT * FROM portal.inserir_representante_governo_municipio(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::INTEGER, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::TEXT);';
        $params = [$usuario->cd_tipo_usuario, $usuario->tx_email_usuario, $usuario->tx_senha_usuario, $usuario->tx_nome_usuario, $usuario->nr_cpf_usuario, $usuario->tx_telefone_1, $usuario->tx_telefone_2, $usuario->tx_orgao_usuario, 
            $usuario->tx_dado_institucional, $usuario->tx_email_confirmacao, $usuario->cd_municipio, $usuario->bo_lista_email, $usuario->bo_lista_atualizacao_anual, $usuario->bo_lista_atualizacao_trimestral, $usuario->token];
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteGovernoEstado($usuario)
    {
        $query = 'SELECT * FROM portal.inserir_representante_governo_estado(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::INTEGER, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::TEXT);';
        $params = [$usuario->cd_tipo_usuario, $usuario->tx_email_usuario, $usuario->tx_senha_usuario, $usuario->tx_nome_usuario, $usuario->nr_cpf_usuario, $usuario->tx_telefone_1, $usuario->tx_telefone_2, $usuario->tx_orgao_usuario, 
            $usuario->tx_dado_institucional, $usuario->tx_email_confirmacao, $usuario->cd_uf, $usuario->bo_lista_email, $usuario->bo_lista_atualizacao_anual, $usuario->bo_lista_atualizacao_trimestral, $usuario->token];
        return $this->executarQuery($query, true, $params);
    }
    
    public function criarAssinanteNewsletter($assinante)
    {
        $query = 'SELECT * FROM portal.inserir_assinante_newsletter(?::TEXT, ?::TEXT);';
        $params = [$assinante->tx_email_usuario, $assinante->tx_nome_usuario];
        return $result = $this->executarQuery($query, true, $params);
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
        $query = 'SELECT tb_usuario.id_usuario, tb_usuario.cd_tipo_usuario, tb_usuario.tx_nome_usuario, tb_usuario.tx_email_usuario, 
						tb_usuario.nr_cpf_usuario, tb_usuario.tx_orgao_trabalha, tb_usuario.tx_telefone_1, tb_usuario.tx_telefone_2, 
        				tb_usuario.tx_dado_institucional, tb_usuario.tx_email_confirmacao, tb_usuario.bo_lista_email, 
        				tb_usuario.bo_lista_atualizacao_trimestral, tb_usuario.cd_municipio, tb_usuario.cd_uf, tb_usuario.bo_ativo 
					FROM portal.tb_usuario
					WHERE id_usuario = ?::INTEGER;';
        $params = [$idUsuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function verificarRepresentanteGovernoAtivo($localidade)
    {
        $query = 'SELECT EXISTS(SELECT tb_usuario.id_usuario
					FROM portal.tb_usuario
					WHERE (cd_municipio = ?::INTEGER OR cd_uf = ?::INTEGER) AND bo_ativo = true) AS resultado;';
        $params = [$localidade, $localidade];
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
        $query = 'SELECT * FROM portal.editar_representante_governo(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::TEXT, ?::BOOLEAN, ?::BOOLEAN);';
        $params = [$usuario->id_usuario, $usuario->tx_email_usuario, $usuario->tx_senha_usuario, $usuario->tx_nome_usuario, $usuario->tx_telefone_1, $usuario->tx_telefone_2, 
            $usuario->tx_orgao_usuario, $usuario->tx_dado_institucional, $usuario->bo_lista_email, $usuario->bo_lista_atualizacao_trimestral];
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
        $query = 'SELECT cd_tipo_usuario, tx_email_usuario, tx_nome_usuario, nr_cpf_usuario FROM portal.tb_usuario WHERE id_usuario = ?::INTEGER;';
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
    
    public function confirmarEmailUsuario($idUsuario)
    {
        $query = 'SELECT * FROM portal.confirmar_email_usuario(?::INTEGER);';
        $params = [$idUsuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function desativarUsuario($idUsuario)
    {
        $query = 'SELECT * FROM portal.desativar_usuario(?::INTEGER);';
        $params = [$idUsuario];
        return $this->executarQuery($query, true, $params);
    }
    
    public function obterIdOscsDeRepresentante($idUsuario)
    {
        $query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
        $params = [$idUsuario];
        return $this->executarQuery($query, false, $params);
    }
    
    public function obterTokenIp($ip, $token)
    {
        $query = 'SELECT * FROM portal.obter_token_ip(?::TEXT, ?::TEXT)';
        $params = [$ip, $token];
        return $this->executarQuery($query, true, $params);
    }
    
    public function verificarAcessoIp($ip)
    {
        $query = 'SELECT * FROM portal.verificar_acesso_ip(?::TEXT)';
        $params = [$ip];
        return $this->executarQuery($query, true, $params);
    }
}
