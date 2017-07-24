<?php

namespace App\Components\Usuario\Models;

abstract class LoginModel
{
	const tx_email_usuario = [
			'nome' => 'email',
			'obrigatorio' => true,
			'tipo' => 'email'
	];
	const tx_senha_usuario = [
			'nome' => 'senha',
			'obrigatorio' => true,
			'tipo' => 'texto'
	];
}
