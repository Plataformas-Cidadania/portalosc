<?php

namespace App\Models\Usuario;

use App\Models\Model;

class LoginModel extends Model
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
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}