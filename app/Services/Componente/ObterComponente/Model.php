<?php

namespace App\Services\Componente\ObterComponente;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $componente = array(
		'apelidos' => ['componente'], 
		'obrigatorio' => true, 
		'tipo' => 'string'
	);

	private $parametro = array(
		'apelidos' => ['parametro', 'param'], 
		'obrigatorio' => true, 
		'tipo' => 'string'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}