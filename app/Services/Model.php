<?php

namespace App\Services;

use App\Util\ValidacaoDadosUtil;

class Model
{
    private $contrato;
    private $requisicao;
    private $dadosFantantes;
    private $dadosInvalidos;
    
    private $validacaoDados;
    
    public function __construct($contrato = null, $requisicao = null)
    {
        $this->setContrato($contrato);
        $this->setRequisicao($requisicao);
        $this->validacaoDados = new ValidacaoDadosUtil();
        
        if($this->contrato && $this->requisicao){
            $this->prepararModel();
        }
    }
    
    public function setContrato($contrato)
    {
        $this->contrato = $contrato;
    }
    
    public function getRequisicao()
    {
        return $this->requisicao;
    }
    
    public function setRequisicao($requisicao)
    {
        $this->requisicao = $requisicao;
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
        $requisicao = new \stdClass();
        
        foreach($this->contrato as $keyContrato => $valueContrato){
            foreach($this->requisicao as $keyRequisicao => $valueRequisicao){
                if(in_array($keyRequisicao, $valueContrato['apelidos'])){
                    if($valueRequisicao !== null){
                        $requisicao->{$keyContrato} = $this->ajustarDado($valueContrato['tipo'], $valueRequisicao);
                    }else{
                        if(in_array('default', array_keys($valueContrato))){
                            $requisicao->{$keyContrato} = $valueContrato['default'];
                        }else{
                            $requisicao->{$keyContrato} = null;
                        }
                    }
                }
            }
			
            if(property_exists($requisicao, $keyContrato) == false){
            	if(in_array('default', array_keys($valueContrato))){
            		$requisicao->{$keyContrato} = $keyContrato['default'];
            	}else{
            		$requisicao->{$keyContrato} = null;
            	}
            }
        }
        
        $this->requisicao = $requisicao;
    }
    
    private function ajustarDado($tipo, $dado)
    {
        switch($tipo){
            case 'float':
                $dado = str_replace(',', '.', $dado);
                break;
                
            case 'date':
                if(strlen($dado) == 4){
                    $dado = '01-01-' . $dado;
                }
                break;
                
            case 'cpf':
                $dado = $dado;
                break;
                
            case 'arrayObject':
            	foreach($dado as $key => $value){
            		$dado[$key] = (object) $value;
            	}
                $dado = $dado;
                break;
        }
        
        return $dado;
    }
    
    private function validarRequisição()
    {
        $this->dadosFantantes = $this->contrato;
        $this->dadosInvalidos = $this->contrato;
        
        foreach($this->contrato as $key => $value){
            if($value['obrigatorio']){
                if(property_exists($this->requisicao, $key)){
                    unset($this->dadosFantantes[$key]);
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
            $this->requisicao->tx_senha_usuario = sha1($this->requisicao->tx_senha_usuario);
        }
    }
}
