<?php

namespace App\DTO;

class RequisicaoDTO
{
	private $usuario = null;
	private $atributos = array();
	private $conteudo = array();
	
	public function getUsuario()
	{
		return $this->usuario;
	}
	
	public function getConteudo()
	{
		return $this->conteudo;
	}
	
	public function definirRequisicao($conteudo = array(), $usuario = null)
	{
		$this->conteudo = $conteudo;
		$this->usuario = $usuario;
	}
}
