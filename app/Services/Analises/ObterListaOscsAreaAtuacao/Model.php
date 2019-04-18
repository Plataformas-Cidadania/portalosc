<?php

namespace App\Services\Analises\ObterListaOscsAreaAtuacao;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $area_atuacao = array(
		'apelidos' => ['area_atuacao', 'cd_area_atuacao', 'areaAtuacao'], 
		'obrigatorio' => true, 
		'tipo' => 'integer'
	);

	private $cd_municipio = array(
		'apelidos' => ['cd_municipio', 'municipio'], 
		'obrigatorio' => false, 
		'tipo' => 'integer'
	);
	
	private $latitude = array(
		'apelidos' => ['latitude', 'lat'], 
		'obrigatorio' => false, 
		'tipo' => 'double'
	);
	
	private $longitude = array(
		'apelidos' => ['longitude', 'long', 'lon', 'lng'], 
		'obrigatorio' => false, 
		'tipo' => 'double'
	);
	
	private $limite = array(
		'apelidos' => ['limite', 'limit', 'quantidade'], 
		'obrigatorio' => false, 
		'tipo' => 'integer'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}