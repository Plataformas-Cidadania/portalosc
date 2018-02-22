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
	    $conteudoResposta = array();
	    
	    $dadosFaltantes = array_keys($model->getDadosFantantes());
	    if($dadosFaltantes) $conteudoResposta['dados_faltantes'] = $dadosFaltantes;
	    
	    $dadosInvalidos = array_keys($model->getDadosInvalidos());
	    if($dadosInvalidos) $conteudoResposta['dados_invalidos'] = $dadosInvalidos;
	    
	    if($dadosFaltantes && $dadosInvalidos){
	    	$conteudoResposta['msg'] = 'Dado(s) obrigatório(s) não enviado(s) e inválido(s).';
	    }else if($dadosFaltantes){
	    	$conteudoResposta['msg'] = 'Dado(s) obrigatório(s) não enviado(s).';
	    }else if($dadosInvalidos){
	    	$conteudoResposta['msg'] = 'Dado(s) obrigatório(s) inválido(s).';
	    }
	    
	    if($conteudoResposta){
	    	$this->resposta->prepararResposta($conteudoResposta, 400);
	    	$resultado = false;
	    }
	    
	    return $resultado;
	}
}
