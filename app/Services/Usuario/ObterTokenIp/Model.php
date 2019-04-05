<?php

namespace App\Services\Usuario\ObterTokenIp;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $ip = array(
		'apelidos'		=> ['ip'],
		'obrigatorio'	=> true,
		'tipo'			=> 'string'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}