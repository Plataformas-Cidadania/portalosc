<?php

namespace App\Components;

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
	
	private function verificarDadosObrigatorios()
	{
		$dadosFaltantes = array();
		
		foreach($this->atributos as $key => $value){
			if($value['obrigatorio']){
				if(!array_key_exists($key, $this->requisicao->conteudo)){
					array_push($dadosFaltantes, $key);
				}
			}
		}
		
		if($dadosFaltantes){
			$this->invalidarRequisicao('Dados obrigatórios não enviados.');
		}
	}
	
	private function validarDados()
	{
		$validador = new ValidadorDadosUtil();
		
		if(array_key_exists('cpf', $this->requisicao->conteudo) && !$validador->validarCPF($this->requisicao->conteudo['cpf'])){
			$this->invalidateData('CPF inválido.');
		}else if(array_key_exists('email', $this->requisicao->conteudo) && !$validador->validarEmail($this->requisicao->conteudo['email'])){
			$this->invalidateData('E-mail inválido.');
		}else if(array_key_exists('tx_email_usuario', $this->requisicao->conteudo) && !$validador->validarEmail($this->requisicao->conteudo['tx_email_usuario'])){
			$this->invalidateData('E-mail inválido.');
		}else if(array_key_exists('id_user', $this->requisicao->conteudo) && !$validador->validarNumero($this->requisicao->conteudo['id_user'])){
			$this->invalidateData('ID de usuário inválido.');
		}else if(array_key_exists('id_osc', $this->requisicao->conteudo) && !$validador->validarNumero($this->requisicao->conteudo['id_osc'])){
			$this->invalidateData('ID de OSC inválido.');
		}else if(array_key_exists('localidade', $this->requisicao->conteudo) && !(strlen($this->requisicao->conteudo['localidade']) == 2 || strlen($this->requisicao->conteudo['localidade']) == 7)){
			$this->invalidateData('Código de localidade inválido.');
		}
	}
	
	public function executar($objeto, $validation)
	{	
		$this->requisicao = $requisicao;
		
		$this->verificarDadosObrigatorios();
		$this->prepararObjeto();
		$this->validarDados();
		
		return $this->resposta;
	}
}
