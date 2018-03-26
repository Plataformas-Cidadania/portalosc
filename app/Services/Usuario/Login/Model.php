<?php

namespace App\Services\Usuario\Login;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $tx_email_usuario = array(
		'apelidos'		=> ['tx_email_usuario', 'email_usuario', 'emailUsuario', 'email'],
		'obrigatorio'	=> true,
		'tipo'			=> 'email'
	);

	private $tx_senha_usuario = array(
		'apelidos'		=> ['tx_senha_usuario', 'senha_usuario', 'senhaUsuario', 'senha'],
		'obrigatorio'	=> true,
		'tipo'			=> 'senha'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}