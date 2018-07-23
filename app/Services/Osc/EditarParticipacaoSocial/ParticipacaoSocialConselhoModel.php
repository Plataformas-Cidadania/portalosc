<?php

namespace App\Services\Osc\EditarParticipacaoSocial;

use App\Services\BaseModel;

class ParticipacaoSocialConselhoModel extends BaseModel{
	private $conselho = array(
		'apelidos'		=> ['conselho', 'conselhos'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Osc\EditarParticipacaoSocial\ConselhoModel'
	);

	private $representante = array(
		'apelidos'		=> ['representante', 'representantes'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Osc\EditarParticipacaoSocial\RepresentanteConselhoModel'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}