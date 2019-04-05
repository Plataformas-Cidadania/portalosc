<?php

namespace App\Services\Osc\EditarDescricao;

use App\Services\BaseModel;

class Model extends BaseModel{
	private $tx_historico = array(
		'apelidos'		=> ['tx_historico', 'historico'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'text'
	);

	private $tx_missao_osc = array(
		'apelidos'		=> ['tx_missao_osc', 'missao_osc', 'missaoOsc'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'text'
	);

	private $tx_visao_osc = array(
		'apelidos'		=> ['tx_visao_osc', 'visao_osc', 'visaoOsc'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'text'
	);

	private $tx_finalidades_estatutarias = array(
		'apelidos'		=> ['tx_finalidades_estatutarias', 'finalidades_estatutarias', 'finalidadesEstatutarias'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'text'
	);

	private $tx_link_estatuto_osc = array(
		'apelidos'		=> ['tx_link_estatuto_osc', 'tx_link_estatuto', 'link_estatuto_osc', 'linkEstatutoOsc', 'link_estatuto', 'linkEstatuto'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'text'
	);

	private $bo_nao_possui_link_estatuto_osc = array(
		'apelidos'		=> ['bo_nao_possui_link_estatuto_osc', 'tx_nao_possui_link_estatuto', 'nao_possui_link_estatuto_osc', 'naoPossuiLinkEstatutoOsc', 'nao_possui_link_estatuto', 'naoPossuiLinkEstatuto'], 
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