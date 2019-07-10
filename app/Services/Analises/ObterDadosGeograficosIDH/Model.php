<?php

namespace App\Services\Analises\ObterDadosGeograficosIDH;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $id = array(
		'apelidos'		=> ['id', 'id_municipio', 'idMunicipio', 'municipio'],
		'obrigatorio'	=> true, 
		'tipo'			=> 'integer'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}