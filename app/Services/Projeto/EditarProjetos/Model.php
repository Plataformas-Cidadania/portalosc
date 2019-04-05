<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $id_osc = array(
		'apelidos'		=> ['id_osc', 'idOsc', 'id', 'osc'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
    );
    
	private $bo_nao_possui_projeto = array(
		'apelidos'		=> ['bo_nao_possui_projeto', 'bo_nao_possui_projetos', 'bo_nao_possui', 'nao_possui', 'naoPossui'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);
    
	private $projetos = array(
		'apelidos'		=> ['projeto', 'projetos'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Projeto\EditarProjetos\ProjetoModel',
		'default'		=> []
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}