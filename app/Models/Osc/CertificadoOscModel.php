<?php

namespace App\Models\Osc;

use App\Models\Model;

class CertificadoOscModel extends Model
{
	private $certificado = array(
			'apelidos'		=> ['certificado', 'cd_certificado', 'cdCertificado'],
			'obrigatorio'	=> true,
			'tipo'			=> 'integer'
	);
	
	private $dataInicio = array(
			'apelidos'		=> ['dataInicio', 'data_inicio', 'dt_inicio', 'dtInicio', 'dt_inicio_certificado', 'dtInicioCertificado'],
			'obrigatorio'	=> false,
			'tipo'			=> 'date'
	);
	
	private $dataFim = array(
			'apelidos'		=> ['dataFim', 'data_fim', 'dt_fim', 'dtFim', 'dt_fim_certificado', 'dtFimCertificado'],
			'obrigatorio'	=> false,
			'tipo'			=> 'date'
	);
	
	private $municipio = array(
			'apelidos'		=> ['municipio', 'cd_municipio', 'cdMunicipio', 'edmu_cd_municipio', 'edmuCdMunicipio'],
			'obrigatorio'	=> false,
			'tipo'			=> 'integer'
	);
	
	private $estado = array(
			'apelidos'		=> ['estado', 'cd_estado', 'cdEstado', 'uf', 'cd_uf', 'cdUf', 'eduf_cd_uf', 'edufCdUf'],
			'obrigatorio'	=> false,
			'tipo'			=> 'integer'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}