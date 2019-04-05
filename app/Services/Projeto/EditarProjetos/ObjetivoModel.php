<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class ObjetivoModel extends BaseModel{
	private $id_financiador_projeto = array(
		'apelidos'		=> ['objetivo', 'id_objetivo', 'id_objetivo_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
    );
    
	private $cd_meta_projeto = array(
		'apelidos'		=> ['meta', 'cd_meta', 'cd_meta_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}