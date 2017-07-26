<?php

namespace App\Modules\Usuario\Models;

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
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function setEmail($email)
    {
        if($this->validadorUtil->validarEmail($email)){
            $this->email = $email;
        }else{
            $this->email = 'FLAG_DADO_INVALIDO';
        }
    }
    
    public function setSenha($senha)
    {
        if($senha >= 6){
            $this->senha = $senha;
        }else{
            $this->cpf = 'FLAG_DADO_INVALIDO';
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
            $this->cpf = 'FLAG_DADO_INVALIDO';
        }
    }
    
    public function setListaEmail($listaEmail)
    {
        $this->listaEmail = $listaEmail;
    }
    
    public function setTipoUsuario($tipoUsuario)
    {
        $this->tipoUsuario = $tipoUsuario;
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
            else if(in_array($key, $email)) $this->setListaEmail($value);
            else if(in_array($key, $listaEmail)) $this->setTipoUsuario($value);
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
        
        return $dadoFaltantes;
    }
    
    public function validarDadosObrigatorios($dadosObrigatorios)
    {
        $dadoInvalidos = array();
        
        foreach($dadosObrigatorios as $dado){
            if($this->{$dado} == 'FLAG_DADO_INVALIDO'){
                array_push($dadoInvalidos, $dado);
            }
        }
        
        return $dadoInvalidos;
    }
}
