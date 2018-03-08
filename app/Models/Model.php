<?php

namespace App\Models;

use App\Models\AjusteDados;
use App\Models\ValidacaoDados;
class Model
{
	private $estrutura;
    private $requisicao;
    private $dadosFaltantes;
    private $dadosInvalidos;
    private $codigo;
    private $mensagem;
    
    public function setEstrutura($estrutura)
    {
    	$this->estrutura = $estrutura;
    }
    
    public function setRequisicao($requisicao)
    {
        $this->requisicao = $requisicao;
    }
    
    public function getDadosFaltantes()
    {
        return $this->dadosFaltantes;
    }
    
    public function getDadosInvalidos()
    {
        return $this->dadosFaltantes;
    }
    
    public function obterCodigo()
    {
    	return $this->codigo;
    }
    
    public function obterMensagem()
    {
    	return $this->mensagem;
    }
    
    public function obterObjeto()
    {
    	return $this->requisicao;
    }
    
    public function executar()
    {
        $this->ajustar();
        $this->validar();
        $this->analisar();
    }
    
    private function ajustar()
    {
        $requisicaoAjustada = new \stdClass();
        
        foreach($this->estrutura as $nomeAtributo => $estrutura){
        	$campoNaoEnviado = true;
        	
            foreach($this->requisicao as $campo => $dado){
            	$apelidos = $estrutura['apelidos'];
            	$possuiCampo = in_array($campo, $apelidos);
            	
            	if($possuiCampo){
                    $tipo = $estrutura['tipo'];
                    $modelo = isset($estrutura['modelo']) ? $estrutura['modelo'] : null;
                    $dadoAjustado = (new AjusteDados)->ajustar($dado, $tipo, $modelo);
                    $requisicaoAjustada->{$nomeAtributo} = $dadoAjustado;
                    
                    $atributoNaoEnviado = true;
                }
            }
			
            if($campoNaoEnviado){
            	$camposEstrutura = array_keys($estrutura);
            	$possuiDefault = in_array('default', $camposEstrutura);
            	
            	if($possuiDefault){
            		$default = $estrutura['default'];
            		$requisicaoAjustada->{$nomeAtributo} = $default;
            	}
            }
        }
        
        $this->requisicao = $requisicaoAjustada;
    }
    
    private function validar()
    {
        $this->dadosFaltantes = $this->estrutura;
        $this->dadosInvalidos = $this->estrutura;
        
        foreach($this->estrutura as $key => $value){
            if($value['obrigatorio']){
                if(property_exists($this->requisicao, $key)){
                	if($this->requisicao->{$key}){
                		unset($this->dadosFaltantes[$key]);
                	}
                    
                    $dado = $this->requisicao->{$key};
                    $tipo = $value['tipo'];
                	if((new ValidacaoDados())->validar($dado, $tipo)){
                        unset($this->dadosInvalidos[$key]);
                    }
                }else{
                    unset($this->dadosInvalidos[$key]);
                }
            }else{
                unset($this->dadosFaltantes[$key]);
                unset($this->dadosInvalidos[$key]);
            }

            if(isset($value['modelo'])){
                if($value['tipo'] === 'arrayObject'){
                    $modelo = $this->requisicao->{$key};
                    
                    foreach($modelo as $dado){
                        $this->dadosFaltantes = $dado->getDadosFaltantes();
                        $this->dadosInvalidos = $dado->getDadosInvalidos();
                        $this->codigo = $dado->obterCodigo();
                        $this->mensagem = $dado->obterMensagem();
                        
                        if($this->codigo != 200){
                            break;
                        }
                    }
                }else{
                    $dado = $this->requisicao->{$key};

                    $this->dadosFaltantes = $dado->getDadosFaltantes();
                    $this->dadosInvalidos = $dado->getDadosInvalidos();
                    $this->codigo = $dado->obterCodigo();
                    $this->mensagem = $dado->obterMensagem();
                }
            }
        }
    }
	
	protected function analisar()
	{
        $this->mensagem = array();
        
	    $dadosFaltantes = array_keys($this->dadosFaltantes);
	    if($dadosFaltantes){
            $this->mensagem['dados_faltantes'] = $dadosFaltantes;
        }
	    
	    $dadosInvalidos = array_keys($this->dadosInvalidos);
	    if($dadosInvalidos){
            $this->mensagem['dados_invalidos'] = $dadosInvalidos;
        }
	    
	    if($dadosFaltantes && $dadosInvalidos){
            $this->mensagem['msg'] = 'Dado(s) obrigatório(s) não enviado(s) e inválido(s).';
            $this->codigo = 400;
	    }else if($dadosFaltantes){
            $this->mensagem['msg'] = 'Dado(s) obrigatório(s) não enviado(s).';
            $this->codigo = 400;
	    }else if($dadosInvalidos){
            $this->mensagem['msg'] = 'Dado(s) obrigatório(s) inválido(s).';
            $this->codigo = 400;
	    }else{
            $this->mensagem['msg'] = 'Requisição válida.';
            $this->codigo = 200;
        }
	}
}