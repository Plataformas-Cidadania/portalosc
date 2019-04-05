<?php

namespace App\Services\Usuario\EditarRepresentanteGoverno;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $id_usuario = array(
		'apelidos'		=> ['id_usuario', 'id'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
	private $tx_email_usuario = array(
		'apelidos'		=> ['tx_email_usuario', 'email_usuario', 'email'],
		'obrigatorio'	=> true,
		'tipo'			=> 'email'
	);
	
	private $tx_senha_usuario = array(
		'apelidos'		=> ['tx_senha_usuario', 'senha_usuario', 'senhaUsuario', 'senha'],
		'obrigatorio'	=> false,
		'tipo'			=> 'senha'
	);
	
	private $tx_nome_usuario = array(
		'apelidos'		=> ['tx_nome_usuario', 'nome_usuario', 'nomeUsuario', 'nome'],
		'obrigatorio'	=> true,
		'tipo'			=> 'string'
	);
	
	private $nr_cpf_usuario = array(
		'apelidos'		=> ['nr_cpf_usuario', 'cpf_usuario', 'cpfUsuario', 'cpf'],
		'obrigatorio'	=> false,
		'tipo'			=> 'cpf'
	);
	
	private $tx_telefone_1 = array(
		'apelidos'		=> ['tx_telefone_1', 'telefone_1', 'telefone'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'string'
	);

	private $tx_telefone_2 = array(
		'apelidos'		=> ['tx_telefone_2', 'telefone_2'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'string'
	);

	private $tx_orgao_usuario = array(
		'apelidos'		=> ['tx_orgao_usuario', 'orgao_usuario', 'orgaoUsuario', 'orgao'], 
		'obrigatorio'	=> true, 
		'tipo'			=> 'string'
	);

	private $tx_dado_institucional = array(
		'apelidos'		=> ['tx_dado_institucional', 'dado_institucional', 'dadoInstitucional', 'orgao'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'string'
	);

	private $cd_localidade = array(
		'apelidos'		=> ['cd_localidade', 'localidade'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'localidade'
	);

	private $tx_email_confirmacao = array(
		'apelidos'		=> ['tx_email_confirmacao', 'email_confirmacao', 'emailConfirmacao'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'email'
	);
	
	private $bo_lista_email = array(
		'apelidos'		=> ['bo_lista_email', 'lista_email', 'listaEmail'],
		'obrigatorio'	=> false,
		'tipo'			=> 'boolean', 
		'default'		=> false
	);
	
	private $bo_lista_atualizacao_trimestral = array(
		'apelidos'		=> ['bo_lista_atualizacao_trimestral', 'lista_atualizacao_trimestral', 'listaAtualizacaoTrimestral'], 
		'obrigatorio'	=> false, 
		'tipo'			=> 'boolean', 
		'default'		=> false
	);

    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}