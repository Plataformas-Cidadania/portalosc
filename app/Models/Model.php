<?php

namespace App\Models;

use App\Util\ValidacaoDadosUtil;
use App\Util\FormatacaoUtil;

class Model
{
	private $estrutura;
    private $requisicao;
    private $dadosFantantes;
    private $dadosInvalidos;
    
    private $validacaoDados;
    
    public function setEstrutura($estrutura)
    {
    	$this->estrutura = $estrutura;
    }
    
    public function setRequisicao($requisicao)
    {
        $this->requisicao = $requisicao;
    }
    
    public function getModel()
    {
    	return $this->requisicao;
    }
    
    public function getDadosFantantes()
    {
        return $this->dadosFantantes;
    }
    
    public function getDadosInvalidos()
    {
        return $this->dadosInvalidos;
    }
    
    public function prepararModel()
    {
        $this->ajustarRequisicao();
        $this->validarRequisição();
        $this->criptografarDados();
    }
    
    private function ajustarRequisicao()
    {
        $requisicaoAjustada = new \stdClass();
        
        foreach($this->estrutura as $nomeAtributo => $estrutura){
        	$campoNaoEnviado = true;
        	
            foreach($this->requisicao as $campo => $dado){
            	$apelidos = $estrutura['apelidos'];
            	$possuiCampo = in_array($campo, $apelidos);
            	
            	if($possuiCampo){
                    $tipo = $estrutura['tipo'];
                    $dadoAjustado = $this->ajustarDado($tipo, $dado);
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
    
    private function ajustarDado($tipo, $dado)
    {
    	$this->formatacaoUtil = new FormatacaoUtil();
    	
        switch($tipo){
            case 'float':
                $dado = str_replace(',', '.', $dado);
                break;
                
            case 'date':
                if(strlen($dado) == 4){
                    $dado = '01-01-' . $dado;
                }
                break;
                
            case 'boolean':
            	$dado = $this->formatacaoUtil->formatarBoolean($dado);
                break;
                
            case 'cpf':
                $dado = preg_replace('/[^0-9]/', '', $dado);
                break;
                
            case 'arrayObject':
            	foreach($dado as $key => $value){
            		$dado[$key] = (object) $value;
            	}
                break;
        }
        
        return $dado;
    }
    
    private function validarRequisição()
    {
    	$this->validacaoDados = new ValidacaoDadosUtil();
    	
        $this->dadosFantantes = $this->estrutura;
        $this->dadosInvalidos = $this->estrutura;
        
        foreach($this->estrutura as $key => $value){
            if($value['obrigatorio']){
                if(property_exists($this->requisicao, $key)){
                	if($this->requisicao->{$key}){
                		unset($this->dadosFantantes[$key]);
                	}
                	
                	if($this->verificarValidadeDado($this->requisicao->{$key}, $value['tipo'])){
                        unset($this->dadosInvalidos[$key]);
                    }
                }else{
                    unset($this->dadosInvalidos[$key]);
                }
            }else{
                unset($this->dadosFantantes[$key]);
                unset($this->dadosInvalidos[$key]);
            }
        }
    }
    
    private function verificarValidadeDado($dado, $tipo)
    {
        $resultado = true;
        
        switch($tipo){
            case 'string':
                $resultado = true;
                break;
                
            case 'integer':
                $resultado = ctype_digit($dado) || is_int($dado);
                break;
                
            case 'float':
                $resultado = is_numeric($dado);
                break;
                
            case 'date':
                $resultado = $this->validacaoDados->validarData($dado);
                break;
                
            case 'boolean':
                $resultado = $this->validacaoDados->validarBooleano($dado);
                break;
                
            case 'array':
                $resultado = is_array($dado);
                break;
                
            case 'arrayInteger':
                $resultado = $this->validacaoDados->validarArrayInteiro($dado);
                break;
                
            case 'arrayArray':
                $resultado = $this->validacaoDados->validarArrayArray($dado);
                break;
                
            case 'arrayObject':
                $resultado = $this->validacaoDados->validarArrayObject($dado);
                break;
                
            case 'email':
                $resultado = $this->validacaoDados->validarEmail($dado);
                break;
                
            case 'cpf':
                $resultado = $this->validacaoDados->validarCpf($dado);
                break;
                
            case 'senha':
                $resultado = (strlen($dado) >= 6);
                break;
                
            case 'localidade':
                $resultado = (strlen($dado) == 7 || strlen($dado) == 2);
                break;
                
            case 'arquivo':
                $resultado = $this->validacaoDados->validarArquivo($dado);
                break;
        }
		
        return $resultado;
    }
    
    private function criptografarDados()
    {
        if(property_exists($this->requisicao, 'tx_senha_usuario')){
        	if(strlen($this->requisicao->tx_senha_usuario) >= 6){
            	$this->requisicao->tx_senha_usuario = sha1($this->requisicao->tx_senha_usuario);
        	}
        }
    }
}
