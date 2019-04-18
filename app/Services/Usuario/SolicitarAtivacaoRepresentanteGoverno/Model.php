<?php

namespace App\Services\Usuario\SolicitarAtivacaoRepresentanteGoverno;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $tx_token = array(
		'apelidos'		=> ['tx_token', 'token'],
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