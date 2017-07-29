<?php

namespace App\Modules\Osc\Models;

use App\Enums\ValidacaoDadoEnum;
use App\Util\ValidadorDadosUtil;

class OscModel
{
    private $id;
    private $nome;
    
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
    
    public function getNome()
    {
        return $this->nome;
    }
    
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    
    public function prepararObjeto($objeto)
    {
        $id = ['id', 'id_osc'];
        $nome = ['nome', 'tx_nome_osc'];
        
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
