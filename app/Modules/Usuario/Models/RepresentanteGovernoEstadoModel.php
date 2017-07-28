<?php

namespace App\Modules\Usuario\Models;

use App\Modules\Usuario\Models\UsuarioModel;

class RepresentanteGovernoEstado extends UsuarioModel
{
	private $codigo;
    private $nome;
    private $sigla;
    
    public function __construct() {
    	parent::__construct();
    }
    
    public function getCodigo(){
    	return $this->codigo;
    }
    
    public function setCodigo($codigo){
    	$this->codigo = $codigo;
    }
    
    public function getNome(){
    	return $this->nome;
    }
    
    public function setNome($nome){
    	$this->nome = $nome;
    }
    
    public function getSigla(){
    	return $this->sigla;
    }
    
    public function setSigla($sigla){
    	$this->sigla = $sigla;
    }
    
    public function prepararObjeto($objeto)
    {
    	parent::prepararObjeto($objeto);
    	
    	$codigo = ['codigo', 'id', 'cd_uf', 'eduf_cd_uf'];
    	$nome = ['nome', 'estado', 'nome_estado', 'eduf_nm_uf'];
    	$sigla = ['sigla', 'uf', 'eduf_sg_uf'];
    	
    	foreach($objeto as $key => $value){
    		if(in_array($key, $oscs)) $this->setOscs($value);
    	}
    }
    
    function clone($object)
    {
    	$this->setId($object->getId());
    	$this->setEmail($object->getEmail());
    	$this->setSenha($object->getSenha());
    	$this->setNome($object->getNome());
    	$this->setCpf($object->getCpf());
    	$this->setListaEmail($object->getListaEmail());
    	$this->setAtivo($object->getAtivo());
    	$this->setTipoUsuario($object->getTipoUsuario());
    }
}