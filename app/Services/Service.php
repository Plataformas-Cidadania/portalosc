<?php

namespace App\Services;

use App\Dto\RespostaDto;

class Service
{
    protected $requisicao;
	protected $resposta;
	
	public function __construct($requisicao = null)
	{
	    $this->requisicao = $requisicao;
	    $this->resposta = new RespostaDto();
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
	    $resultado = true;
	    
	    if($model->getDadosFantantes()){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) não enviado(s).'], 400);
	        $resultado = false;
	    }else if($model->getDadosInvalidos()){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) inválido(s).'], 400);
	        $resultado = false;
	    }
	    
	    return $resultado;
	}
}
