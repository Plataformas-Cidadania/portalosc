<?php

namespace App\Services;

use App\DTO\RespostaDTO;

class Service
{
	protected $resposta = false;
	protected $flag = false;
	protected $mensagem = false;
	
	public function __construct()
	{
		$this->resposta = new RespostaDTO();
	}
	
	private function invalidarRequisicao($mensagem = null)
	{
		$this->flag = false;
		$this->mensagem = $mensagem;
	}
	
	public function executar($requisicao)
	{	
		$this->requisicao = $requisicao;
		
		return $this->resposta;
	}
}
