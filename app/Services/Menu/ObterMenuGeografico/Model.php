<?php

namespace App\Services\Menu\ObterMenuGeografico;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $tipo_regiao = array(
		'apelidos' => ['tipo_regiao', 'tipoRegiao', 'tipo'], 
		'obrigatorio' => true, 
		'tipo' => 'string'
	);

	private $parametro = array(
		'apelidos' => ['parametro', 'param'], 
		'obrigatorio' => true, 
		'tipo' => 'string'
	);

	private $limit = array(
		'apelidos' => ['limit', 'limite'], 
		'obrigatorio' => true, 
		'tipo' => 'string'
	);

	private $offset = array(
		'apelidos' => ['offset'], 
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