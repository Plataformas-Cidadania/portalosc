<?php

namespace App\Services;

use App\Dto\RespostaDto;

class BaseService{
    protected $requisicao;
	protected $resposta;
	
	public function __construct($requisicao = null){
	    $this->requisicao = $requisicao;
	    $this->resposta = new RespostaDto();
	}
	
	public function setRequisicao($requisicao){
	    $this->requisicao = $requisicao;
	}
	
	public function getResposta(){
	    return $this->resposta;
	}
	
	public function executar(){
	    $this->resposta->prepararResposta(['msg' => 'Recurso não encontrado.'], 404);
	}
	
	protected function analisarDao($dao){
		$flag = true;
		$mensagem = ['msg' => $dao->mensagem];

		if($dao->flag){
			$this->resposta->prepararResposta($mensagem, 200);
		}else{
			$this->resposta->prepararResposta($mensagem, 400);
			$flag = false;
		}

		return $flag;
	}
}