<?php

namespace App\Services\Osc\EditarRecursos;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $id_osc = array(
		'apelidos'		=> ['osc', 'idOsc', 'id_osc'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);

	private $dt_ano_recursos_osc = array(
		'apelidos'		=> ['ano', 'anoRecursos', 'ano_recursos', 'anoRecursosOsc', 'dt_ano_recursos_osc'],
		'obrigatorio'	=> true,
		'tipo'			=> 'date'
	);
	
	private $bo_nao_possui = array(
		'apelidos'		=> ['naoPossui', 'nao_possui', 'bo_nao_possui'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);
	
	private $bo_nao_possui_recursos_proprios = array(
		'apelidos'		=> ['naoPossuiRecursosProprios', 'nao_possui_recursos_proprios', 'bo_nao_possui_recursos_proprios'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);
	
	private $bo_nao_possui_recursos_publicos = array(
		'apelidos'		=> ['naoPossuiRecursosPublicos', 'nao_possui_recursos_publicos', 'bo_nao_possui_recursos_publicos'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);
	
	private $bo_nao_possui_recursos_privados = array(
		'apelidos'		=> ['naoPossuiRecursosPrivados', 'nao_possui_recursos_privados', 'bo_nao_possui_recursos_privados'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);
	
	private $bo_nao_possui_recursos_nao_financeiros = array(
		'apelidos'		=> ['naoPossuiRecursosNaoFinanceiros', 'nao_possui_recursos_nao_financeiros', 'bo_nao_possui_recursos_nao_financeiros'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);

	private $recursos = array(
		'apelidos'		=> ['fonteRecursos', 'fonte_recursos', 'recursos', 'fonteRecursosOsc', 'fonte_recursos_osc', 'recursosOsc', 'recursos_osc'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Osc\EditarRecursos\RecursosOscModel'
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}