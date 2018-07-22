<?php

namespace App\Services\Osc\EditarParticipacaoSocial;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $id_osc = array(
		'apelidos'		=> ['osc', 'idOsc', 'id_osc'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);

	private $conselho = array(
		'apelidos'		=> ['conselho', 'conselhos', 'participacaoSocialConselho', 'participacao_social_conselho'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Osc\EditarRecursos\ParticipacaoSocialConselhoModel'
	);

	private $conferencia = array(
		'apelidos'		=> ['conferencia', 'conferencias', 'participacaoSocialConferencia', 'participacao_social_conferencia'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Osc\EditarRecursos\ParticipacaoSocialConferenciaModel'
	);

	private $outra = array(
		'apelidos'		=> ['outra', 'outras', 'participacaoSocialOutra', 'participacao_social_outra'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Osc\EditarRecursos\ParticipacaoSocialOutraModel'
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}