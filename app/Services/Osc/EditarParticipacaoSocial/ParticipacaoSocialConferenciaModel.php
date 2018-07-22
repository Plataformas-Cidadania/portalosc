<?php

namespace App\Services\Osc\EditarParticipacaoSocial;

use App\Services\BaseModel;

class ParticipacaoSocialConferenciaModel extends BaseModel{
	private $cd_conferencia = array(
		'apelidos'		=> ['conferencia', 'codigoConferencia', 'codigo_conferencia', 'codConferencia', 'cod_conferencia', 'cd_conferencia'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);

	private $cd_forma_participacao_conferencia = array(
		'apelidos'		=> ['formaParticipacao', 'forma_participacao', 'codigoPeriodicidadeReuniao', 'codigo_periodicidade_reuniao', 'codPeriodicidadeReuniao', 'cod_periodicidade_reuniao', 'cd_forma_participacao', 'cd_forma_participacao_conferencia'],
		'obrigatorio'	=> false,
		'tipo'			=> 'integer'
	);

	private $dt_ano_realizacao = array(
		'apelidos'		=> ['anoRealizacao', 'ano_realizacao', 'anoConferencia', 'ano_conferencia', 'anoRealizacaoConferencia', 'ano_realizacao_conferencia', 'dt_ano_realizacao'],
		'obrigatorio'	=> false,
		'tipo'			=> 'date'
	);

	private $tx_nome_conferencia_outro = array(
		'apelidos'		=> ['nomeConferenciaOutro', 'nome_conferencia_outro', 'tx_nome_conferencia_outro'],
		'obrigatorio'	=> false,
		'tipo'			=> 'date'
	);

    public function __construct($requisicao = null){
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}