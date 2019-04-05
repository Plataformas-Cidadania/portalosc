<?php

namespace App\Services\Geografico\ObterNomeLocalidade;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $tipo_regiao = array(
		'apelidos'		=> ['tipo_regiao', 'tipoRegiao', 'tipo'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'string', 
		'default'		=> ''
	);

	private $latitude = array(
		'apelidos' => ['latitude', 'lat'], 
		'obrigatorio' => false, 
		'tipo' => 'integer', 
		'default' => 0
	);

	private $longitude = array(
		'apelidos' => ['longitude', 'long', 'lon', 'lng'], 
		'obrigatorio' => false, 
		'tipo' => 'integer', 
		'default' => 0
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);

    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}