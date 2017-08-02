<?php

namespace App\Services;

use App\Dto\RespostaDto;

class Service
{
    protected $requisicao;
	protected $resposta;
	protected $flag;
	
	public function __construct($requisicao = null)
	{
	    $this->requisicao = $requisicao;
	    $this->resposta = new RespostaDto();
	    $this->flag = true;
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
	    $this->resposta->prepararResposta(['msg' => 'Recurso não encontrado.'], 404);
	}
	
	protected function analisarModel($model)
	{
	    if($model->getDadosFantantes()){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) não enviado(s).'], 400);
	        $this->flag = false;
	    }else if($model->getDadosInvalidos()){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) inválido(s).'], 400);
	        $this->flag = false;
	    }else{
	        $this->flag = true;
	    }
	}
}
