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
            foreach($this->requisicao as $keyUsuario => $valueUsuario){
                if(in_array($keyUsuario, $valueContrato['apelidos'])){
                    if($valueUsuario){
                        $requisicao->{$keyContrato} = $this->ajustarDado($valueContrato['tipo'], $valueUsuario);
                    }
                    else{
                        if(in_array('default', array_keys($valueContrato))){
                            $requisicao->{$keyContrato} = $valueContrato['default'];
                        }else{
                            $requisicao->{$keyContrato} = null;
                        }
                    }
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
                $dado = $dado;
                break;
                
            case 'cpf':
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
                if($this->verificarValidadeDado($this->requisicao->{$key}, $value['tipo'])){
                    unset($this->dadosInvalidos[$key]);
                }
            }
        }
    }
    
    private function verificarValidadeDado($dado, $tipo)
    {
        $result = true;
        
        switch($tipo){
            case 'string':
                $result = true;
                break;
                
            case 'integer':
                $result = ctype_digit($dado) || is_int($dado);
                break;
                
            case 'float':
                $result = is_numeric($dado) && strpos($dado, ".") !== false;
                break;
                
            case 'date':
                $result = true;
                break;
                
            case 'boolean':
                $result = $this->validacaoDados->validarBooleano($dado);
                break;
                
            case 'array':
                $result = is_array($dado);
                break;
                
            case 'arrayInteger':
                $result = $this->validacaoDados->validarArrayInteiro($dado);
                break;
                
            case 'arrayArray':
                $result = $this->validacaoDados->validarArrayArray($dado);
                break;
                
            case 'arrayObject':
                $result = $this->validacaoDados->validarArrayObject($dado);
                break;
                
            case 'email':
                $result = $this->validacaoDados->validarEmail($dado);
                break;
                
            case 'cpf':
                $result = $this->validacaoDados->validarCpf($dado);
                break;
                
            case 'senha':
                $result = (strlen($dado) >= 6);
                break;
                
            case 'localidade':
                $result = (strlen($dado) == 7 || strlen($dado) == 2);
                break;
                
            case 'arquivo':
                $result = $this->validacaoDados->validarArquivo($dado);
                break;
        }
        
        return $result;
    }
    
    private function criptografarDados()
    {
        if(property_exists($this->requisicao, 'tx_senha_usuario')){
            $this->requisicao->tx_senha_usuario = sha1($this->requisicao->tx_senha_usuario);
        }
    }
}
