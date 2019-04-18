<?php

namespace App\Services\Busca\BuscaComum;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $recurso = array(
		'apelidos'		=> ['recurso', 'recursoBusca', 'recurso_busca'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'string'
	);

	private $tipoResultado = array(
		'apelidos'		=> ['tipoResultado', 'tipo_resultado'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'string'
	);
	
	private $parametro = array(
		'apelidos'		=> ['parametro', 'param'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'string'
	);
	
	private $limite = array(
		'apelidos'		=> ['limite', 'limit'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'integer'
	);
	
	private $deslocamento = array(
		'apelidos'		=> ['deslocamento', 'offset'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'integer'
	);
	
	private $tipoBusca = array(
		'apelidos'		=> ['tipoBusca', 'tipoBusca', 'tipo'], 
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