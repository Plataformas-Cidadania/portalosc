<?php

namespace App\Services;

use App\Enums\AtributoEnum;
use App\Enums\TipoUsuarioEnum;
use App\Enums\ValidacaoDadoEnum;
use App\Util\ValidadorDadosUtil;

class Model
{
    private $contrato;
    private $requisicao;
    private $dadosFantantes;
    private $dadosInvalidos;
    
    private $validadorDados;
    
    public function __construct($contrato, $requisicao)
    {
        $this->contrato = $contrato;
        $this->requisicao = $requisicao;
        $this->validadorDados = new ValidadorDadosUtil();
    }
    
    public function setContrato($contrato)
    {
        $this->contrato = $contrato;
    }
    
    public function setRequisicao($requisicao)
    {
        $this->requisicao = $requisicao;
    }
    
    public function getRequisicao()
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
    
    public function ajustarRequisicao()
    {
        $requisicao = (object) [];
        
        foreach($this->contrato as $keyContrato => $valueContrato){
            foreach($this->requisicao as $keyUsuario => $valueUsuario){
                if(in_array($keyUsuario, $valueContrato['apelidos'])){
                    $requisicao->{$keyContrato} = $valueUsuario;
                }
            }
        }
        
        $this->requisicao = $requisicao;
    }
    
    public function validarRequisição()
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
    
    public function criptografarSenha()
    {
        if(property_exists($this->requisicao, 'tx_senha_usuario')){
            $this->requisicao->tx_senha_usuario = sha1($this->requisicao->tx_senha_usuario);
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
                $result = $this->validadorDados->validarNumeroInteiro($dado);
                break;
                
            case 'email':
                $result = $this->validadorDados->validarEmail($dado);
                break;
                
            case 'cpf':
                $result = $this->validadorDados->validarCpf($dado);
                break;
        }
        
        return $result;
    }
}
