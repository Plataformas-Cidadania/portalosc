<?php

namespace App\Dto;

class RespostaDto
{
	private $codigo = 404;
	private $conteudo = ['msg' => 'Recurso não encontrado.'];
	private $flag = false;
	
	public function getCodigo()
	{
	    return $this->codigo;
	}
	
	public function setCodigo($codigo)
	{
	    $this->codigo = $codigo;
	    
	    if($this->codigo == 200){
	        $this->flag = true;
	    }else{
	        $this->flag = false;
	    }
	}
	
	public function getConteudo()
	{
		return $this->conteudo;
	}
	
	public function setConteudo($conteudo)
	{
	    $this->conteudo = $conteudo;
	}
	
	public function getFlag()
	{
		return $this->flag;
	}
	
	public function prepararResposta($conteudo = null, $codigo = 200)
	{
	    $this->setConteudo($conteudo);
	    $this->setCodigo($codigo);
	}
}
