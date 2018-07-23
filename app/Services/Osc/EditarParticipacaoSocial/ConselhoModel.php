<?php

namespace App\Services\Osc\EditarParticipacaoSocial;

use App\Services\BaseModel;

class ConselhoModel extends BaseModel{
	private $cd_conselho = array(
		'apelidos'		=> ['conselho', 'codigoConselho', 'codigo_conselho', 'codConselho', 'cod_conselho', 'cdConselho', 'cd_conselho'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);

	private $cd_tipo_participacao = array(
		'apelidos'		=> ['tipoParticipacao', 'tipo_participacao', 'codigoTipoParticipacao', 'codigo_tipo_participacao', 'codTipoParticipacao', 'cod_tipo_participacao', 'cdTipoParticipacao', 'cd_tipo_participacao'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);

	private $cd_periodicidade_reuniao_conselho = array(
		'apelidos'		=> ['periodicidadeReuniao', 'periodicidade_reuniao', 'codigoPeriodicidadeReuniao', 'codigo_periodicidade_reuniao', 'codPeriodicidadeReuniao', 'cod_periodicidade_reuniao', 'periodicidadeReuniao', 'periodicidade_reuniao', 'cd_periodicidade_reuniao', 'cd_periodicidade_reuniao_conselho'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);

	private $dt_data_inicio_conselho = array(
		'apelidos'		=> ['dataInicio', 'data_inicio', 'dataInicioConselho', 'data_inicio_conselho', 'dt_data_inicio_conselho'],
		'obrigatorio'	=> false,
		'tipo'			=> 'date'
	);

	private $dt_data_fim_conselho = array(
		'apelidos'		=> ['dataFim', 'data_fim', 'dataFimConselho', 'data_fim_conselho', 'dt_data_fim_conselho'],
		'obrigatorio'	=> false,
		'tipo'			=> 'date'
	);

	private $tx_nome_conselho_outro = array(
		'apelidos'		=> ['nomeConselhoOutro', 'nome_conselho_outro', 'tx_nome_conselho_outro'],
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