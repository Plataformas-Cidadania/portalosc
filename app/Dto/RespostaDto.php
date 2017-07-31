<?php

namespace App\Dto;

class RespostaDto
{
	private $codigo = 404;
	private $conteudo = ['msg' => 'Recurso não encontrado.'];
	private $flag = false;
	
	public function obterCodigo()
	{
	    return $this->codigo;
	}
	
	public function obterConteudo()
	{
		return $this->conteudo;
	}
	
	public function obterFlag()
	{
		return $this->flag;
	}
	
	public function prepararResposta($conteudo = null, $codigo = 200)
	{
	    $this->conteudo = $conteudo;
	    $this->codigo = $codigo;
		
		if($this->codigo == 200){
			$this->flag = true;
		}else{
			$this->flag = false;
		}
	}
	
	public function atualizarConteudo($novoConteudo)
	{
	    $this->content = array_merge($this->conteudo, $novoConteudo);
	}
}