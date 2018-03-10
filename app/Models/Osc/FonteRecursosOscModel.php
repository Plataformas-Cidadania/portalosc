<?php

namespace App\Models\Osc;

use App\Models\Model;

class FonteRecursosOscModel extends Model
{	
	private $fonte_recursos = array(
			'apelidos'		=> ['fonteRecursos', 'fonte_recursos', 'recursos', 'fonteRecursosOsc', 'fonte_recursos_osc', 'recursosOsc', 'recursos_osc'],
			'obrigatorio'	=> true,
			'tipo'			=> 'arrayObject',
			'modelo'		=> 'fonteRecursosAnualOsc'
	);
	
    public function __construct($corpoRequisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarCorpoRequisicao($corpoRequisicao);
    	$this->analisarRequisicao();
    }
}