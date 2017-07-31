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
        
        $params = [$requisicao['tx_email_usuario'], $requisicao['tx_senha_usuario']];
        $resposta = $this->executarQuery($query, true, $params);
        
        return $resposta;
    }
    
    public function obterIdOscsDeRepresentante($requisicao)
    {
        $query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
        
        $params = [$requisicao['id_usuario']];
        $resposta = $this->executarQuery($query, false, $params);
        
        return $resposta;
    }
    
    public function obterUsuario($requisicao)
    {
        $query = 'SELECT tb_usuario.id_usuario, tb_usuario.cd_tipo_usuario, tb_usuario.tx_email_usuario,
						tb_usuario.tx_nome_usuario, tb_usuario.nr_cpf_usuario, tb_usuario.bo_lista_email,
        				tb_usuario.cd_municipio, tb_usuario.cd_uf, tb_usuario.bo_ativo
					FROM portal.tb_usuario
					WHERE id_usuario = ?::INTEGER;';
        
        $params = [$requisicao->id_usuario];
        $resposta = $this->executarQuery($query, true, $params);
        
        return $resposta;
    }
    
    public function editarRepresentanteOsc($requisicao)
    {
    	$representacao = array();
    	foreach($requisicao['representacao'] as $value) {
    		array_push($representacao, intval($value['id_osc']));
    	}
    	$representacao = '{'.implode(',', $representacao).'}';
    	
    	$requisicao['representacao'] = $representacao;
    	
    	$query = 'SELECT * FROM portal.atualizar_representante(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?);';
    	$params = [$requisicao['id_usuario'], $requisicao['tx_nome_usuario'], $requisicao['tx_email_usuario'], $requisicao['tx_senha_usuario'], $requisicao['representacao']];
    	$resposta = $this->executarQuery($query, true, $params);
    	
    	if($result_query->status && $result_query->nova_representacao){
    		$nova_representacao = array();
    		foreach(explode(",", substr($result_query->nova_representacao, 1, -1)) as $id_osc){
    			array_push($nova_representacao, ["id_osc" => $id_osc]);
    		};
    		$resposta->nova_representacao = $nova_representacao;
    	}
    	
    	return $resposta;
    }
}
