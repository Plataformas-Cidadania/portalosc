<?php

namespace App\Models;

use App\Models\AjusteDados;
use App\Models\ValidacaoDados;
class Model
{
	private $modelo;
    private $requisicao;
    private $dadosFaltantes;
    private $dadosInvalidos;
    private $codigo;
    private $mensagem;
    
    public function obterDadosFaltantes()
    {
        return $this->dadosFaltantes;
    }
    
    public function obterDadosInvalidos()
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
    
    public function configurarModelo($modelo)
    {
    	$this->modelo = $modelo;
    }
    
    public function configurarRequisicao($requisicao)
    {
        $this->requisicao = $requisicao;
    }
    
    public function analisarRequisicao()
    {
        $this->aplicarAjustes();
        $this->validarRequisicao();
        $this->configurarResultado();
    }
    
    private function aplicarAjustes()
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
    
    private function validarRequisicao()
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
                    foreach($modelo as $m){
                        $this->integrarModeloInterno($m);
                        
                        if($this->codigo != 200){
                            break;
                        }
                    }
                }else{
                    $modelo = $this->requisicao->{$key};
                    $this->integrarModeloInterno($modelo);
                }
            }
        }
    }
    
    private function integrarModeloInterno($modelo)
    {
        $this->dadosFaltantes = $modelo->obterDadosFaltantes();
        $this->dadosInvalidos = $modelo->obterDadosInvalidos();
        $this->codigo = $modelo->obterCodigo();
        $this->mensagem = $modelo->obterMensagem();
    }
    
	protected function configurarResultado()
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