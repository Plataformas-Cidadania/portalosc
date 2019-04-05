<?php

namespace App\Services\Analises\ObterListaOscsAtualizadas;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $limit = array(
		'apelidos' => ['limite', 'limit', 'quantidade'], 
		'obrigatorio' => false, 
		'tipo' => 'integer'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}