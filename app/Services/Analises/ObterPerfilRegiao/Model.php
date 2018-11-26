<?php

namespace App\Services\Analises\ObterPerfilRegiao;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $id = array(
		'apelidos'		=> ['id', 'id_grafico', 'idGrafico'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'text'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}