<?php

namespace App\Models;

use App\Models\AjusteDados;
use App\Models\ValidacaoDados;
class Model
{
	private $modelo;
    private $requisicao;
    private $atributosFaltantes;
    private $dadosInvalidos;
    private $codigo;
    private $mensagem;

    public function obterAtributosFaltantes()
    {
        return $this->atributosFaltantes;
    }
    
    public function obterDadosInvalidos()
    {
        return $this->dadosInvalidos;
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
        
        foreach($this->modelo as $nomeAtributo => $restricoesAtributo){
        	$atributoNaoEnviado = true;
        	
            foreach($this->requisicao as $atributo => $dado){
            	if(in_array($atributo, $restricoesAtributo['apelidos'])){
                    $tipo = $restricoesAtributo['tipo'];
                    $modelo = isset($restricoesAtributo['modelo']) ? $restricoesAtributo['modelo'] : null;
                    
                    $objetoAjustado = (new AjusteDados)->ajustar($dado, $tipo, $modelo);
                    $requisicaoAjustada->{$nomeAtributo} = $objetoAjustado;
                    
                    $atributoNaoEnviado = true;
                }
            }
			
            if($atributoNaoEnviado){
            	$nomeRestricoes = array_keys($restricoesAtributo);
            	if(in_array('default', $nomeRestricoes)){
            		$default = $restricoesAtributo['default'];
            		$requisicaoAjustada->{$nomeAtributo} = $restricoesAtributo['default'];
            	}
            }
        }
        
        $this->requisicao = $requisicaoAjustada;
    }
    
    private function validarRequisicao()
    {
        $this->atributosFaltantes = $this->modelo;
        $this->dadosInvalidos = $this->modelo;
        
        foreach($this->modelo as $nomeAtributo => $restricoesAtributo){
            $atributoObrigatorio = isset($restricoesAtributo['obrigatorio']) ? $restricoesAtributo['obrigatorio'] : false;

            if($atributoObrigatorio){
                if(property_exists($this->requisicao, $nomeAtributo)){
                    if($this->requisicao->{$nomeAtributo}){
                        unset($this->atributosFaltantes[$nomeAtributo]);
                    }
                    
                    $dado = $this->requisicao->{$nomeAtributo};
                    if((new ValidacaoDados())->validar($dado, $restricoesAtributo['tipo'])){
                        unset($this->dadosInvalidos[$nomeAtributo]);
                    }
                }else{
                    unset($this->dadosInvalidos[$nomeAtributo]);
                }
            }else{
                unset($this->atributosFaltantes[$nomeAtributo]);
                unset($this->dadosInvalidos[$nomeAtributo]);
            }

            if(isset($restricoesAtributo['modelo'])){
                if($restricoesAtributo['tipo'] === 'arrayObject'){
                    $modeloPrincipal = $this->requisicao->{$nomeAtributo};
                    foreach($modeloPrincipal as $modeloInterno){
                        $this->integrarModeloInterno($modeloInterno);
                        
                        if($this->codigo != 200){
                            break;
                        }
                    }
                }else{
                    $modeloInterno = $this->requisicao->{$nomeAtributo};
                    $this->integrarModeloInterno($modeloInterno);
                }
            }
        }

        $this->integrarObjeto();
    }
    
    private function integrarObjeto(){
        //$teste = array_map(function($o) { return $o->id; }, (array) $this->requisicao);

        if(gettype($this->requisicao) == 'object'){
            foreach($this->requisicao as $campo => $valor){
                if(gettype($valor) == 'array'){
                    foreach($valor as $campo2 => $valor2){
                        if(gettype($valor2) == 'object'){
                            if(method_exists($valor2, 'obterObjeto')){
                                $this->requisicao->{$campo}[$campo2] = $valor2->obterObjeto();
                            }
                        }
                    }
                }
            }
        }else if(gettype($this->requisicao) == 'array'){
            foreach($this->requisicao as $campo => $valor){
                if(gettype($this->requisicao) == 'object'){
                    foreach($valor as $campo2 => $valor2){
                        if(gettype($valor2) == 'array'){
                            foreach($valor2 as $campo3 => $valor3){
                                if(gettype($valor3) == 'object'){
                                    if(method_exists($valor3, 'obterObjeto')){
                                        $this->requisicao->{$campo}[$campo3] = $valor3->obterObjeto();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private function integrarModeloInterno($modelo)
    {
        $this->atributosFaltantes = $modelo->obterAtributosFaltantes();
        $this->dadosInvalidos = $modelo->obterDadosInvalidos();
        $this->codigo = $modelo->obterCodigo();
        $this->mensagem = $modelo->obterMensagem();
    }
    
	protected function configurarResultado()
	{
	    if($this->atributosFaltantes && $this->dadosInvalidos){
            $this->mensagem['atributos_faltantes'] = $this->atributosFaltantes;
            $this->mensagem['dados_invalidos'] = $this->dadosInvalidos;
            $this->mensagem['msg'] = 'Dado(s) obrigatório(s) não enviado(s) e inválido(s).';
            $this->codigo = 400;
	    }else if($this->atributosFaltantes){
            $this->mensagem['atributos_faltantes'] = $this->atributosFaltantes;
            $this->mensagem['msg'] = 'Dado(s) obrigatório(s) não enviado(s).';
            $this->codigo = 400;
	    }else if($this->dadosInvalidos){
            $this->mensagem['dados_invalidos'] = $this->dadosInvalidos;
            $this->mensagem['msg'] = 'Dado(s) obrigatório(s) inválido(s).';
            $this->codigo = 400;
	    }else{
            $this->mensagem['msg'] = 'Requisição válida.';
            $this->codigo = 200;
        }
	}
}