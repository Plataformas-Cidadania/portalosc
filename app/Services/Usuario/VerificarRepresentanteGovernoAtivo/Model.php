<?php

namespace App\Services\Usuario\VerificarRepresentanteGovernoAtivo;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $cd_localidade = array(
		'apelidos'		=> ['cd_localidade', 'localidade'],
		'obrigatorio'	=> true,
		'tipo'			=> 'localidade'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}