<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class OscParceiraModel extends BaseModel{
	private $id_osc_parceira_projeto = array(
		'apelidos'		=> ['oscParceira', 'osc_parceira', 'id_osc_parceira', 'id_osc_parceira_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
    );
    
	private $id_osc = array(
		'apelidos'		=> ['osc', 'id_osc'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);
    
	private $id_projeto = array(
		'apelidos'		=> ['projeto', 'id_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}