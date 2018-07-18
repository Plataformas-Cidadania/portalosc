<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class LocalizacaoModel extends BaseModel{
	private $id_localizacao = array(
		'apelidos'		=> ['id', 'idLocalizacao', 'id_localizacao'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
    );
    
	private $tx_nome_regiao_localizacao_projeto = array(
		'apelidos'		=> ['regiao', 'nomeRegiao', 'nome_regiao', 'nomeRegiaoLocalizacao', 'nome_regiao_localizacao', 'nomeRegiaoLocalizacaoProjeto', 'nome_regiao_localizacao_projeto', 'regiao', 'txNomeRegiao', 'tx_nome_regiao', 'txNomeRegiaoLocalizacao', 'tx_nome_regiao_localizacao', 'txNomeRegiaoLocalizacaoProjeto', 'tx_nome_regiao_localizacao_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'string'
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}