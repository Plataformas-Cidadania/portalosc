<?php

namespace App\Dto;

class RequisicaoDto
{
	private $usuario = null;
	private $conteudo = array();
	
	public function getUsuario()
	{
	    return $this->usuario;
	}
	
	public function setUsuario($usuario)
	{
	    $this->usuario = (object) $usuario;
	}
	
	public function getConteudo()
	{
		return $this->conteudo;
	}
	
	public function setConteudo($conteudo)
	{
	    $this->conteudo = (object) $conteudo;
	}
	
	public function prepararRequisicao($conteudo = array(), $usuario = null)
	{
		$this->setConteudo($conteudo);
		$this->setUsuario($usuario);
	}
}