<?php

namespace App\Services\Usuario\DesativarUsuarioService;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $id_usuario = array(
		'apelidos'		=> ['idUsuario', 'id_usuario'],
		'obrigatorio'	=> true,
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