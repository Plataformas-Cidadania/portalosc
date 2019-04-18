<?php

namespace App\Services\Osc\EditarParticipacaoSocial;

use App\Services\BaseModel;

class RepresentanteConselhoModel extends BaseModel{
	private $tx_nome_representante_conselho = array(
		'apelidos'		=> ['nome', 'nomeRepresentanteConselho', 'nome_representante_conselho', 'tx_nome_representante_conselho', 'cd_fonte_recursos_osc'],
		'obrigatorio'	=> true,
		'tipo'			=> 'string'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}