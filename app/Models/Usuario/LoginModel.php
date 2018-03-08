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
    	$modelo = get_object_vars($this);
    	
    	$this->confiturarModelo($modelo);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}