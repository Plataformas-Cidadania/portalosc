<?php

namespace App\Modules;

use App\DTO\RequisicaoDTO;
use App\DTO\RespostaDTO;

class Service
{
	protected $requisicao = false;
	protected $resposta = false;
	protected $flag = false;
	protected $mensagem = false;
	
	public function __construct()
	{
		$this->requisicao = new RequisicaoDTO();
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
