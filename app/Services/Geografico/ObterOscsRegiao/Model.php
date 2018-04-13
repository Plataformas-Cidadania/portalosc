<?php

namespace App\Services\Geografico\ObterOscsRegiao;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $tipo_regiao = array(
		'apelidos' 		=> ['tipo_regiao', 'tipoRegiao', 'tipo'], 
		'obrigatorio' 	=> true, 
		'tipo' 			=> 'integer'
	);

	private $id_regiao = array(
		'apelidos' 		=> ['id_regiao', 'idRegiao', 'id'], 
		'obrigatorio' 	=> true, 
		'tipo'			=> 'integer'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);

    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}