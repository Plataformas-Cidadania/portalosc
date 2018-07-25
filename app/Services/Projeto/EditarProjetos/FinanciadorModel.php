<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class FinanciadorModel extends BaseModel{
	private $id_financiador_projeto = array(
		'apelidos'		=> ['financiador', 'id_financiador', 'id_financiador_projeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
    );
    
	private $cd_origem_fonte_recursos_projeto = array(
		'apelidos'		=> ['nomeFinanciador', 'nome_financiador', 'tx_nome_financiador'],
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