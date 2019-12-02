<?php

namespace App\Services\Osc\EditarParticipacaoSocial;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $id_osc = array(
		'apelidos'		=> ['osc', 'idOsc', 'id_osc'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);

	private $bo_nao_possui_conferencia = array(
		'apelidos'		=> ['naoPossuiConferencia', 'nao_possui_conferencia', 'bo_nao_possui_conferencia', 'bo_nao_possui_conferencias'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);

	private $bo_nao_possui_conselho = array(
		'apelidos'		=> ['naoPossuiConselho', 'nao_possui_conselho', 'bo_nao_possui_conselho', 'bo_nao_possui_conselhos'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);

	private $bo_nao_possui_outra = array(
		'apelidos'		=> ['naoPossuiOutra', 'nao_possui_outra', 'bo_nao_possui_outra', 'bo_nao_possui_outras', 'bo_nao_possui_outros_part'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);

	private $conferencia = array(
		'apelidos'		=> ['conferencia', 'conferencias', 'participacaoSocialConferencia', 'participacao_social_conferencia'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Osc\EditarParticipacaoSocial\ParticipacaoSocialConferenciaModel',
		'default'		=> null
	);

	private $conselho = array(
		'apelidos'		=> ['conselho', 'conselhos', 'participacaoSocialConselho', 'participacao_social_conselho'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Osc\EditarParticipacaoSocial\ParticipacaoSocialConselhoModel',
		'default'		=> null
	);

	private $outra = array(
		'apelidos'		=> ['outra', 'outras', 'participacaoSocialOutra', 'participacao_social_outra'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Osc\EditarParticipacaoSocial\ParticipacaoSocialOutraModel',
		'default'		=> null
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}