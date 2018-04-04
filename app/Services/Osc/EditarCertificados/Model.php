<?php

namespace App\Services\Osc\EditarCertificados;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $certificados = array(
		'apelidos'		=> ['certificado', 'certificados'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Osc\EditarCertificados\CertificadoModel'
	);

	private $bo_nao_possui_certificacoes = array(
		'apelidos'		=> ['bo_nao_possui_certificacoes', 'nao_possui_certificacoes', 'nao_possui_certificacoes', 'naoPossuiCertificacoes', 'nao_possui', 'naoPossui'],
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