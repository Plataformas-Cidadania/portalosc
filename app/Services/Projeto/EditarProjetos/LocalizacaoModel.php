<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class LocalizacaoModel extends BaseModel{
	private $id_localizacao_projeto = array(
		'apelidos'		=> ['idLocalizacaoProjeto', 'localizacao_projeto', 'id_localizacao_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
	private $id_localizacao = array(
		'apelidos'		=> ['idLocalizacao', 'localizacao', 'id_localizacao'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
    );
    
	private $tx_nome_regiao_localizacao_projeto = array(
		'apelidos'		=> ['regiao', 'nomeRegiao', 'nome_regiao', 'nomeRegiaoLocalizacao', 'nome_regiao_localizacao', 'nomeRegiaoLocalizacaoProjeto', 'nome_regiao_localizacao_projeto', 'regiao', 'txNomeRegiao', 'tx_nome_regiao', 'txNomeRegiaoLocalizacao', 'tx_nome_regiao_localizacao', 'txNomeRegiaoLocalizacaoProjeto', 'tx_nome_regiao_localizacao_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'string'
	);
    
	private $bo_localizacao_prioritaria = array(
		'apelidos'		=> ['prioritaria', 'localizacaoPrioritaria', 'localizacao_prioritaria', 'bo_localizacao_prioritaria'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}