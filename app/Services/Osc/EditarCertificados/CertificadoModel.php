<?php

namespace App\Services\Osc\EditarCertificados;

use App\Services\BaseModel;

class CertificadoModel extends BaseModel{
	private $cd_certificado = array(
		'apelidos'		=> ['cd_certificado', 'cdCertificado', 'certificado'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);
	
	private $dt_inicio_certificado = array(
		'apelidos'		=> ['dt_inicio_certificado', 'dt_inicio', 'inicio_certificado', 'inicioCertificado', 'inicio'],
		'obrigatorio'	=> false,
		'tipo'			=> 'date'
	);
	
	private $dt_fim_certificado = array(
		'apelidos'		=> ['dt_fim_certificado', 'dt_fim', 'fim_certificado', 'fimCertificado', 'fim'],
		'obrigatorio'	=> false,
		'tipo'			=> 'date'
	);
	
	private $cd_municipio = array(
		'apelidos'		=> ['cd_municipio', 'edmu_cd_municipio', 'municipio'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
	private $cd_uf = array(
		'apelidos'		=> ['cd_uf', 'cd_estado', 'eduf_cd_uf', 'uf', 'estado'],
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