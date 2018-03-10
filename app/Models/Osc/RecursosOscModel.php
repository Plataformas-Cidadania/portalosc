<?php

namespace App\Models\Osc;

use App\Models\Model;

class RecursosOscModel extends Model
{
	private $cd_fonte_recursos_osc = array(
			'apelidos'		=> ['fonte', 'fonteRecursos', 'fonte_recursos', 'fonte_recursos_osc', 'cd_fonte_recursos_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'integer'
	);
	
	private $cd_origem_fonte_recursos_osc = array(
			'apelidos'		=> ['origem', 'origemFonteRecursos', 'origem_fonte_recursos', 'origemFonteRecursosOsc', 'origem_fonte_recursos_osc', 'cd_origem_fonte_recursos_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'integer'
	);
	
	private $nr_valor_recursos_osc = array(
			'apelidos'		=> ['valor', 'valorRecursos', 'valor_recursos', 'valorRecursosOsc', 'valor_recursos_osc', 'nr_valor_recursos_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'double'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}