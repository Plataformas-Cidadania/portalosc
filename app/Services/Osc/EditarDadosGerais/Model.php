<?php

namespace App\Services\Osc\EditarDadosGerais;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $tx_apelido_osc = array(
			'apelidos'		=> ['apelido', 'txApelido', 'tx_apelido', 'txApelidoOsc', 'tx_apelido_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $im_logo = array(
			'apelidos'		=> ['logo', 'imLogo', 'im_logo'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $tx_nome_fantasia_osc = array(
			'apelidos'		=> ['nomeFantasiaOsc', 'nome_fantasia_osc', 'nomeFantasia', 'nome_fantasia', 'txNomeFantasia', 'tx_nome_fantasia', 'txNomeFantasiaOsc', 'tx_nome_fantasia_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $tx_sigla_osc = array(
			'apelidos'		=> ['sigla', 'siglaOsc', 'sigla_osc', 'txSiglaOsc', 'tx_sigla_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $bo_nao_possui_sigla_osc = array(
			'apelidos'		=> ['naoPossuiSigla', 'nao_possui_sigla', 'boNaoPossuiSigla', 'bo_nao_possui_sigla', 'boNaoPossuiSiglaOsc', 'bo_nao_possui_sigla_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $cd_situacao_imovel_osc = array(
			'apelidos'		=> ['situacaoImovel', 'situacao_imovel', 'situacaoImovelOsc', 'situacao_imovel_osc', 'cdSituacaoImovel', 'cd_situacao_imovel', 'cdSituacaoImovelOsc', 'cd_situacao_imovel_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $tx_nome_responsavel_legal = array(
			'apelidos'		=> ['responsavel', 'responsavelLegal', 'responsavel_legal', 'nomeResponsavelLegal', 'nome_responsavel_legal', 'txNomeResponsavelLegal', 'tx_nome_responsavel_legal'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $dt_ano_cadastro_cnpj = array(
			'apelidos'		=> ['dataCadastroCnpj', 'data_cadastro_cnpj', 'anoCadastroCnpj', 'ano_cadastro_cnpj', 'dtDataCadastroCnpj', 'dt_data_cadastro_cnpj', 'dtAnoCadastroCnpj', 'dt_ano_cadastro_cnpj'],
			'obrigatorio'	=> false,
			'tipo'			=> 'date'
	);

	private $dt_fundacao_osc = array(
			'apelidos'		=> ['dataFundacao', 'data_fundacao', 'dataFundacaoOsc', 'data_fundacao_osc', 'anoFundacao', 'ano_fundacao', 'anoFundacaoOsc', 'ano_fundacao_osc', 'dtDataFundacao', 'dt_data_fundacao', 'dtDataFundacaoOsc', 'dt_data_fundacao_osc', 'dtAnoFundacao', 'dt_ano_fundacao', 'dtAnoFundacaoOsc', 'dt_ano_fundacao_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'date'
	);

	private $tx_resumo_osc = array(
			'apelidos'		=> ['resumo', 'resumoOsc', 'resumo_osc', 'txResumoOsc', 'tx_resumo_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $tx_telefone = array(
			'apelidos'		=> ['telefone', 'telefoneOsc', 'telefone_osc', 'txTelefone', 'tx_telefone', 'txTelefoneOsc', 'tx_telefone_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $tx_email = array(
			'apelidos'		=> ['email', 'emailOsc', 'email_osc', 'txEmail', 'tx_email', 'txEmailOsc', 'tx_email_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $bo_nao_possui_email = array(
			'apelidos'		=> ['naoPossuiEmail', 'nao_possui_email', 'boNaoPossuiEmail', 'bo_nao_possui_email'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $tx_site = array(
			'apelidos'		=> ['site', 'siteOsc', 'site_osc', 'txSite', 'tx_site', 'txSiteOsc', 'tx_site_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $bo_nao_possui_site = array(
			'apelidos'		=> ['naoPossuiSite', 'nao_possui_site', 'boNaoPossuiSite', 'bo_nao_possui_site'],
			'obrigatorio'	=> false,
			'tipo'			=> 'string'
	);

	private $objetivo_metas = array(
			'apelidos'		=> ['objetivoMeta', 'objetivo_meta', 'objetivoMetaOsc', 'objetivo_meta_osc', 'objetivoMetas', 'objetivo_metas', 'objetivoMetasOsc', 'objetivo_metas_osc', 'objetivo', 'meta', 'objetivoOsc', 'objetivo_osc', 'metaOsc', 'meta_osc'],
			'obrigatorio'	=> false,
			'tipo'			=> 'arrayObject',
			'modelo'		=> 'App\Services\Osc\EditarDadosGerais\ObjetivoMetaModel'
	);

    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}