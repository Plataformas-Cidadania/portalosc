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
    private $ativo;
    private $tipoUsuario;
    
    private $validadorDados;
    
    public function __construct()
    {
        $this->validadorDados = new ValidadorDadosUtil();
    }
    
    public function getId()
    {
		return $this->id;
    }
    
    public function setId($id)
    {
        if($this->validadorDados->validarNumero($id)){
            $this->id = $id;
        }else{
            $this->id = ValidacaoDadoEnum::INVALIDO;
        }
    }
    
    public function getEmail()
    {
		return $this->email;
    }
    
    public function setEmail($email)
    {
        if($this->validadorDados->validarEmail($email)){
            $this->email = $email;
        }else{
            $this->email = ValidacaoDadoEnum::INVALIDO;
        }
    }
    
    public function getSenha()
    {
		return $this->senha;
    }
    
    public function setSenha($senha)
    {
        if($senha >= 6){
            $this->senha = sha1($senha);
        }else{
            $this->senha = ValidacaoDadoEnum::INVALIDO;
        }
    }
    
    public function getNome()
    {
        return $this->nome;
    }
    
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    
    public function getCpf()
    {
		return $this->cpf;
    }
    
    public function setCpf($cpf)
    {
        if($this->validadorDados->validarCpf($cpf)){
            $this->cpf = $cpf;
        }else{
            $this->cpf = ValidacaoDadoEnum::INVALIDO;
        }
    }
    
    public function getListaEmail()
    {
    	 $this->listaEmail;
    }
    
    public function setListaEmail($listaEmail)
    {
        $this->listaEmail = $listaEmail;
    }
    
    public function getAtivo()
    {
    	return $this->ativo;
    }
    
    public function setAtivo($ativo)
    {
    	$this->ativo = $ativo;
    }
    
    public function getTipoUsuario()
    {
    	return $this->tipoUsuario;
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
        $id = ['id', 'id_usuario'];
        $email = ['email', 'emailUsuario', 'email_usuario', 'tx_email_usuario'];
        $senha = ['senha', 'senhaUsuario', 'senha_usuario', 'tx_senha_usuario'];
        $nome = ['nome', 'tx_nome_usuario'];
        $cpf = ['cpf', 'nr_cpf_usuario'];
        $listaEmail = ['listaEmail', 'bo_lista_email'];
        $ativo = ['ativo', 'bo_ativo'];
        $tipoUsuario = ['tipoUsuario', 'cd_tipo_usuario'];
        
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
