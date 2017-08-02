<?php

namespace App\Dao;

use App\Dao\Dao;

class UsuarioDao extends Dao
{
    public function __construct($requisicao = null)
    {
        $this->setRequisicao($requisicao);
    }
    
    public function login()
    {
        $query = 'SELECT tb_usuario.id_usuario, tb_usuario.cd_tipo_usuario, tb_usuario.tx_nome_usuario,
        				tb_usuario.cd_municipio, tb_usuario.cd_uf, tb_usuario.bo_ativo
					FROM portal.tb_usuario
					WHERE tx_email_usuario = ?::TEXT AND tx_senha_usuario = ?::TEXT;';
        $params = [$this->requisicao->tx_email_usuario, $this->requisicao->tx_senha_usuario];
        $this->resposta = $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteOsc()
    {
        $this->requisicao->representacao = '{' . implode(",", $this->requisicao->representacao) . '}';
        
        $query = 'SELECT * FROM portal.inserir_representante_osc(?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::BOOLEAN, ?::INTEGER[], ?::TEXT);';
        $params = [$this->requisicao->tx_email_usuario, $this->requisicao->tx_senha_usuario, $this->requisicao->tx_nome_usuario, 
            $this->requisicao->nr_cpf_usuario, $this->requisicao->bo_lista_email, $this->requisicao->representacao, 
            $this->requisicao->token];
        $this->resposta = $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteGovernoMunicipio()
    {
        $query = 'SELECT * FROM portal.inserir_representante_governo_municipio(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::INTEGER, ?::BOOLEAN, ?::TEXT);';
        $params = [$this->requisicao->cd_tipo_usuario, $this->requisicao->tx_email_usuario, $this->requisicao->tx_senha_usuario, 
            $this->requisicao->tx_nome_usuario, $this->requisicao->nr_cpf_usuario, $this->requisicao->cd_municipio, 
            $this->requisicao->bo_lista_email, $this->requisicao->token];
        $this->resposta = $this->executarQuery($query, true, $params);
    }
    
    public function criarRepresentanteGovernoEstado()
    {
        $query = 'SELECT * FROM portal.inserir_representante_governo_estado(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::NUMERIC(11, 0), ?::INTEGER, ?::BOOLEAN, ?::TEXT);';
        $params = [$this->requisicao->cd_tipo_usuario, $this->requisicao->tx_email_usuario, $this->requisicao->tx_senha_usuario,
            $this->requisicao->tx_nome_usuario, $this->requisicao->nr_cpf_usuario, $this->requisicao->cd_uf,
            $this->requisicao->bo_lista_email, $this->requisicao->token];
        $this->resposta = $this->executarQuery($query, true, $params);
    }
    
    public function obterIdOscsDeRepresentante()
    {
        $query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
        $params = [$this->requisicao->id_usuario];
        $this->resposta = $this->executarQuery($query, false, $params);
    }
    
    public function obterUsuario()
    {
        $query = 'SELECT tb_usuario.id_usuario, tb_usuario.cd_tipo_usuario, tb_usuario.tx_email_usuario,
						tb_usuario.tx_nome_usuario, tb_usuario.nr_cpf_usuario, tb_usuario.bo_lista_email,
        				tb_usuario.cd_municipio, tb_usuario.cd_uf, tb_usuario.bo_ativo
					FROM portal.tb_usuario
					WHERE id_usuario = ?::INTEGER;';
        $params = [$this->requisicao->id_usuario];
        $this->resposta = $this->executarQuery($query, true, $params);
    }
    
    public function editarRepresentanteOsc()
    {
    	$representacao = array();
    	foreach($requisicao->representacao as $value) {
    		array_push($representacao, intval($value['id_osc']));
    	}
    	$this->resposta->representacao = '{'.implode(',', $representacao).'}';
    	
    	$query = 'SELECT * FROM portal.atualizar_representante(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?);';
    	$params = [$this->requisicao->id_usuario, $this->requisicao->tx_nome_usuario, 
    	    $this->requisicao->tx_email_usuario, $this->requisicao->tx_senha_usuario, 
    	    $this->requisicao->representacao];
    	$this->resposta = $this->executarQuery($query, true, $params);
    	
    	if($result_query->status && $result_query->nova_representacao){
    		$nova_representacao = array();
    		foreach(explode(',', substr($result_query->nova_representacao, 1, -1)) as $id_osc){
    			array_push($nova_representacao, ['id_osc' => $id_osc]);
    		};
    		$this->resposta->nova_representacao = $nova_representacao;
    	}
    }
}
