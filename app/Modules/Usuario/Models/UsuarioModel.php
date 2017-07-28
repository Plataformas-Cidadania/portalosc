<?php

namespace App\Modules\Usuario\Models;

use App\Enums\TipoUsuarioEnum;
use App\Enums\ValidacaoDadoEnum;
use App\Util\ValidadorDadosUtil;

class UsuarioModel
{
    private $id;
    private $email;
    private $senha;
    private $nome;
    private $cpf;
    private $listaEmail;
    private $tipoUsuario;
    
    private $validadorUtil;
    
    public function __construct()
    {
        $this->validadorUtil = new ValidadorDadosUtil();
    }
    
    public function setId($id)
    {
        if($this->validadorUtil->validarNumero($id)){
            $this->id = $id;
        }else{
            $this->id = ValidacaoDadoEnum::INVALIDO;
        }
    }
    
    public function setEmail($email)
    {
        if($this->validadorUtil->validarEmail($email)){
            $this->email = $email;
        }else{
            $this->email = ValidacaoDadoEnum::INVALIDO;
        }
    }
    
    public function setSenha($senha)
    {
        if($senha >= 6){
            $this->senha = $senha;
        }else{
            $this->senha = ValidacaoDadoEnum::INVALIDO;
        }
    }
    
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    
    public function setCpf($cpf)
    {
        if($this->validadorUtil->validarCpf($cpf)){
            $this->cpf = $cpf;
        }else{
            $this->cpf = ValidacaoDadoEnum::INVALIDO;
        }
    }
    
    public function setListaEmail($listaEmail)
    {
        $this->listaEmail = $listaEmail;
    }
    
    public function setTipoUsuario($tipoUsuario)
    {
        if(TipoUsuarioEnum::isValidValue($tipoUsuario)){
            $this->tipoUsuario = $tipoUsuario;
        }else{
            $this->tipoUsuario = ValidacaoDadoEnum::INVALIDO;
        }
    }
    
    public function prepararObjeto($objeto)
    {
        $id = ['id'];
        $email = ['email', 'emailUsuario', 'email_usuario', 'tx_email_usuario'];
        $senha = ['senha', 'senhaUsuario', 'senha_usuario', 'tx_senha_usuario'];
        $nome = ['nome'];
        $cpf = ['cpf'];
        $listaEmail = ['listaEmail'];
        $tipoUsuario = ['tipoUsuario'];
        
        foreach($objeto as $key => $value){
            if(in_array($key, $id)) $this->setId($value);
            else if(in_array($key, $email)) $this->setEmail($value);
            else if(in_array($key, $senha)) $this->setSenha($value);
            else if(in_array($key, $nome)) $this->setNome($value);
            else if(in_array($key, $cpf)) $this->setCpf($value);
            else if(in_array($key, $listaEmail)) $this->setListaEmail($value);
            else if(in_array($key, $tipoUsuario)) $this->setTipoUsuario($value);
        }
    }
    
    public function verificarDadosObrigatorios($dadosObrigatorios)
    {
        $dadoFaltantes = array();
        
        foreach($dadosObrigatorios as $dado){
            if(!isset($this->{$dado})){
                array_push($dadoFaltantes, $dado);
            }
        }
        print_r($dadoFaltantes);
        return $dadoFaltantes;
    }
    
    public function validarDadosObrigatorios($dadosObrigatorios)
    {
        $dadoInvalidos = array();
        
        foreach($dadosObrigatorios as $dado){
            if($this->{$dado} == ValidacaoDadoEnum::INVALIDO){
                array_push($dadoInvalidos, $dado);
            }
        }
        
        return $dadoInvalidos;
    }
}
