<?php

namespace App\Services\Osc\EditarDadosGerais;

use App\Services\BaseModel;

class ObjetivoMetaModel extends BaseModel{
	private $cd_meta_osc = array(
		'apelidos'		=> ['meta', 'metaOsc', 'meta_osc', 'cdMetaOsc', 'cd_meta_osc'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}