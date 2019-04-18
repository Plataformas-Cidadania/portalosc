<?php

namespace App\Services\Menu\ObterMenuOsc;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $menu = array(
		'apelidos' => ['menu'], 
		'obrigatorio' => true, 
		'tipo' => 'string'
	);

	private $parametro = array(
		'apelidos' => ['parametro', 'param'], 
		'obrigatorio' => false, 
		'tipo' => 'string'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}