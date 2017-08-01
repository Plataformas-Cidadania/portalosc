<?php

namespace App\Services;

use App\DTO\RespostaDTO;

class Service
{
    protected $requisicao;
	protected $resposta;
	protected $flag;
	protected $mensagem;
	
	public function __construct($requisicao = null)
	{
	    $this->requisicao = $requisicao;
		$this->resposta = new RespostaDTO();
	}
	
	public function setRequisicao($requisicao)
	{
	    $this->requisicao = $requisicao;
	}
	
	public function getResposta()
	{
	    return $this->resposta;
	}
	
	public function executar()
	{
	    $this->flag = false;
	    $this->mensagem = null;
	}
}
