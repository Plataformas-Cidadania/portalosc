<?php

namespace App\Models\Osc;

use App\Models\Model;

class ObjetivoMetaModel extends Model
{
	/*
	private $id = array(
			'apelidos'		=> ['id', 'idOsc', 'id_osc'],
			'obrigatorio'	=> true,
			'tipo'			=> 'integer'
	);
	*/
	private $cd_meta_osc = array(
			'apelidos'		=> ['meta', 'metaOsc', 'meta_osc', 'cdMetaOsc', 'cd_meta_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'integer'
	);

    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->confiturarModelo($modelo);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}