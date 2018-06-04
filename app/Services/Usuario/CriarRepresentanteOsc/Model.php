<?php

namespace App\Services\Usuario\CriarRepresentanteOsc;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $email = array(
		'apelidos'		=> ['email', 'emailUsuario', 'email_usuario', 'tx_email_usuario'],
		'obrigatorio'	=> true,
		'tipo'			=> 'email'
	);
	
	private $senha = array(
		'apelidos'		=> ['senha', 'senhaUsuario', 'senha_usuario', 'tx_senha_usuario'],
		'obrigatorio'	=> false,
		'tipo'			=> 'senha'
	);
	
	private $nome = array(
		'apelidos'		=> ['nome', 'nomeUsuario', 'nome_usuario', 'tx_nome_usuario'],
		'obrigatorio'	=> true,
		'tipo'			=> 'string'
	);
	
	private $cpf = array(
		'apelidos'		=> ['cpf', 'cpfUsuario', 'cpf_usuario', 'nr_cpf_usuario'],
		'obrigatorio'	=> true,
		'tipo'			=> 'cpf'
	);
	
	private $listaEmail = array(
		'apelidos'		=> ['listaEmail', 'lista_email', 'bo_lista_email'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);
	
	private $representacao = array(
		'apelidos'		=> ['representacao', 'cd_oscs_representante'],
		'obrigatorio'	=> true,
		//'tipo'		=> 'arrayInteger'
		'tipo'			=> 'integer'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}