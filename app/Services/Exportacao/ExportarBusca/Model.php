<?php

namespace App\Services\Exportacao\ExportarBusca;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $chave = array(
		'apelidos' => ['chave', 'tx_chave', 'key', 'tx_key'],
		'obrigatorio' => true,
		'tipo' => 'string'
	);

	private $variaveisAdicionais = array(
		'apelidos' => ['adicionais', 'variaveis', 'variaveis_adicionais'],
		'obrigatorio' => false,
		'tipo' => 'array'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}