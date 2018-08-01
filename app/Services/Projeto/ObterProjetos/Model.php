<?php

namespace App\Services\Projeto\ObterProjetos;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $id = array(
		'apelidos'		=> ['id_osc', 'idOsc', 'osc', 'id_projeto', 'idProjeto', 'projeto'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);

	private $tipo_identificador = array(
		'apelidos'		=> ['tipoIdentificador', 'tipo_identificador'],
		'obrigatorio'	=> false,
		'tipo'			=> 'string',
		'default'		=> 'id_osc'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}