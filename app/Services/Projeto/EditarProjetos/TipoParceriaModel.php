<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class TipoParceriaModel extends BaseModel{
	private $id_tipo_parceria_projeto = array(
		'apelidos'		=> ['idTipoParceria', 'idTipoParceriaProjeto', 'id_tipo_parceria_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
    );
    
	private $cd_tipo_parceria_projeto = array(
		'apelidos'		=> ['tipoParceria', 'tipo_parceria', 'cd_tipo_parceria', 'cd_tipo_parceria_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
    
	private $bo_localizacao_prioritaria = array(
		'apelidos'		=> ['tipoParceria', 'tipo_parceria', 'cd_tipo_parceria', 'cd_tipo_parceria_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean'
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}