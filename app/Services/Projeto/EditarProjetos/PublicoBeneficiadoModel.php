<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class PublicoBeneficiadoModel extends BaseModel{
	private $id_publico_beneficiado_projeto = array(
		'apelidos'		=> ['idPublicoBeneficiado', 'id_publico_beneficiado', 'id_publico_beneficiado_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
    );
    
	private $tx_nome_publico_beneficiado = array(
		'apelidos'		=> ['nomePublicoBeneficiado', 'nome_publico_beneficiado', 'tx_nome_publico_beneficiado'],
		'obrigatorio'	=> false,
		'tipo'			=> 'string'
	);
    
	private $nr_estimativa_pessoas_atendidas = array(
		'apelidos'		=> ['estimativaPessoasAtendidas', 'estimativa_pessoas_atendidas', 'nr_estimativa_pessoas_atendidas'],
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