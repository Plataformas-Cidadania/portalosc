<?php

namespace App\Services\Edital\CriarEdital;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $tx_orgao = array(
		'apelidos' 		=> ['tx_orgao', 'orgao'], 
		'obrigatorio' 	=> true, 
		'tipo' 			=> 'string'
	);

	private $tx_programa = array(
		'apelidos' 		=> ['tx_programa', 'programa'], 
		'obrigatorio' 	=> true, 
		'tipo' 			=> 'string'
	);

	private $tx_area_interesse = array(
		'apelidos' 		=> ['tx_area_interesse', 'area_interesse', 'areaInteresse', 'area'], 
		'obrigatorio' 	=> true, 
		'tipo' 			=> 'string'
	);

	private $dt_data_vencimento = array(
		'apelidos' 		=> ['dt_data_vencimento', 'data_vencimento', 'dataVencimento', 'vencimento'], 
		'obrigatorio' 	=> true, 
		'tipo' 			=> 'date'
	);

	private $tx_link = array(
		'apelidos' 		=> ['tx_link', 'link'], 
		'obrigatorio' 	=> true, 
		'tipo' 			=> 'string'
	);

	private $tx_numero_chamada = array(
		'apelidos' 		=> ['tx_numero_chamada', 'numero_chamada', 'numeroChamada'], 
		'obrigatorio' 	=> true, 
		'tipo' 			=> 'string'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);

    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}