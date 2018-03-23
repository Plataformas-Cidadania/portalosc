<?php

namespace App\Models\Osc;

use App\Models\Model;

class ProjetosOscModel extends Model
{
	private $id_osc = array(
			'apelidos'		=> ['id_osc', 'idOsc', 'osc'],
			'obrigatorio'	=> true,
			'tipo'			=> 'integer'
    );
    
	private $bo_nao_possui_projeto = array(
			'apelidos'		=> ['bo_nao_possui_projeto', 'bo_nao_possui', 'nao_possui', 'naoPossui'],
			'obrigatorio'	=> true,
			'tipo'			=> 'boolean'
	);
    
	private $projeto = array(
			'apelidos'		=> ['projeto', 'projetos'],
			'obrigatorio'	=> false,
			'tipo'			=> 'arrayObject',
			'modelo'		=> 'App\Models\Projeto\ProjetoModel'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}