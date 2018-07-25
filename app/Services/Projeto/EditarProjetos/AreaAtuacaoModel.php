<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class AreaAtuacaoModel extends BaseModel{
	private $id_area_atuacao_projeto = array(
		'apelidos'		=> ['idAreaAtuacao', 'id_area_atuacao', 'id_area_atuacao_projeto'],
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