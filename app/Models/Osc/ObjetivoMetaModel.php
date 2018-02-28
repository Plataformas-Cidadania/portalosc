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
	private $meta = array(
			'apelidos'		=> ['meta', 'metaOsc', 'meta_osc', 'cdMetaOsc', 'cd_meta_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $objetivo = array(
			'apelidos'		=> ['objetivo', 'objetivoOsc', 'objetivo_osc', 'cdobjetivoOsc', 'cd_objetivo_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);

    	$this->setEstrutura($estrutura);
    	$this->setRequisicao($requisicao);
    	$this->prepararModel();
    }
}
