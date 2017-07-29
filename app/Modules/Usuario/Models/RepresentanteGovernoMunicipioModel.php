<?php

namespace App\Modules\Usuario\Models;

use App\Util\ValidadorDadosUtil;
use App\Modules\Usuario\Models\UsuarioModel;

class RepresentanteGovernoMunicipioModel extends UsuarioModel
{
	private $codigo;
	private $nome;
	
	private $validadorDados;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->validadorDados = new ValidadorDadosUtil();
	}
	
	public function getCodigo()
	{
		return $this->codigo;
	}
	
	public function setCodigo($codigo)
	{
	    if($this->validadorDados->validarNumero($codigo)){
	        $this->codigo = $codigo;
	    }else{
	        $this->codigo = ValidacaoDadoEnum::INVALIDO;
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
		parent::prepararObjeto($objeto);
		 
		$codigo = ['codigo', 'id', 'cd_municipio', 'edmu_cd_municipio'];
		$nome = ['nome', 'municipio', 'nome_municipio', 'edmu_nm_municipio'];
		
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
