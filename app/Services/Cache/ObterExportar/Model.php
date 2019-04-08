<?php

namespace App\Services\Cache\ObterExportar;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $chave = array(
		'apelidos'		=> ['chave', 'tx_chave', 'key', 'tx_key', 'hash', 'tx_hash'],
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