<?php

namespace App\Services\Usuario\EditarRepresentanteOsc;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $id_usuario = array(
		'apelidos'		=> ['id_usuario', 'idUsuario', 'id', 'usuario'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);
	
	private $tx_email_usuario = array(
		'apelidos'		=>  ['tx_email_usuario', 'email_usuario', 'emailUsuario', 'email'],
		'obrigatorio'	=> true,
		'tipo'			=> 'email'
	);
	
	private $tx_senha_usuario = array(
		'apelidos'		=> ['tx_senha_usuario', 'senha_usuario', 'senhaUsuario', 'senha'],
		'obrigatorio'	=> false,
		'tipo'			=> 'string'
	);
	
	private $tx_nome_usuario = array(
		'apelidos'		=> ['tx_nome_usuario', 'nome_usuario', 'nomeUsuario', 'nome'],
		'obrigatorio'	=> true,
		'tipo'			=> 'string'
	);
	
	private $representacao = array(
		'apelidos'		=> ['representacao', 'cd_oscs_representante'],
		'obrigatorio'	=> true,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Usuario\EditarRepresentanteOsc\OscModel'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}