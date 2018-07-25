<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class FonteRecursosModel extends BaseModel{
	private $id_fonte_recursos_projeto = array(
		'apelidos'		=> ['fonteRecursos', 'fonte_recursos', 'id_fonte_recursos_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
    );
    
	private $cd_fonte_recursos_projeto = array(
		'apelidos'		=> ['fonteRecursos', 'fonte_recursos', 'cd_fonte_recursos', 'cd_fonte_recursos_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
    
	private $cd_origem_fonte_recursos_projeto = array(
		'apelidos'		=> ['origemFonteRecursos', 'origem_fonte_recursos', 'cd_origem_fonte_recursos', 'cd_origem_fonte_recursos_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
    
	private $tx_tipo_parceria_outro = array(
		'apelidos'		=> ['tipoParceriaOutro', 'tipo_parceria_outro', 'tx_tipo_parceria_outro'],
		'obrigatorio'	=> false,
		'tipo'			=> 'string'
	);
    
	private $tx_orgao_concedente = array(
		'apelidos'		=> ['orgaoConcedente', 'orgao_concedente', 'tx_orgao_concedente'],
		'obrigatorio'	=> false,
		'tipo'			=> 'string'
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}