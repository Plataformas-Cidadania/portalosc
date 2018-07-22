<?php

namespace App\Services\Osc\EditarParticipacaoSocial;

use App\Services\BaseModel;

class ParticipacaoSocialOutraModel extends BaseModel{
	private $tx_nome_participacao_social_outra = array(
		'apelidos'		=> ['nome', 'nomeParticipacaoSocialOutra', 'nome_participacao_social_outra', 'tx_nome_participacao_social_outra'],
		'obrigatorio'	=> true,
		'tipo'			=> 'string'
	);

	private $bo_nao_possui = array(
		'apelidos'		=> ['naoPossui', 'nao_possui', 'bo_nao_possui'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}