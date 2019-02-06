<?php

namespace App\Services\Exportacao\ExportarBusca;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $id_oscs = array(
		'apelidos' => ['id', 'osc', 'oscs', 'id_osc', 'id_oscs'],
		'obrigatorio' => true,
		'tipo' => 'arrayInteger'
	);

	private $adicionais = array(
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