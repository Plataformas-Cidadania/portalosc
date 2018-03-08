<?php

namespace App\Models\Usuario;

use App\Models\Model;

class RepresentanteOscModel extends Model
{
	private $email = array(
			'apelidos'		=> ['email', 'emailUsuario', 'email_usuario', 'tx_email_usuario'],
			'obrigatorio'	=> true,
			'tipo'			=> 'email'
	);
	
	private $senha = array(
			'apelidos'		=> ['senha', 'senhaUsuario', 'senha_usuario', 'tx_senha_usuario'],
			'obrigatorio'	=> true,
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
			'obrigatorio'	=> true,
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
    	$modelo = get_object_vars($this);
    	
    	$this->confiturarModelo($modelo);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}