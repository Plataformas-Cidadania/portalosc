<?php

namespace App\Models\Osc;

use App\Services\BaseModel;

class FonteRecursosOscModel extends BaseModel
{
	private $id_osc = array(
			'apelidos'		=> ['osc', 'idOsc', 'id_osc'],
			'obrigatorio'	=> true,
			'tipo'			=> 'integer'
	);

	private $fonte_recursos = array(
			'apelidos'		=> ['fonteRecursos', 'fonte_recursos', 'recursos', 'fonteRecursosOsc', 'fonte_recursos_osc', 'recursosOsc', 'recursos_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'arrayObject',
			'modelo'		=> 'App\Models\Osc\FonteRecursosAnualOscModel'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}