<?php

namespace App\Modules\Usuario\Models;

use App\Modules\Osc\Models\OscModel;
use App\Modules\Usuario\Models\UsuarioModel;

class RepresentanteOscModel extends UsuarioModel
{
    private $oscs;
    
    public function __construct()
    {
    	parent::__construct();
    }
    
    public function getOscs()
    {
    	return $this->oscs;
    }
    
    public function setOscs($oscs)
    {
        $this->oscs = $oscs;
    }
    
    public function addOsc($osc)
    {
        if($this->oscs == null){
            $this->oscs = array();
        }
        
        array_push($this->oscs, $osc);
    }
	
    public function prepararObjeto($objeto)
    {
    	parent::prepararObjeto($objeto);
    	
    	$oscs = ['oscs', 'organizacoes', 'representacao'];
    	
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
