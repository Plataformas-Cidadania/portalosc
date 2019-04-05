<?php

namespace App\Services\Geografico\ObterOscsArea;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $norte = array(
		'apelidos'		=> ['norte'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'double'
	);

	private $sul = array(
		'apelidos'		=> ['sul'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'double'
	);

	private $leste = array(
		'apelidos'		=> ['leste'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'double'
	);

	private $oeste = array(
		'apelidos'		=> ['oeste'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'double'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);

    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}