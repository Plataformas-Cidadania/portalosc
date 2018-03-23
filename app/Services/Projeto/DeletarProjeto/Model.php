<?php

namespace App\Services\Projeto\DeletarProjeto;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $id_projeto = array(
		'apelidos'		=> ['id_projeto', 'idProjeto'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);

	private $id_osc = array(
		'apelidos'		=> ['id_osc', 'idOsc'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'integer'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}