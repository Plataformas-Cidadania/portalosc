<?php

namespace App\Services;

use App\Util\ValidadorDadosUtil;

class Model
{
    private $contrato;
    private $requisicao;
    private $dadosFantantes;
    private $dadosInvalidos;
    
    private $validadorDados;
    
    public function __construct($contrato = null, $requisicao = null)
    {
        $this->setContrato($contrato);
        $this->setRequisicao($requisicao);
        $this->validadorDados = new ValidadorDadosUtil();
        
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
                    $requisicao->{$keyContrato} = $valueUsuario;
                }
            }
        }
        
        $this->requisicao = $requisicao;
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
                $result = is_int($dado);
                break;
                
            case 'boolean':
                $result = $this->validadorDados->validarBooleano($dado);
                break;
                
            case 'array':
                $result = is_array($dado);
                break;
                
            case 'arrayInteger':
                $result = $this->validadorDados->validarArrayInteiro($dado);
                break;
                
            case 'arrayArray':
                $result = $this->validadorDados->validarArrayArray($dado);
                break;
                
            case 'arrayObject':
                $result = $this->validadorDados->validarArrayObject($dado);
                break;
                
            case 'email':
                $result = $this->validadorDados->validarEmail($dado);
                break;
                
            case 'cpf':
                $result = $this->validadorDados->validarCpf($dado);
                break;
                
            case 'senha':
                $result = (strlen($dado) >= 6);
                break;
                
            case 'localidade':
                $result = (strlen($dado) == 7 || strlen($dado) == 2);
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
