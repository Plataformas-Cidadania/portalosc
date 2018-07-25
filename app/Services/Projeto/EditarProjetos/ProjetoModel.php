<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseModel;

class ProjetoModel extends BaseModel{
	private $id_projeto = array(
		'apelidos'		=> ['id_projeto', 'idProjeto', 'id'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
	private $tx_nome_projeto = array(
		'apelidos'		=> ['tx_nome_projeto', 'tx_nome', 'nome_projeto', 'nomeProjeto', 'nome'],
		'obrigatorio'	=> false,
		'tipo'			=> 'text'
	);
	
	private $cd_status_projeto = array(
		'apelidos'		=> ['cd_status_projeto', 'cd_status', 'status_projeto', 'statusProjeto', 'status'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
	private $dt_data_inicio_projeto = array(
		'apelidos'		=> ['dt_data_inicio_projeto', 'dt_data_inicio', 'data_inicio_projeto', 'dataInicioProjeto', 'data_inicio', 'dataInicio', 'inicio'],
		'obrigatorio'	=> false,
		'tipo'			=> 'date'
	);
	
	private $dt_data_fim_projeto = array(
		'apelidos'		=> ['dt_data_fim_projeto', 'dt_data_fim', 'data_fim_projeto', 'dataFimProjeto', 'data_fim', 'dataFim', 'fim'],
		'obrigatorio'	=> false,
		'tipo'			=> 'date'
	);
	
	private $tx_link_projeto = array(
		'apelidos'		=> ['tx_link_projeto', 'tx_link', 'link_projeto', 'linkProjeto', 'link'],
		'obrigatorio'	=> false,
		'tipo'			=> 'text'
	);
	
	private $nr_total_beneficiarios = array(
		'apelidos'		=> ['nr_total_beneficiarios', 'nr_total_beneficiarios_projeto','nr_beneficiarios', 'total_beneficiarios', 'totalBeneficiarios', 'beneficiarios'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
	private $nr_valor_captado_projeto = array(
		'apelidos'		=> ['nr_valor_captado_projeto', 'nr_valor_captado', 'valor_captado_projeto', 'valorCaptadoProjeto', 'valor_captado', 'valorCaptado'],
		'obrigatorio'	=> false,
		'tipo'			=> 'double'
	);
	
	private $nr_valor_total_projeto = array(
		'apelidos'		=> ['nr_valor_total_projeto', 'nr_valor_total', 'valor_total_projeto', 'valorTotalProjeto', 'valor_total', 'valorTotal'],
		'obrigatorio'	=> false,
		'tipo'			=> 'double'
	);
	
	private $cd_abrangencia_projeto = array(
		'apelidos'		=> ['cd_abrangencia_projeto', 'cd_abrangencia', 'abrangencia_projeto', 'abrangenciaProjeto', 'abrangencia'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
	private $cd_zona_atuacao_projeto = array(
		'apelidos'		=> ['cd_zona_atuacao_projeto', 'cd_zona_atuacao', 'zona_atuacao', 'zonaAtuacao'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
	private $tx_descricao_projeto = array(
		'apelidos'		=> ['tx_descricao_projeto', 'tx_descricao', 'descricao_projeto', 'descricaoProjeto', 'descricao'],
		'obrigatorio'	=> false,
		'tipo'			=> 'text'
	);
	
	private $tx_metodologia_monitoramento = array(
		'apelidos'		=> ['tx_metodologia_monitoramento', 'tx_metodologia_monitoramento_projeto', 'metodologia_monitoramento', 'metodologiaMonitoramento', 'metodologia_monitoramento_projeto', 'metodologiaMonitoramentoProjeto'],
		'obrigatorio'	=> false,
		'tipo'			=> 'text'
	);
	
	private $tx_identificador_projeto_externo = array(
		'apelidos'		=> ['tx_identificador_projeto_externo', 'identificador_projeto_externo', 'identificadorProjetoExterno'],
		'obrigatorio'	=> false,
		'tipo'			=> 'text'
	);
	
	private $cd_municipio = array(
		'apelidos'		=> ['cd_municipio', 'municipio'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
	
	private $cd_uf = array(
		'apelidos'		=> ['cd_uf', 'uf'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);
    
	private $financiador = array(
		'apelidos'		=> ['financiador'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Projeto\EditarProjetos\FinanciadorModel',
		'default'		=> []
	);
    
	private $fonte_recursos = array(
		'apelidos'		=> ['fonteRecursos', 'fonte_recursos'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Projeto\EditarProjetos\FonteRecursosModel',
		'default'		=> []
	);
    
	private $localizacao = array(
		'apelidos'		=> ['localizacao'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Projeto\EditarProjetos\LocalizacaoModel',
		'default'		=> []
	);
    
	private $objetivo = array(
		'apelidos'		=> ['objetivo'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Projeto\EditarProjetos\ObjetivoModel',
		'default'		=> []
	);
    
	private $publico_beneficiado = array(
		'apelidos'		=> ['publicoBeneficiado', 'publico_beneficiado'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Projeto\EditarProjetos\PublicoBeneficiadoModel',
		'default'		=> []
	);
    
	private $tipo_parceria = array(
		'apelidos'		=> ['tipoParceria', 'tipo_parceria'],
		'obrigatorio'	=> false,
		'tipo'			=> 'arrayObject',
		'modelo'		=> 'App\Services\Projeto\EditarProjetos\TipoParceriaModel',
		'default'		=> []
	);
	
    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}