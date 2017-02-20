<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Dao\OscDao;
use App\Dao\LogDao;
use App\Util\FormatacaoUtil;
use Illuminate\Http\Request;
use DB;

class OscController extends Controller
{
	private $dao;
    private $log;
	private $ft_representante;
	private $formatacaoUtil;

	public function __construct()
	{
		$this->dao = new OscDao();
		$this->ft_representante = 'Representante';
		$this->log = new LogDao();
		$this->formatacaoUtil = new FormatacaoUtil();
	}

	public function getPopupOsc($id)
	{
		$id = trim($id);
        $resultDao = $this->dao->getPopupOsc($id);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function getComponentOsc($component, $param)
	{
		$component = trim($component);
		$id = trim($param);
		$resultDao = $this->dao->getComponentOsc($component, $param);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function getOsc($param)
	{
		$id = trim($param);
    	$resultDao = array();
		$resultDao = $this->dao->getOsc($param);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function getOscNoProject($param)
	{
		$id = trim($param);
    	$resultDao = array();
		$resultDao = $this->dao->getOsc($param, false);
		$this->configResponse($resultDao);
        return $this->response();
    }

	public function setDadosGerais(Request $request, $id_osc)
    {
        $id_usuario = $request->user()->id;

    	$dados_gerais_db = DB::select('SELECT * FROM osc.tb_dados_gerais WHERE id_osc = ?::int',[$id]);

		if($dados_gerais_db){
	    	foreach($dados_gerais_db as $key => $value){
		    	$im_logo = $value->im_logo;
				$ft_logo = $value->ft_logo;
				if($request->input('im_logo')){
					$im_logo = $request->input('im_logo');
					if($value->im_logo != $im_logo){
						$ft_nome_fantasia = $this->ft_representante;

		                $tx_nome_campo = 'im_logo';
						$id_tabela = $value->id_osc;
		                $tx_dado_anterior = $value->im_logo;
		                $tx_dado_posterior = $im_logo;
						$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
					}
				}

		    	$tx_nome_fantasia_osc = $value->tx_nome_fantasia_osc;
				$ft_nome_fantasia_osc = $value->ft_nome_fantasia_osc;
				if($request->input('tx_nome_fantasia_osc')){
					$tx_nome_fantasia_osc = $request->input('tx_nome_fantasia_osc');
					if($value->tx_nome_fantasia_osc != $tx_nome_fantasia_osc){
						$ft_nome_fantasia_osc = $this->ft_representante;

		                $tx_nome_campo = 'tx_nome_fantasia_osc';
						$id_tabela = $value->id_osc;
		                $tx_dado_anterior = $value->tx_nome_fantasia_osc;
		                $tx_dado_posterior = $tx_nome_fantasia_osc;
						$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
					}
				}

		    	$tx_sigla_osc = $value->tx_sigla_osc;
				$ft_sigla_osc = $value->ft_sigla_osc;
				if($request->input('tx_sigla_osc')){
					$tx_sigla_osc = $request->input('tx_sigla_osc');
					if($value->tx_sigla_osc != $tx_sigla_osc){
						$ft_sigla_osc = $this->ft_representante;

		                $tx_nome_campo = 'tx_sigla_osc';
						$id_tabela = $value->id_osc;
		                $tx_dado_anterior = $value->tx_sigla_osc;
		                $tx_dado_posterior = $tx_sigla_osc;
						$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
					}
				}

		    	$tx_nome_responsavel_legal = $value->tx_nome_responsavel_legal;
				$ft_nome_responsavel_legal = $value->ft_nome_responsavel_legal;
				if($request->input('tx_nome_responsavel_legal')){
					$tx_nome_responsavel_legal = $request->input('tx_nome_responsavel_legal');
					if($value->tx_nome_responsavel_legal != $tx_nome_responsavel_legal){
						$ft_sigla_osc = $this->ft_representante;

		                $tx_nome_campo = 'tx_nome_responsavel_legal';
						$id_tabela = $value->id_osc;
		                $tx_dado_anterior = $value->tx_nome_responsavel_legal;
		                $tx_dado_posterior = $tx_nome_responsavel_legal;
						$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
					}
				}

		    	$dt_ano_cadastro_cnpj = $value->dt_ano_cadastro_cnpj;
				$ft_ano_cadastro_cnpj = $value->ft_ano_cadastro_cnpj;
				if($request->input('dt_ano_cadastro_cnpj')){
					$dt_ano_cadastro_cnpj = $request->input('dt_ano_cadastro_cnpj');
					if(strlen($dt_ano_cadastro_cnpj) == 4){
						$dt_ano_cadastro_cnpj = $dt_ano_cadastro_cnpj.'-01-01';
					}

					if($value->dt_ano_cadastro_cnpj != $dt_ano_cadastro_cnpj){
						$ft_ano_cadastro_cnpj = $this->ft_representante;

		                $tx_nome_campo = 'dt_ano_cadastro_cnpj';
						$id_tabela = $value->id_osc;
		                $tx_dado_anterior = $value->dt_ano_cadastro_cnpj;
		                $tx_dado_posterior = $dt_ano_cadastro_cnpj;
						$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
					}
				}

		    	$dt_fundacao_osc = $value->dt_fundacao_osc;
				$ft_fundacao_osc = $value->ft_fundacao_osc;
				if($request->input('dt_fundacao_osc')){
					$dt_fundacao_osc = $request->input('dt_fundacao_osc');
					if(strlen($dt_fundacao_osc) == 4){
						$dt_fundacao_osc = $dt_fundacao_osc.'-01-01';
					}

					if($value->dt_fundacao_osc != $dt_fundacao_osc){
						$ft_fundacao_osc = $this->ft_representante;

		                $tx_nome_campo = 'dt_fundacao_osc';
						$id_tabela = $value->id_osc;
		                $tx_dado_anterior = $value->dt_fundacao_osc;
		                $tx_dado_posterior = $tx_nome_responsavel_legal;
						$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
					}
				}

		    	$tx_resumo_osc = $value->tx_resumo_osc;
				$ft_resumo_osc = $value->ft_resumo_osc;
				if($request->input('tx_resumo_osc')){
					$tx_resumo_osc = $request->input('tx_resumo_osc');
					if($value->tx_resumo_osc != $tx_resumo_osc){
						$ft_sigla_osc = $this->ft_representante;

		                $tx_nome_campo = 'tx_resumo_osc';
						$id_tabela = $value->id_osc;
		                $tx_dado_anterior = $value->tx_resumo_osc;
		                $tx_dado_posterior = $tx_nome_responsavel_legal;
						$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
					}
				}

				$this->setApelido($request, $id_osc);
				$this->setContatos($request, $id_osc);
	    	}

			$params = [$id_osc, $im_logo, $ft_logo];
	    	$resultDao = $this->dao->updateLogo($params);

	    	$params = [$id_osc, $nome_fantasia, $ft_nome_fantasia, $sigla, $ft_sigla, $cd_situacao_imovel, $ft_situacao_imovel, $nome_responsavel_legal, $ft_nome_responsavel_legal, $ano_cadastro_cnpj, $ft_ano_cadastro_cnpj, $dt_fundacao, $ft_fundacao, $resumo, $ft_resumo];
	    	$resultDao = $this->dao->updateDadosGerais($params);

	    	$result = ['msg' => $resultDao->mensagem];
    		$this->configResponse($result);
    	}else{
    		$result = ['msg' => 'Não existe OSC com este ID.'];
    		$this->configResponse($result, 400);
    	}

    	return $this->response();
    }

    private function setApelido(Request $request, $id)
    {
        $id_usuario = $request->user()->id;

    	$osc_db = DB::select('SELECT * FROM osc.tb_osc WHERE id_osc = ?::int',[$id]);
    	foreach($osc_db as $key => $value){
			$tx_apelido_osc = $value->tx_apelido_osc;
			$ft_apelido_osc = $value->ft_apelido_osc;
			if($request->input('tx_apelido_osc')){
				$tx_apelido_osc = $request->input('tx_apelido_osc');
				if($value->tx_apelido_osc != $tx_apelido_osc){
					$ft_sigla_osc = $this->ft_representante;

					$tx_nome_campo = 'tx_apelido_osc';
					$id_tabela = $value->id_osc;
					$tx_dado_anterior = $value->tx_apelido_osc;
					$tx_dado_posterior = $tx_nome_responsavel_legal;
					$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
			}
    	}

    	$params = [$id_osc, $tx_apelido_osc, $ft_apelido_osc];
    	$result = $this->dao->updateApelido($params);
    }

	private function setContatos(Request $request, $id_osc)
	{
		$flag_contatos = false;
		if($request->input('tx_telefone')){
			$flag_contatos = true;
		}
		if($request->input('tx_email')){
			$flag_contatos = true;
		}
		if($request->input('tx_site')){
			$flag_contatos = true;
		}

		if($flag_contatos){
			$contatos_db = DB::select('SELECT * FROM osc.tb_contato WHERE id_osc = ?::INTEGER', [$id_osc]);
			if($contatos_db){
				$this->updateContatos($request, $id_osc, $contatos_db);
			}
			else{
				$this->insertContatos($request, $id_osc);
			}
		}
	}

    public function updateContatos(Request $request, $id_osc, $contatos_db)
    {
        $id_usuario = $request->user()->id;

		foreach($contatos_db as $key => $value){
			$tx_telefone = $value->tx_telefone;
			$ft_telefone = $value->ft_telefone;
			if($request->input('tx_telefone')){
				$tx_resumo_osc = $request->input('tx_telefone');
				if($value->tx_telefone != $tx_telefone){
					$ft_sigla_osc = $this->ft_representante;

					$tx_nome_campo = 'tx_telefone';
					$id_tabela = $value->id_osc;
					$tx_dado_anterior = $value->tx_telefone;
					$tx_dado_posterior = $tx_nome_responsavel_legal;
					$resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
			}

			$tx_email = $value->tx_email;
			$ft_email = $value->ft_email;
			if($request->input('tx_email')){
				$tx_resumo_osc = $request->input('tx_email');
				if($value->tx_email != $tx_email){
					$ft_sigla_osc = $this->ft_representante;

					$tx_nome_campo = 'tx_email';
					$id_tabela = $value->id_osc;
					$tx_dado_anterior = $value->tx_email;
					$tx_dado_posterior = $tx_nome_responsavel_legal;
					$resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
			}

			$tx_site = $value->tx_site;
			$ft_site = $value->ft_site;
			if($request->input('tx_site')){
				$tx_resumo_osc = $request->input('tx_site');
				if($value->tx_site != $tx_site){
					$ft_sigla_osc = $this->ft_representante;

					$tx_nome_campo = 'tx_site';
					$id_tabela = $value->id_osc;
					$tx_dado_anterior = $value->tx_site;
					$tx_dado_posterior = $tx_nome_responsavel_legal;
					$resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
			}
		}

		$params = [$id_osc, $tx_telefone, $ft_telefone, $tx_email, $ft_email, $tx_site, $ft_site];
		$result = $this->dao->updateContatos($params);
    }

	private function insertContatos(Request $request, $id)
	{
        $id_usuario = $request->user()->id;

		$tx_telefone = null;
		$ft_telefone = null;
		if($request->input('tx_telefone')){
			$tx_telefone = $request->input('tx_telefone');
	        $ft_telefone = $this->ft_representante;

	        $tx_nome_campo = 'tx_telefone';
	        $id_tabela = $value->id_osc;
	        $tx_dado_anterior = $value->tx_telefone;
	        $tx_dado_posterior = $telefone;
	        $resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
		}

		$tx_email = null;
		$ft_email = null;
		if($request->input('tx_email')){
	    	$tx_email = $request->input('tx_email');
	        $ft_email = $this->ft_representante;

	        $tx_nome_campo = 'tx_email';
	        $id_tabela = $value->id_osc;
	        $tx_dado_anterior = $value->tx_email;
	        $tx_dado_posterior = $email;
	        $resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
		}

		$tx_site = null;
		$ft_site = null;
		if($request->input('tx_site')){
	    	$tx_site = $request->input('tx_site');
	        $ft_site = $this->ft_representante;

	        $tx_nome_campo = 'tx_site';
	        $id_tabela = $value->id_osc;
	        $tx_dado_anterior = $value->tx_site;
	        $tx_dado_posterior = $site;
	        $resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
		}

		$params = [$id, $tx_telefone, $ft_telefone, $tx_email, $ft_email, $tx_site, $ft_site];
		$result = $this->dao->insertContatos($params);
	}

    public function setAreaAtuacao(Request $request, $id_osc)
    {
    	$area_atuacao_req = $request->area_atuacao;

		$query = "SELECT cd_area_atuacao, tx_nome_outra AS tx_nome_area_atuacao_outra, cd_subarea_atuacao, tx_nome_outra AS tx_nome_subarea_atuacao_outra, bo_oficial FROM osc.tb_area_atuacao WHERE id_osc = ?;";
		$area_atuacao_osc = DB::select($query, [$id_osc]);

		$array_insert = array();
		$array_update = array();
		$array_delete = $area_atuacao_osc;
		$array_area_atuacao_outra = array();

		$cd_area_atuacao_outra = 10;
		$array_cd_subarea_atuacao_outra = array(2, 5, 8, 16, 18, 20, 25, 28, 34);

		$array_macro = array();

    	foreach($area_atuacao_req as $key_area => $value_area){
			$cd_area_atuacao = $value_area['cd_area_atuacao'];
			$tx_nome_outra = $value_area['tx_nome_area_atuacao_outra'];

            $cd_subarea_atuacao = null;
			if(isset($value_area['subarea_atuacao'])){
    			foreach($value_area['subarea_atuacao'] as $key_subarea => $value_subarea){
    				$cd_subarea_atuacao = $value_subarea['cd_subarea_atuacao'];
					$tx_nome_outra = $value_subarea['tx_nome_subarea_atuacao_outra'];

					$params = ["cd_area_atuacao" => $cd_area_atuacao, "cd_subarea_atuacao"=>$cd_subarea_atuacao, "tx_nome_outra"=>$tx_nome_outra];

					$flag = true;
					foreach ($area_atuacao_osc as $key_area_osc => $value_area_osc) {
						if($value_area_osc->cd_area_atuacao == $cd_area_atuacao && $value_area_osc->cd_subarea_atuacao == $cd_subarea_atuacao){
							if($value_area_osc->tx_nome_subarea_atuacao_outra != $tx_nome_outra && in_array($params['cd_subarea_atuacao'], $array_cd_subarea_atuacao_outra)){
								array_push($array_update, $params);
							}
							$flag = false;
							if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
						}
					}

					if($flag){
						array_push($array_insert, $params);
						if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
					}

					foreach ($array_delete as $key_area_del => $value_area_del) {
						if($value_area_del->cd_area_atuacao == $cd_area_atuacao && $value_area_del->cd_subarea_atuacao == $cd_subarea_atuacao){
							unset($array_delete[$key_area_del]);
						}
					}
    			}
			}
			else{
				$params = ["cd_area_atuacao"=>$cd_area_atuacao, "cd_subarea_atuacao"=> null, "tx_nome_outra"=>$tx_nome_outra];

				$flag = true;

				foreach ($area_atuacao_osc as $key_area_osc => $value_area_osc) {
					if($value_area_osc->cd_area_atuacao == $cd_area_atuacao && $value_area_osc->cd_subarea_atuacao == null){
						if($value_area_osc->tx_nome_area_atuacao_outra != $tx_nome_outra && $params['cd_area_atuacao'] == $cd_area_atuacao_outra){
							array_push($array_update, $params);
						}
						$flag = false;
						if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
					}
				}

				if($flag){
					array_push($array_insert, $params);
					if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
				}

				foreach ($array_delete as $key_area_del => $value_area_del) {
					if($value_area_del->cd_area_atuacao == $cd_area_atuacao && $value_area_del->cd_subarea_atuacao == $cd_subarea_atuacao){
						unset($array_delete[$key_area_del]);
					}
				}
			}
		}

		foreach($array_delete as $key => $value){
			if($value->bo_oficial){
				unset($array_delete[$key]);
			}
		}

		if(count($array_macro) > 2){
			$result = ['msg' => 'Quantidades de áreas maior do que o permitido.'];
			$this->configResponse($result, 400);
		}
		else{
			foreach($array_update as $key => $value){
				$this->updateAreaAtuacao($value, $id_osc);
			}

			foreach($array_insert as $key => $value){
				$this->insertAreaAtuacao($value, $id_osc);
			}

			foreach($array_delete as $key => $value){
				$this->deleteAreaAtuacao($value, $id_osc);
			}

			$result = ['msg' => 'Área de atuação atualizada.'];
			$this->configResponse($result, 200);
		}

		return $this->response();
    }

    private function updateAreaAtuacao($params, $id_osc)
    {
    	$cd_area_atuacao = $params['cd_area_atuacao'];
    	$cd_subarea_atuacao = $params['cd_subarea_atuacao'];
		$tx_nome_outra = $params['tx_nome_outra'];
    	$bo_oficial = false;

    	$params = [$id_osc, $cd_area_atuacao, $cd_subarea_atuacao, $tx_nome_outra, $this->ft_representante, $bo_oficial];
    	$result = $this->dao->updateAreaAtuacao($params);

    	return $result;
    }

    private function insertAreaAtuacao($params, $id_osc)
    {
    	$cd_area_atuacao = $params['cd_area_atuacao'];
    	$cd_subarea_atuacao = $params['cd_subarea_atuacao'];
		$tx_nome_outra = $params['tx_nome_outra'];
    	$bo_oficial = false;

    	$params = [$id_osc, $cd_area_atuacao, $cd_subarea_atuacao, $tx_nome_outra, $this->ft_representante, $bo_oficial];
    	$result = $this->dao->insertAreaAtuacao($params);

    	return $result;
    }

    private function deleteAreaAtuacao($params, $id_osc)
    {
    	$cd_area_atuacao = $params->cd_area_atuacao;
    	$cd_subarea_atuacao = $params->cd_subarea_atuacao;

    	$params = [$id_osc, $cd_area_atuacao, $cd_subarea_atuacao];
    	$result = $this->dao->deleteAreaAtuacao($params);

    	return $result;
    }

    public function setAreaAtuacaoOutra(Request $request)
    {
    	$id = $request->input('id_osc');
    	$nome_area_atuacao_declarada = $request->input('tx_nome_area_atuacao_declarada');
    	if($nome_area_atuacao_declarada != null) $ft_nome_area_atuacao_declarada = $this->ft_representante;
    	else $ft_nome_area_atuacao_declarada = $request->input('ft_nome_area_atuacao_declarada');

    	$params = [$id, $ft_area_declarada, $nome_area_atuacao_declarada, $ft_nome_area_atuacao_declarada];
    	$result = $this->dao->setAreaAtuacaoOutra($params);
    }

    public function deleteAreaAtuacaoOutra($id_areaoutra, $id)
    {
    	$params = [$id_areaoutra];
    	$result = $this->dao->deleteAreaAtuacaoOutra($params);
    }

    public function updateDescricao(Request $request, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_dados_gerais WHERE id_osc = ?::int',[$id]);

    	foreach($json as $key => $value){
	    	$historico = $request->input('tx_historico');
	    	if($value->tx_historico != $historico) $ft_historico = $this->ft_representante;
	    	else $ft_historico = $request->input('ft_historico');

	    	$missao = $request->input('tx_missao_osc');
	    	if($value->tx_missao_osc != $missao) $ft_missao = $this->ft_representante;
	    	else $ft_missao = $request->input('ft_missao_osc');

	    	$visao = $request->input('tx_visao_osc');
	    	if($value->tx_visao_osc != $visao) $ft_visao = $this->ft_representante;
	    	else $ft_visao = $request->input('ft_visao_osc');

	    	$finalidades_estatutarias = $request->input('tx_finalidades_estatutarias');
	    	if($value->tx_finalidades_estatutarias != $finalidades_estatutarias) $ft_finalidades_estatutarias = $this->ft_representante;
	    	else $ft_finalidades_estatutarias = $request->input('ft_finalidades_estatutarias');

	    	$link_estatuto = $request->input('tx_link_estatuto_osc');
	    	if($value->tx_link_estatuto_osc != $link_estatuto) $ft_link_estatuto = $this->ft_representante;
	    	else $ft_link_estatuto = $request->input('ft_link_estatuto_osc');
    	}

    	$params = [$id, $historico, $ft_historico, $missao, $ft_missao, $visao, $ft_visao, $finalidades_estatutarias, $ft_finalidades_estatutarias, $link_estatuto, $ft_link_estatuto];
    	$resultDao = $this->dao->updateDescricao($params);
    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

	public function setCertificado(Request $request, $id_osc)
	{
		$certificado_req = $request->certificado;

		$query = "SELECT cd_certificado, bo_oficial FROM osc.tb_certificado WHERE id_osc = ?::INTEGER;";
		$certificado_osc = DB::select($query, [$id_osc]);

		$array_insert = array();
		$array_delete = $certificado_osc;

		foreach($certificado_req as $key_area => $value_area){
			$cd_certificado = $value_area['cd_certificado'];

			$dt_inicio_certificado = null;
			if($value_area['dt_inicio_certificado']){
				$date = date_create($value_area['dt_inicio_certificado']);
				$dt_inicio_certificado = date_format($date, "Y-m-d");
			}

			$dt_fim_certificado = null;
			if($value_area['dt_fim_certificado']){
				$date = date_create($value_area['dt_fim_certificado']);
				$dt_fim_certificado = date_format($date, "Y-m-d");
			}

			$params = ["cd_certificado" => $cd_certificado, "dt_inicio_certificado" => $dt_inicio_certificado, "dt_fim_certificado" => $dt_fim_certificado];

			$flag = true;
			foreach ($certificado_osc as $key_certificado_osc => $value_certificado_osc) {
				if($value_certificado_osc->cd_certificado == $cd_certificado){
					$flag = false;
				}
			}

			if($flag){
				array_push($array_insert, $params);
			}

			foreach ($array_delete as $key_certificado_del => $value_certificado_del) {
				if($value_certificado_del->cd_certificado == $cd_certificado){
					unset($array_delete[$key_certificado_del]);
				}
			}
		}

		foreach($array_insert as $key => $value){
			$this->insertCertificado($value, $id_osc);
		}

		$flag_error_delete = false;
		foreach($array_delete as $key => $value){
			if($value->bo_oficial){
				$flag_error_delete = true;
			}
			else{
				$this->deleteCertificado($value, $id_osc);
			}
		}

		if($flag_error_delete){
			$result = ['msg' => 'Certificados atualizados.'];
			$this->configResponse($result, 200);
		}
		else{
			$result = ['msg' => 'Certificados atualizados.'];
			$this->configResponse($result, 200);
		}

		return $this->response();
	}

	private function insertCertificado($params, $id_osc)
	{
		$cd_certificado = $params['cd_certificado'];
		$dt_inicio_certificado = $params['dt_inicio_certificado'];
		$dt_fim_certificado = $params['dt_fim_certificado'];
		$bo_oficial = false;

		$params = [$id_osc, $cd_certificado, $this->ft_representante, $dt_inicio_certificado, $this->ft_representante, $dt_fim_certificado, $this->ft_representante, $bo_oficial];
		$result = $this->dao->insertCertificado($params);

		return $result;
	}

	private function deleteCertificado($params, $id_osc)
	{
		$cd_certificado = $params->cd_certificado;
		$params = [$id_osc, $cd_certificado];
		$result = $this->dao->deleteCertificado($params);

		return $result;
	}

    public function setDirigente(Request $request)
    {
    	$id = $request->input('id_osc');
    	$cargo = $request->input('tx_cargo_dirigente');
    	if($cargo != null) $fonte_cargo = $this->ft_representante;
    	else $fonte_cargo = $request->input('ft_cargo_dirigente');

    	$nome = $request->input('tx_nome_dirigente');
    	if($nome != null) $fonte_nome = $this->ft_representante;
    	else $fonte_nome = $request->input('ft_nome_dirigente');

    	$bo_oficial = false;

    	$params = [$id, $cargo, $fonte_cargo, $nome, $fonte_nome, $bo_oficial];
    	$result = $this->dao->setDirigente($params);
    }

    public function updateDirigente(Request $request, $id)
    {
    	$id_dirigente = $request->input('id_dirigente');

    	$json = DB::select('SELECT * FROM osc.tb_governanca WHERE id_dirigente = ?::int',[$id_dirigente]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
	    		$cargo = $request->input('tx_cargo_dirigente');
	    		if($value->tx_cargo_dirigente != $cargo) $fonte_cargo = $this->ft_representante;
	    		else $fonte_cargo = $request->input('ft_cargo_dirigente');

	    		$nome = $request->input('tx_nome_dirigente');
	    		if($value->tx_nome_dirigente != $nome) $fonte_nome = $this->ft_representante;
	    		else $fonte_nome = $request->input('ft_nome_dirigente');

	    		$params = [$id, $id_dirigente, $cargo, $fonte_cargo, $nome, $fonte_nome];
	    		$resultDao = $this->dao->updateDirigente($params);
	    		$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function deleteDirigente($id_dirigente, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_governanca WHERE id_dirigente = ?::int',[$id_dirigente]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_dirigente];
    			$resultDao = $this->dao->deleteDirigente($params);
    			$result = ['msg' => 'Dirigente excluido'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setMembroConselho(Request $request)
    {
    	$id = $request->input('id_osc');
    	$nome = $request->input('tx_nome_conselheiro');
    	if($nome != null) $fonte_nome = $this->ft_representante;
    	else $fonte_nome = $request->input('ft_nome_conselheiro');

    	$bo_oficial = false;

    	$params = [$id, $nome, $fonte_nome, $bo_oficial];
    	$result = $this->dao->setMembroConselho($params);
    }

    public function updateMembroConselho(Request $request, $id)
    {
    	$id_conselheiro = $request->input('id_conselheiro');

    	$json = DB::select('SELECT * FROM  osc.tb_conselho_fiscal WHERE id_conselheiro = ?::int',[$id_conselheiro]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$nome = $request->input('tx_nome_conselheiro');
    			if($value->tx_nome_conselheiro != $nome) $fonte_nome = $this->ft_representante;
    			else $fonte_nome = $request->input('ft_nome_conselheiro');

    			$params = [$id, $id_conselheiro, $nome, $fonte_nome];
    			$resultDao = $this->dao->updateMembroConselho($params);
    			$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function deleteMembroConselho($id_membro, $id)
    {
    	$json = DB::select('SELECT * FROM  osc.tb_conselho_fiscal WHERE id_conselheiro = ?::int',[$id_membro]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_membro];
    			$resultDao = $this->dao->deleteMembroConselho($params);
    			$result = ['msg' => 'Membro do Conselho excluido'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function trabalhadores(Request $request, $id)
    {
    	$result = DB::select('SELECT * FROM osc.tb_relacoes_trabalho WHERE id_osc = ?::int',[$id]);
    	if($result != null)
    		$this->updateTrabalhadores($request, $id);
    	else
    		$this->setTrabalhadores($request, $id);
    }

    public function setTrabalhadores(Request $request, $id)
    {
       	$nr_trabalhadores_voluntarios = $request->input('nr_trabalhadores_voluntarios');
    	if($nr_trabalhadores_voluntarios != null) $ft_trabalhadores_voluntarios = $this->ft_representante;
    	else $ft_trabalhadores_voluntarios = $request->input('ft_trabalhadores_voluntarios');

    	$params = [$id, $nr_trabalhadores_voluntarios, $ft_trabalhadores_voluntarios];
    	$result = $this->dao->setTrabalhadores($params);
    }

    public function updateTrabalhadores(Request $request, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_relacoes_trabalho WHERE id_osc = ?::int',[$id]);
    	foreach($json as $key => $value){
	    	$nr_trabalhadores_voluntarios = $request->input('nr_trabalhadores_voluntarios');
	    	if($value->nr_trabalhadores_voluntarios != $nr_trabalhadores_voluntarios) $ft_trabalhadores_voluntarios = $this->ft_representante;
	    	else $ft_trabalhadores_voluntarios = $request->input('ft_trabalhadores_voluntarios');
    	}

    	$params = [$id, $nr_trabalhadores_voluntarios, $ft_trabalhadores_voluntarios];
    	$resultDao = $this->dao->updateTrabalhadores($params);
    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

    public function outrosTrabalhadores(Request $request, $id)
    {
    	$result = DB::select('SELECT * FROM osc.tb_relacoes_trabalho_outra WHERE id_osc = ?::int',[$id]);
    	if($result != null)
    		$this->updateOutrosTrabalhadores($request, $id);
    	else
    		$this->setOutrosTrabalhadores($request, $id);
    }

    public function setOutrosTrabalhadores(Request $request, $id)
    {
    	$nr_trabalhadores = $request->input('nr_trabalhadores');
    	if($nr_trabalhadores != null) $ft_trabalhadores = $this->ft_representante;
    	else $ft_trabalhadores = $request->input('ft_trabalhadores');

    	$params = [$id, $nr_trabalhadores, $ft_trabalhadores];
    	$result = $this->dao->setOutrosTrabalhadores($params);
    }

    public function updateOutrosTrabalhadores(Request $request, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_relacoes_trabalho_outra WHERE id_osc = ?::int',[$id]);
    	foreach($json as $key => $value){
    		$nr_trabalhadores = $request->input('nr_trabalhadores');
    		if($value->nr_trabalhadores != $nr_trabalhadores) $ft_trabalhadores = $this->ft_representante;
    		else $ft_trabalhadores = $request->input('ft_trabalhadores');
    	}

    	$params = [$id, $nr_trabalhadores, $ft_trabalhadores];
    	$resultDao = $this->dao->updateOutrosTrabalhadores($params);
    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

	public function setParticipacaoSocialConselho(Request $request, $id_osc)
	{
		$conselho_req = $request->conselho;

		$query = "SELECT * FROM osc.tb_participacao_social_conselho WHERE id_osc = ?::INTEGER;";
		$conselho_db = DB::select($query, [$id_osc]);

		$array_insert = array();
		$array_update = array();
		$array_delete = $conselho_db;

		$array_insert_membro_conselho = array();
		$array_delete_membro_conselho = array();

		foreach($conselho_req as $key_req => $value_req){
			$conselho = $value_req['conselho'];

			$cd_conselho = $conselho['cd_conselho'];

			$cd_tipo_participacao = null;
			if($conselho['cd_tipo_participacao']){
				$cd_tipo_participacao = $conselho['cd_tipo_participacao'];
			}

			$tx_periodicidade_reuniao = null;
			if($conselho['tx_periodicidade_reuniao']){
				$tx_periodicidade_reuniao = $conselho['tx_periodicidade_reuniao'];
			}

			$dt_data_inicio_conselho = null;
			if($conselho['dt_data_inicio_conselho']){
				$date = date_create($conselho['dt_data_inicio_conselho']);
				$dt_data_inicio_conselho = date_format($date, "Y-m-d");
			}

			$dt_data_fim_conselho = null;
			if($conselho['dt_data_fim_conselho']){
				$date = date_create($conselho['dt_data_fim_conselho']);
				$dt_data_fim_conselho = date_format($date, "Y-m-d");
			}

			$representante = array();
			if(isset($value_req['representante'])){
				foreach ($value_req['representante'] as $key_representante => $value_representante) {
					array_push($representante, $value_representante['tx_nome_representante_conselho']);
				}
			}

			$params = ["cd_conselho" => $cd_conselho, "cd_tipo_participacao" => $cd_tipo_participacao, "tx_periodicidade_reuniao" => $tx_periodicidade_reuniao, "dt_data_inicio_conselho" => $dt_data_inicio_conselho, "dt_data_fim_conselho" => $dt_data_fim_conselho, "representante" => $representante];

			$flag_insert = true;
			$flag_update = false;
			foreach ($conselho_db as $key_conselho_db => $value_conselho_db) {
				if($value_conselho_db->cd_conselho == $cd_conselho){
					$flag_insert = false;

					if($value_conselho_db->cd_tipo_participacao != $cd_tipo_participacao || $value_conselho_db->tx_periodicidade_reuniao != $tx_periodicidade_reuniao || $value_conselho_db->dt_data_inicio_conselho != $dt_data_inicio_conselho || $value_conselho_db->dt_data_fim_conselho != $dt_data_fim_conselho){
						$flag_update = true;
					}
					else{
						$id_conselho = $value_conselho_db->id_conselho;

						$query = "SELECT * FROM osc.tb_representante_conselho WHERE id_participacao_social_conselho = ?::INTEGER;";
						$reresentante_db = DB::select($query, [$id_conselho]);

						if($reresentante_db){
							foreach ($reresentante_db as $key_reresentante_db => $value_reresentante_db) {
								$id_representante_conselho = $value_reresentante_db->id_representante_conselho;
								$tx_nome_representante_conselho = $value_reresentante_db->tx_nome_representante_conselho;

								$flag_delete_representante = true;
								foreach ($representante as $key_representante => $value_representante) {
									if($tx_nome_representante_conselho == $value_representante){
										$flag_delete_representante = false;
									}
									else{
										$params = [$id_osc, $id_conselho, $value_representante];
										array_push($array_insert_membro_conselho, $params);
									}
								}

								if($flag_delete_representante){
									$params = [$id_representante_conselho];
									array_push($array_delete_membro_conselho, $params);
								}
							}
						}
						else{
							foreach ($representante as $key_representante => $value_representante) {
								$params = [$id_osc, $id_conselho, $value_representante];
								array_push($array_insert_membro_conselho, $params);
							}
						}
					}
				}
			}

			if($flag_insert){
				array_push($array_insert, $params);
			}

			if($flag_update){
				array_push($array_update, $params);
			}

			foreach ($array_delete as $key_conselho_del => $value_conselho_del) {
				if($value_conselho_del->cd_conselho == $cd_conselho){
					unset($array_delete[$key_conselho_del]);
				}
			}
		}

		foreach($array_insert as $key => $value){
			$this->insertParticipacaoSocialConselho($value, $id_osc);
		}

		foreach($array_update as $key => $value){
			$this->updateParticipacaoSocialConselho($value, $id_osc);
		}

		$flag_error_delete = false;
		foreach($array_delete as $key => $value){
			if($value->bo_oficial){
				$flag_error_delete = true;
			}
			else{
				$this->deleteParticipacaoSocialConselho($value->cd_conselho, $id_osc);
			}
		}

		foreach($array_delete_membro_conselho as $key => $value){
			$result = $this->deleteMembroParticipacaoSocialConselho($value);
		}

		foreach($array_insert_membro_conselho as $key => $value){
			$result = $this->insertMembroParticipacaoSocialConselho($value);
		}

		if($flag_error_delete){
			$result = ['msg' => 'Conselhos atualizados.'];
			$this->configResponse($result, 200);
		}
		else{
			$result = ['msg' => 'Conselhos atualizados.'];
			$this->configResponse($result, 200);
		}

		return $this->response();
	}

    private function insertParticipacaoSocialConselho($params, $id_osc)
    {
    	$cd_conselho = $params['cd_conselho'];
    	$ft_conselho = $this->ft_representante;

    	$cd_tipo_participacao = $params['cd_tipo_participacao'];
    	$ft_tipo_participacao = $this->ft_representante;

    	$tx_periodicidade_reuniao = $params['tx_periodicidade_reuniao'];
    	$ft_periodicidade_reuniao = $this->ft_representante;

    	$dt_inicio_conselho = $params['dt_data_inicio_conselho'];
    	$ft_dt_inicio_conselho = $this->ft_representante;

    	$dt_fim_conselho = $params['dt_data_fim_conselho'];
    	$ft_dt_fim_conselho = $this->ft_representante;

    	$bo_oficial = false;

		$representantes = $params['representante'];

    	$params = [$id_osc, $cd_conselho, $ft_conselho, $cd_tipo_participacao, $ft_tipo_participacao, $tx_periodicidade_reuniao, $ft_periodicidade_reuniao, $dt_inicio_conselho, $ft_dt_inicio_conselho, $dt_fim_conselho, $ft_dt_fim_conselho, $bo_oficial];
    	$result = $this->dao->insertParticipacaoSocialConselho($params);

		$id_conselho = $this->dao->selectIdParticipacaoSocialConselho([$id_osc, $cd_conselho])->id_conselho;

		foreach ($representantes as $key_representante => $value_representante) {
			$tx_nome_representante_conselho = $value_representante['tx_nome_representante_conselho'];

			$params = [$id_osc, $id_conselho, $tx_nome_representante_conselho];
			$result = $this->insertMembroParticipacaoSocialConselho($params);
		}
    }

	private function insertMembroParticipacaoSocialConselho($params){
		$ft_nome_representante_conselho = $this->ft_representante;
		$bo_oficial = false;
		array_push($params, $ft_nome_representante_conselho, $bo_oficial);

		$result = $this->dao->insertMembroParticipacaoSocialConselho($params);
	}

	private function deleteMembroParticipacaoSocialConselho($params){
		$result = $this->dao->deleteMembroParticipacaoSocialConselho($params);
	}

    private function updateParticipacaoSocialConselho($params, $id_osc)
    {
		$cd_conselho = $params['cd_conselho'];
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conselho WHERE id_osc = ?::INTEGER AND cd_conselho = ?::INTEGER;', [$id_osc, $cd_conselho]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$cd_tipo_participacao = $params['cd_tipo_participacao'];
    			if($value->cd_tipo_participacao != $cd_tipo_participacao) $ft_tipo_participacao = $this->ft_representante;
    			else $ft_tipo_participacao = $this->ft_representante;

    			$tx_periodicidade_reuniao = $params['tx_periodicidade_reuniao'];
    			if($value->tx_periodicidade_reuniao != $tx_periodicidade_reuniao) $ft_periodicidade_reuniao = $this->ft_representante;
    			else $ft_periodicidade_reuniao = $this->ft_representante;

    			$dt_inicio_conselho = $params['dt_data_inicio_conselho'];
    			if($value->dt_data_inicio_conselho != $dt_inicio_conselho) $ft_dt_inicio_conselho = $this->ft_representante;
    			else $ft_dt_inicio_conselho = $this->ft_representante;

    			$dt_fim_conselho = $params['dt_data_fim_conselho'];
    			if($value->dt_data_fim_conselho != $dt_fim_conselho) $ft_dt_fim_conselho = $this->ft_representante;
    			else $ft_dt_fim_conselho = $this->ft_representante;

    			$params = [$id_osc, $cd_conselho, $cd_tipo_participacao, $ft_tipo_participacao, $tx_periodicidade_reuniao, $ft_periodicidade_reuniao, $dt_inicio_conselho, $ft_dt_inicio_conselho, $dt_fim_conselho, $ft_dt_fim_conselho];
    			$resultDao = $this->dao->updateParticipacaoSocialConselho($params);
    			$result = ['msg' => $resultDao->mensagem];

    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    private function deleteParticipacaoSocialConselho($cd_conselho, $id_osc)
    {
		$params = [$id_osc, $cd_conselho];
		$result = $this->dao->deleteParticipacaoSocialConselho($params);

		return $result;
    }

    public function setParticipacaoSocialConferencia(Request $request, $id_osc)
    {
		$conferencia_req = $request->conferencia;

		$query = "SELECT * FROM osc.tb_participacao_social_conferencia WHERE id_osc = ?::INTEGER;";
		$conferencia_db = DB::select($query, [$id_osc]);

		$array_insert = array();
		$array_update = array();
		$array_delete = $conferencia_db;

		$result = ['msg' => 'Participação em conferências da OSC atualizadas.'];
		foreach($conferencia_req as $key_req => $value_req){
			$cd_conferencia = $value_req['cd_conferencia'];

			$dt_ano_realizacao = null;
			if($value_req['dt_ano_realizacao']){
				$date = date_create($value_req['dt_ano_realizacao']);
				$dt_ano_realizacao = date_format($date, "Y-m-d");
			}

			$cd_forma_participacao_conferencia = null;
			if($value_req['cd_forma_participacao_conferencia']){
				$cd_forma_participacao_conferencia = $value_req['cd_forma_participacao_conferencia'];
			}

			$params = ["id_osc" => $id_osc, "cd_conferencia" => $cd_conferencia, "dt_ano_realizacao" => $dt_ano_realizacao, "cd_forma_participacao_conferencia" => $cd_forma_participacao_conferencia];

			$flag_insert = true;

			foreach ($conferencia_db as $key_db => $value_db) {
				if($value_db->cd_conferencia == $cd_conferencia){
					$flag_insert = false;

					if($value_db->dt_ano_realizacao != $dt_ano_realizacao || $value_db->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia){
						$params['id_conferencia'] = $value_db->id_conferencia;
						$params['conferencia_db'] = $conferencia_db;
						array_push($array_update, $params);
					}
				}
			}

			if($flag_insert){
				array_push($array_insert, $params);
			}

			foreach ($array_delete as $key => $value) {
				if($value->cd_conferencia == $cd_conferencia){
					unset($array_delete[$key]);
				}
			}
		}

		$flag_insert = true;
		foreach($array_insert as $key => $value){
			$flag_insert = $this->insertParticipacaoSocialConferencia($value);
		}

		$flag_update = true;
		foreach($array_update as $key => $value){
			$flag_update = $this->updateParticipacaoSocialConferencia($value);
		}

		$flag_delete = true;
		foreach($array_delete as $key => $value){
			$flag_delete = $this->deleteParticipacaoSocialConferencia($value);
		}

    	if($flag_insert || $flag_update || $flag_delete){
			if(!$flag_insert){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na inserção de algum nova conferência.';
			}
			if(!$flag_update){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na atualização de alguma conferência.';
			}
			if(!$flag_delete){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na exclusão de alguma conferência.';
			}

    		$this->configResponse($result, 200);
    	}
		else{
			$result = ['msg' => 'Ocorreu um erro.'];
			$this->configResponse($result, 400);
		}

		return $this->response();
    }

    private function insertParticipacaoSocialConferencia($params)
    {
    	$id_osc = $params['id_osc'];

    	$cd_conferencia = $params['cd_conferencia'];
    	$ft_conferencia = $this->ft_representante;

    	$dt_ano_realizacao = $params['dt_ano_realizacao'];
    	$ft_ano_realizacao = $this->ft_representante;

    	$cd_forma_participacao_conferencia = $params['cd_forma_participacao_conferencia'];
    	$ft_forma_participacao_conferencia = $this->ft_representante;

    	$bo_oficial = false;

    	$params = [$id_osc, $cd_conferencia, $ft_conferencia, $dt_ano_realizacao, $ft_ano_realizacao, $cd_forma_participacao_conferencia, $ft_forma_participacao_conferencia, $bo_oficial];
    	$result = $this->dao->insertParticipacaoSocialConferencia($params);
    }

    private function updateParticipacaoSocialConferencia($params)
    {
		$id_osc = $params['id_osc'];
    	$id_conferencia = $params['id_conferencia'];
		$conferencia_db = $params['conferencia_db'];

		$result = ['msg' => 'Participação social em conferência atualizada'];
    	foreach($conferencia_db as $key => $value){
    		if(!$value->bo_oficial){
    			$cd_conferencia = $params['cd_conferencia'];
    			if($value->cd_conferencia != $cd_conferencia) $ft_conferencia = $this->ft_representante;
    			else $ft_conferencia = $params['ft_conferencia'];

    			$dt_ano_realizacao = $params['dt_ano_realizacao'];
    			if($value->dt_ano_realizacao != $dt_ano_realizacao) $ft_ano_realizacao = $this->ft_representante;
    			else $ft_ano_realizacao = $params['ft_ano_realizacao'];

    			$cd_forma_participacao_conferencia = $params['cd_forma_participacao_conferencia'];
    			if($value->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia) $ft_forma_participacao_conferencia = $this->ft_representante;
    			else $ft_forma_participacao_conferencia = $params['ft_forma_participacao_conferencia'];

    			$params = [$id_osc, $id_conferencia, $cd_conferencia, $ft_conferencia, $dt_ano_realizacao, $ft_ano_realizacao, $cd_forma_participacao_conferencia, $ft_forma_participacao_conferencia];
    			$resultDao = $this->dao->updateParticipacaoSocialConferencia($params);
    			$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    private function deleteParticipacaoSocialConferencia($params)
    {
		$id_osc = $params->id_osc;
		$id_conferencia = $params->id_conferencia;

    	$params = [$id_conferencia];
    	$resultDao = $this->dao->deleteParticipacaoSocialConferencia($params);

    	return $resultDao;
    }

    public function setParticipacaoSocialConferenciaOutra(Request $request)
    {
    	$id = $request->input('id_osc');
    	$ft_conferencia_declarada_outra = $this->ft_representante;

    	$nome_conferencia_declarada = $request->input('tx_nome_conferencia_declarada');
    	if($nome_conferencia_declarada != null) $ft_conferencia_declarada = $this->ft_representante;
    	else $ft_conferencia_declarada = $request->input('ft_conferencia_declarada');

    	$dt_ano_realizacao = $request->input('dt_ano_realizacao');
    	if($dt_ano_realizacao != null) $ft_ano_realizacao = $this->ft_representante;
    	else $ft_ano_realizacao = $request->input('ft_ano_realizacao');

    	$cd_forma_participacao_conferencia = $request->input('cd_forma_participacao_conferencia');
    	if($cd_forma_participacao_conferencia != null) $ft_forma_participacao_conferencia = $this->ft_representante;
    	else $ft_forma_participacao_conferencia = $request->input('ft_forma_participacao_conferencia');

    	$params = [$id, $nome_conferencia_declarada, $ft_conferencia_declarada, $ft_conferencia_declarada_outra, $dt_ano_realizacao, $ft_ano_realizacao, $cd_forma_participacao_conferencia, $ft_forma_participacao_conferencia];
    	$result = $this->dao->setParticipacaoSocialConferenciaOutra($params);
    }

    public function updateParticipacaoSocialConferenciaOutra(Request $request, $id)
    {
    	$id_conferencia_declarada = $request->input('id_conferencia_declarada');
    	$json_declarada = DB::select('SELECT * FROM osc.tb_conferencia_declarada WHERE id_conferencia_declarada = ?::int',[$id_conferencia_declarada]);

    	$id_conferencia_outra = $request->input('id_conferencia_outra');
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia_outra = ?::int',[$id_conferencia_outra]);

    	foreach($json as $key => $value){
    		if($value->id_conferencia_outra == $id_conferencia_outra){
    			$ft_conferencia_declarada_outra = $this->ft_representante;

    			$nome_conferencia_declarada = $request->input('tx_nome_conferencia_declarada');
    			if($json_declarada[$key]->tx_nome_conferencia_declarada != $nome_conferencia_declarada) $ft_conferencia_declarada = $this->ft_representante;
    			else $ft_conferencia_declarada = $request->input('ft_conferencia_declarada');

    			$dt_ano_realizacao = $request->input('dt_ano_realizacao');
    			if($value->dt_ano_realizacao != $dt_ano_realizacao) $ft_ano_realizacao = $this->ft_representante;
    			else $ft_ano_realizacao = $request->input('ft_ano_realizacao');

    			$cd_forma_participacao_conferencia = $request->input('cd_forma_participacao_conferencia');
    			if($value->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia) $ft_forma_participacao_conferencia = $this->ft_representante;
    			else $ft_forma_participacao_conferencia = $request->input('ft_forma_participacao_conferencia');
    		}
    	}

    	$params = [$id, $id_conferencia_outra, $id_conferencia_declarada, $nome_conferencia_declarada, $ft_conferencia_declarada, $ft_conferencia_declarada_outra, $dt_ano_realizacao, $ft_ano_realizacao, $cd_forma_participacao_conferencia, $ft_forma_participacao_conferencia];
    	$resultDao = $this->dao->updateParticipacaoSocialConferenciaOutra($params);
    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

    public function deleteParticipacaoSocialConferenciaOutra($id_conferenciaoutra, $id)
    {
    	$params = [$id_conferenciaoutra];
    	$result = $this->dao->deleteParticipacaoSocialConferenciaOutra($params);
    }

    public function setParticipacaoSocialDeclarada(Request $request)
    {
    	$id = $request->input('id_osc');
    	$nome_participacao_social_declarada = $request->input('tx_nome_participacao_social_declarada');
    	if($nome_participacao_social_declarada != null) $ft_nome_participacao_social_declarada = $this->ft_representante;
    	else $ft_nome_participacao_social_declarada = $request->input('ft_nome_participacao_social_declarada');

    	$tipo_participacao_social_declarada = $request->input('tx_tipo_participacao_social_declarada');
    	if($tipo_participacao_social_declarada != null) $ft_tipo_participacao_social_declarada = $this->ft_representante;
    	else $ft_tipo_participacao_social_declarada = $request->input('ft_tipo_participacao_social_declarada');

    	$dt_data_ingresso_participacao_social_declarada = $request->input('dt_data_ingresso_participacao_social_declarada');
    	if($dt_data_ingresso_participacao_social_declarada != null) $ft_data_ingresso_participacao_social_declarada = $this->ft_representante;
    	else $ft_data_ingresso_participacao_social_declarada = $request->input('ft_data_ingresso_participacao_social_declarada');

    	$params = [$id, $nome_participacao_social_declarada, $ft_nome_participacao_social_declarada, $tipo_participacao_social_declarada, $ft_tipo_participacao_social_declarada, $dt_data_ingresso_participacao_social_declarada, $ft_data_ingresso_participacao_social_declarada];
    	$result = $this->dao->setParticipacaoSocialDeclarada($params);
    }

    public function updateParticipacaoSocialDeclarada(Request $request, $id)
    {
    	$id_participacao_social_declarada = $request->input('id_participacao_social_declarada');
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_declarada WHERE id_participacao_social_declarada = ?::int',[$id_participacao_social_declarada]);

    	foreach($json as $key => $value){
    		if($value->id_participacao_social_declarada == $id_participacao_social_declarada){
    			$nome_participacao_social_declarada = $request->input('tx_nome_participacao_social_declarada');
    			if($value->tx_nome_participacao_social_declarada != $nome_participacao_social_declarada) $ft_nome_participacao_social_declarada = $this->ft_representante;
    			else $ft_nome_participacao_social_declarada = $request->input('ft_nome_participacao_social_declarada');

    			$tipo_participacao_social_declarada = $request->input('tx_tipo_participacao_social_declarada');
    			if($value->tx_tipo_participacao_social_declarada != $tipo_participacao_social_declarada) $ft_tipo_participacao_social_declarada = $this->ft_representante;
    			else $ft_tipo_participacao_social_declarada = $request->input('ft_tipo_participacao_social_declarada');

    			$dt_data_ingresso_participacao_social_declarada = $request->input('dt_data_ingresso_participacao_social_declarada');
    			if($value->dt_data_ingresso_participacao_social_declarada != $dt_data_ingresso_participacao_social_declarada) $ft_data_ingresso_participacao_social_declarada = $this->ft_representante;
    			else $ft_data_ingresso_participacao_social_declarada = $request->input('ft_data_ingresso_participacao_social_declarada');
    		}
    	}

    	$params = [$id, $id_participacao_social_declarada, $nome_participacao_social_declarada, $ft_nome_participacao_social_declarada, $tipo_participacao_social_declarada, $ft_tipo_participacao_social_declarada, $dt_data_ingresso_participacao_social_declarada, $ft_data_ingresso_participacao_social_declarada];
    	$resultDao = $this->dao->updateParticipacaoSocialDeclarada($params);
    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

    public function deleteParticipacaoSocialDeclarada($id_declarada, $id)
    {
    	$params = [$id_declarada];
    	$result = $this->dao->deleteParticipacaoSocialDeclarada($params);
    }

    public function setOutraParticipacaoSocial(Request $request)
    {
    	$id = $request->input('id_osc');
    	$nome = $request->input('tx_nome_participacao_social_outra');
    	if($nome != null) $ft_nome = $this->ft_representante;
    	else $ft_nome = $request->input('ft_participacao_social_outra');

    	$bo_oficial = false;

    	$params = [$id, $nome, $ft_nome, $bo_oficial];
    	$result = $this->dao->setOutraParticipacaoSocial($params);
    }

    public function updateOutraParticipacaoSocial(Request $request, $id)
    {
    	$id_outra = $request->input('id_participacao_social_outra');
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_outra WHERE id_participacao_social_outra = ?::int',[$id_outra]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$nome = $request->input('tx_nome_participacao_social_outra');
    			if($value->tx_nome_participacao_social_outra != $nome) $ft_nome = $this->ft_representante;
    			else $ft_nome = $request->input('ft_participacao_social_outra');

    			$params = [$id, $id_outra, $nome, $ft_nome];
    			$resultDao = $this->dao->updateOutraParticipacaoSocial($params);
    			$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function deleteOutraParticipacaoSocial($id_outraparticipacao, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_outra WHERE id_participacao_social_outra = ?::int',[$id_outraparticipacao]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_outraparticipacao];
    			$resultDao = $this->dao->deleteOutraParticipacaoSocial($params);
    			$result = ['msg' => 'Outra Participacao Social excluida'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function updateLinkRecursos(Request $request, $id)
    {
    	$json = DB::select('SELECT tx_link_relatorio_auditoria, ft_link_relatorio_auditoria, tx_link_demonstracao_contabil, ft_link_demonstracao_contabil FROM osc.tb_dados_gerais WHERE id_osc = ?::int',[$id]);

    	foreach($json as $key => $value){
	    	$link_relatorio_auditoria = $request->input('tx_link_relatorio_auditoria');
	    	if($value->tx_link_relatorio_auditoria != $link_relatorio_auditoria) $ft_link_relatorio_auditoria = $this->ft_representante;
	    	else $ft_link_relatorio_auditoria = $request->input('ft_link_relatorio_auditoria');

	    	$link_demonstracao_contabil = $request->input('tx_link_demonstracao_contabil');
	    	if($value->tx_link_demonstracao_contabil != $link_demonstracao_contabil) $ft_link_demonstracao_contabil = $this->ft_representante;
	    	else $ft_link_demonstracao_contabil = $request->input('ft_link_demonstracao_contabil');
    	}

    	$params = [$id, $link_relatorio_auditoria, $ft_link_relatorio_auditoria, $link_demonstracao_contabil, $ft_link_demonstracao_contabil];
    	$resultDao = $this->dao->updateLinkRecursos($params);
    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setConselhoFiscal(Request $request)
    {
    	$id = $request->input('id_osc');
    	$nome = $request->input('tx_nome_conselheiro');
    	if($nome != null) $ft_nome = $this->ft_representante;
    	else $ft_nome = $request->input('ft_nome_conselheiro');

    	$bo_oficial = false;

    	$params = [$id, $nome, $ft_nome, $bo_oficial];
    	$result = $this->dao->setConselhoFiscal($params);
    }

    public function updateConselhoFiscal(Request $request, $id)
    {
    	$id_conselheiro = $request->input('id_conselheiro');

    	$json = DB::select('SELECT * FROM osc.tb_conselho_fiscal WHERE id_conselheiro = ?::int',[$id_conselheiro]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$nome = $request->input('tx_nome_conselheiro');
    			if($value->tx_nome_conselheiro != $nome) $ft_nome = $this->ft_representante;
    			else $ft_nome = $request->input('ft_nome_conselheiro');

    			$params = [$id, $id_conselheiro, $nome, $ft_nome];
    			$resultDao = $this->dao->updateConselhoFiscal($params);
    			$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function deleteConselhoFiscal($id_conselhofiscal, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_conselho_fiscal WHERE id_conselheiro = ?::int',[$id_conselhofiscal]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_conselhofiscal];
    			$resultDao = $this->dao->deleteConselhoFiscal($params);
    			$result = ['msg' => 'Conselho Fiscal excluido'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setProjeto(Request $request)
    {
    	$id = $request->input('id_osc');
    	$tx_nome = $request->input('tx_nome_projeto');
    	if($tx_nome != null) $ft_nome = $this->ft_representante;
    	else $ft_nome = $request->input('ft_nome_projeto');

    	$cd_status = $request->input('cd_status_projeto');
    	if($cd_status != null) $ft_status = $this->ft_representante;
    	else $ft_status = $request->input('ft_status_projeto');

    	$dt_data_inicio = $request->input('dt_data_inicio_projeto');
    	if($dt_data_inicio != null) $ft_data_inicio = $this->ft_representante;
    	else $ft_data_inicio = $request->input('ft_data_inicio_projeto');

    	$dt_data_fim = $request->input('dt_data_fim_projeto');
    	if($dt_data_fim != null) $ft_data_fim = $this->ft_representante;
    	else $ft_data_fim = $request->input('ft_data_fim_projeto');

    	$nr_valor_total = $request->input('nr_valor_total_projeto');
    	if($nr_valor_total != null) $ft_valor_total = $this->ft_representante;
    	else $ft_valor_total = $request->input('ft_valor_total_projeto');

    	$tx_link = $request->input('tx_link_projeto');
    	if($tx_link != null) $ft_link = $this->ft_representante;
    	else $ft_link = $request->input('ft_link_projeto');

    	$cd_abrangencia = $request->input('cd_abrangencia_projeto');
    	if($cd_abrangencia != null) $ft_abrangencia = $this->ft_representante;
    	else $ft_abrangencia = $request->input('ft_abrangencia_projeto');

    	$tx_descricao = $request->input('tx_descricao_projeto');
    	if($tx_descricao != null) $ft_descricao = $this->ft_representante;
    	else $ft_descricao = $request->input('ft_descricao_projeto');

    	$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
    	if($nr_total_beneficiarios != null) $ft_total_beneficiarios = $this->ft_representante;
    	else $ft_total_beneficiarios = $request->input('ft_total_beneficiarios');

    	$nr_valor_captado_projeto = $request->input('nr_valor_captado_projeto');
    	if($nr_valor_captado_projeto != null) $ft_valor_captado_projeto = $this->ft_representante;
    	else $ft_valor_captado_projeto = $request->input('ft_valor_captado_projeto');

    	$cd_zona_atuacao_projeto = $request->input('cd_zona_atuacao_projeto');
    	if($cd_zona_atuacao_projeto != null) $ft_zona_atuacao_projeto = $this->ft_representante;
    	else $ft_zona_atuacao_projeto = $request->input('ft_zona_atuacao_projeto');

    	$tx_metodologia_monitoramento = $request->input('tx_metodologia_monitoramento');
    	if($tx_metodologia_monitoramento != null) $ft_metodologia_monitoramento = $this->ft_representante;
    	else $ft_metodologia_monitoramento = $request->input('ft_metodologia_monitoramento');

    	$tx_identificador_projeto_externo = $request->input('tx_identificador_projeto_externo');
    	if($tx_identificador_projeto_externo != null) $ft_identificador_projeto_externo = $this->ft_representante;
    	else $ft_identificador_projeto_externo = $request->input('ft_identificador_projeto_externo');

    	$bo_oficial = false;

    	$params = [$id, $tx_nome, $ft_nome, $cd_status, $ft_status, $dt_data_inicio, $ft_data_inicio,
    			$dt_data_fim, $ft_data_fim, $nr_valor_total, $ft_valor_total, $tx_link, $ft_link, $cd_abrangencia,
    			$ft_abrangencia, $tx_descricao, $ft_descricao, $nr_total_beneficiarios, $ft_total_beneficiarios,
    			$nr_valor_captado_projeto, $ft_valor_captado_projeto, $cd_zona_atuacao_projeto, $ft_zona_atuacao_projeto,
    			$tx_metodologia_monitoramento, $ft_metodologia_monitoramento, $tx_identificador_projeto_externo, $ft_identificador_projeto_externo, $bo_oficial];
    	$result = $this->dao->setProjeto($params);
    	$id_projeto = $result->inserir_projeto;

    	$this->setPublicoBeneficiado($request, $id_projeto);
    	$this->setAreaAtuacaoProjeto($request, $id_projeto);
    	$this->setAreaAtuacaoOutraProjeto($request, $id_projeto);
    	$this->setLocalizacaoProjeto($request, $id_projeto);
    	$this->setObjetivoProjeto($request, $id_projeto);
    	$this->setParceiraProjeto($request, $id_projeto);

    }

    public function updateProjeto(Request $request, $id)
    {
    	$id_projeto = $request->input('id_projeto');

    	$json = DB::select('SELECT * FROM osc.tb_projeto WHERE id_projeto = ?::int',[$id_projeto]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$tx_nome = $request->input('tx_nome_projeto');
    			if($value->tx_nome_projeto != $tx_nome) $ft_nome = $this->ft_representante;
    			else $ft_nome = $request->input('ft_nome_projeto');

    			$cd_status = $request->input('cd_status_projeto');
    			if($value->cd_status_projeto != $cd_status) $ft_status = $this->ft_representante;
    			else $ft_status = $request->input('ft_status_projeto');

    			$dt_data_inicio = $request->input('dt_data_inicio_projeto');
    			if($value->dt_data_inicio_projeto != $dt_data_inicio) $ft_data_inicio = $this->ft_representante;
    			else $ft_data_inicio = $request->input('ft_data_inicio_projeto');

    			$dt_data_fim = $request->input('dt_data_fim_projeto');
    			if($value->dt_data_fim_projeto != $dt_data_fim) $ft_data_fim = $this->ft_representante;
    			else $ft_data_fim = $request->input('ft_data_fim_projeto');

    			$nr_valor_total = $request->input('nr_valor_total_projeto');
    			if($value->nr_valor_total_projeto != $nr_valor_total) $ft_valor_total = $this->ft_representante;
    			else $ft_valor_total = $request->input('ft_valor_total_projeto');

    			$tx_link = $request->input('tx_link_projeto');
    			if($value->tx_link_projeto != $tx_link) $ft_link = $this->ft_representante;
    			else $ft_link = $request->input('ft_link_projeto');

    			$cd_abrangencia = $request->input('cd_abrangencia_projeto');
    			if($value->cd_abrangencia_projeto != $cd_abrangencia) $ft_abrangencia = $this->ft_representante;
    			else $ft_abrangencia = $request->input('ft_abrangencia_projeto');

    			$tx_descricao = $request->input('tx_descricao_projeto');
    			if($value->tx_descricao_projeto != $tx_descricao) $ft_descricao = $this->ft_representante;
    			else $ft_descricao = $request->input('ft_descricao_projeto');

    			$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
    			if($value->nr_total_beneficiarios != $nr_total_beneficiarios) $ft_total_beneficiarios = $this->ft_representante;
    			else $ft_total_beneficiarios = $request->input('ft_total_beneficiarios');

    			$nr_valor_captado_projeto = $request->input('nr_valor_captado_projeto');
    			if($value->nr_valor_captado_projeto != $nr_valor_captado_projeto) $ft_valor_captado_projeto = $this->ft_representante;
    			else $ft_valor_captado_projeto = $request->input('ft_valor_captado_projeto');

    			$cd_zona_atuacao_projeto = $request->input('cd_zona_atuacao_projeto');
    			if($value->cd_zona_atuacao_projeto != $cd_zona_atuacao_projeto) $ft_zona_atuacao_projeto = $this->ft_representante;
    			else $ft_zona_atuacao_projeto = $request->input('ft_zona_atuacao_projeto');

    			$tx_metodologia_monitoramento = $request->input('tx_metodologia_monitoramento');
    			if($value->tx_metodologia_monitoramento != $tx_metodologia_monitoramento) $ft_metodologia_monitoramento = $this->ft_representante;
    			else $ft_metodologia_monitoramento = $request->input('ft_metodologia_monitoramento');

    			$tx_identificador_projeto_externo = $request->input('tx_identificador_projeto_externo');
    			if($value->tx_identificador_projeto_externo != $tx_identificador_projeto_externo) $ft_identificador_projeto_externo = $this->ft_representante;
    			else $ft_identificador_projeto_externo = $request->input('ft_identificador_projeto_externo');

    			$id_publico = $request->input('id_publico_beneficiado');
    			$id_area = $request->input('id_area_atuacao_projeto');
    			$id_outra_area = $request->input('id_area_atuacao_declarada');
    			$id_localizacao = $request->input('id_localizacao_projeto');
    			$id_objetivo = $request->input('id_objetivo_projeto');

    			$this->updatePublicoBeneficiado($request, $id_publico);
    			$this->updateAreaAtuacaoProjeto($request, $id_area);
    			$this->updateAreaAtuacaoOutraProjeto($request, $id_outra_area);
    			$this->updateLocalizacaoProjeto($request, $id_localizacao);
    			$this->updateObjetivoProjeto($request, $id_objetivo);

    			$params = [$id, $id_projeto, $tx_nome, $ft_nome, $cd_status, $ft_status, $dt_data_inicio, $ft_data_inicio,
    					$dt_data_fim, $ft_data_fim, $nr_valor_total, $ft_valor_total, $tx_link, $ft_link, $cd_abrangencia,
    					$ft_abrangencia, $tx_descricao, $ft_descricao, $nr_total_beneficiarios, $ft_total_beneficiarios,
    					$nr_valor_captado_projeto, $ft_valor_captado_projeto, $cd_zona_atuacao_projeto, $ft_zona_atuacao_projeto,
    					$tx_metodologia_monitoramnto, $ft_metodologia_monitoramento, $tx_identificador_projeto_externo, $ft_identificador_projeto_externo];
    			$resultDao = $this->dao->updateProjeto($params);
    			$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setPublicoBeneficiado(Request $request, $id_projeto)
    {
    	$nome_publico_beneficiado = $request->input('tx_nome_publico_beneficiado');
    	if($nome_publico_beneficiado != null) $ft_publico_beneficiado = $this->ft_representante;
    	else $ft_publico_beneficiado = $request->input('ft_publico_beneficiado');
    	$ft_publico_beneficiado_projeto = $request->input('ft_publico_beneficiado_projeto');

    	$bo_oficial = false;

    	$params = [$id_projeto, $nome_publico_beneficiado, $ft_publico_beneficiado, $ft_publico_beneficiado_projeto, $bo_oficial];
    	$result = $this->dao->setPublicoBeneficiado($params);
    }

    public function updatePublicoBeneficiado(Request $request, $id_publico)
    {
	    $json = DB::select('SELECT * FROM osc.tb_publico_beneficiado WHERE id_publico_beneficiado = ?::int',[$id_publico]);

	    $json_oficial = DB::select('SELECT * FROM osc.tb_publico_beneficiado_projeto WHERE id_publico_beneficiado = ?::int',[$id_publico]);

	    foreach($json_oficial as $key => $value){
	    	$bo_oficial = $value->bo_oficial;
	    	if(!$bo_oficial){
			    foreach($json as $key => $value){
			    	if($value->id_publico_beneficiado == $id_publico){
			    		$nome_publico_beneficiado = $request->input('tx_nome_publico_beneficiado');
			    		if($value->tx_nome_publico_beneficiado != $nome_publico_beneficiado) $ft_publico_beneficiado = $this->ft_representante;
			    		else $ft_publico_beneficiado = $request->input('ft_publico_beneficiado');

			    		$params = [$id_publico, $nome_publico_beneficiado, $ft_publico_beneficiado];
			    		$resultDao = $this->dao->updatePublicoBeneficiado($params);
			    		$result = ['msg' => $resultDao->mensagem];
			    	}
			    }
	    	}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
	    }
	    $this->configResponse($result);
	    return $this->response();
    }

    public function deletePublicoBeneficiado($id_beneficiado, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_publico_beneficiado_projeto WHERE id_publico_beneficiado = ?::int',[$id_beneficiado]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_beneficiado];
    			$resultDao = $this->dao->deletePublicoBeneficiado($params);
    			$result = ['msg' => 'Publico Beneficiado excluido'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setAreaAtuacaoProjeto(Request $request, $id_projeto)
    {
    	$cd_subarea_atuacao = $request->input('cd_subarea_atuacao');
    	if($cd_subarea_atuacao != null) $ft_area_atuacao_projeto = $this->ft_repr_atuacao_projeto = $request->input('ft_area_atuacao_projeto');

    	$bo_oficial = false;

    	$params = [$id_projeto, $cd_subarea_atuacao, $ft_area_atuacao_projeto, $bo_oficial];
    	$result = $this->dao->setAreaAtuacaoProjeto($params);

    }

    public function updateAreaAtuacaoProjeto(Request $request, $id_area)
    {
    	$json = DB::select('SELECT * FROM osc.tb_area_atuacao_projeto WHERE id_area_atuacao_projeto = ?::int',[$id_area]);

       	foreach($json as $key => $value){
       		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
       			$cd_subarea_atuacao = $request->input('cd_subarea_atuacao');
       			if($value->cd_subarea_atuacao != $cd_subarea_atuacao) $ft_area_atuacao_projeto = $this->ft_representante;
       			else $ft_area_atuacao_projeto = $request->input('ft_area_atuacao_projeto');

       			$params = [$id_area, $cd_subarea_atuacao, $ft_area_atuacao_projeto];
       			$resultDao = $this->dao->updateAreaAtuacaoProjeto($params);
       			$result = ['msg' => $resultDao->mensagem];
       		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
       	}
       	$this->configResponse($result);
       	return $this->response();
    }

    public function deleteAreaAtuacaoProjeto($id_areaprojeto, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_area_atuacao_projeto WHERE id_area_atuacao_projeto = ?::int',[$id_areaprojeto]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_areaprojeto];
    			$resultDao = $this->dao->deleteAreaAtuacaoProjeto($params);
    			$result = ['msg' => 'Area Atuacao Projeto excluida'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setAreaAtuacaoOutraProjeto(Request $request, $id_projeto)
    {
    	$id = $request->input('id_osc');
    	$tx_nome_area_atuacao_declarada = $request->input('tx_nome_area_atuacao_declarada');
    	if($tx_nome_area_atuacao_declarada != null) $ft_nome_area_atuacao_declarada = $this->ft_representante;
    	else $ft_nome_area_atuacao_declarada = $request->input('ft_nome_area_atuacao_declarada');
    	$ft_area_atuacao_outra_projeto = $this->ft_representante;
    	$ft_area_atuacao_outra = $this->ft_representante;

    	$params = [$id, $id_projeto, $tx_nome_area_atuacao_declarada, $ft_nome_area_atuacao_declarada, $ft_area_atuacao_outra_projeto, $ft_area_atuacao_outra];
    	$result = $this->dao->setAreaAtuacaoOutraProjeto($params);

    }

    public function updateAreaAtuacaoOutraProjeto(Request $request, $id_area)
    {
    	$json = DB::select('SELECT * FROM osc.tb_area_atuacao_declarada WHERE id_area_atuacao_declarada = ?::int',[$id_area]);
       	foreach($json as $key => $value){
       		if($value->id_area_atuacao_declarada == $id_area){
       			$tx_nome_area_atuacao_declarada = $request->input('tx_nome_area_atuacao_declarada');
       			if($value->tx_nome_area_atuacao_declarada != $tx_nome_area_atuacao_declarada) $ft_nome_area_atuacao_declarada = $this->ft_representante;
       			else $ft_nome_area_atuacao_declarada = $request->input('ft_nome_area_atuacao_declarada');
       		}
       	}
       	$params = [$id_area, $tx_nome_area_atuacao_declarada, $ft_nome_area_atuacao_declarada];
       	$resultDao = $this->dao->updateAreaAtuacaoOutraProjeto($params);
       	$result = ['msg' => $resultDao->mensagem];
       	$this->configResponse($result);
       	return $this->response();
    }

    public function deleteAreaAtuacaoOutraProjeto($id_areaoutraprojeto, $id)
    {
    	$params = [$id_areaoutraprojeto];
    	$result = $this->dao->deleteAreaAtuacaoOutraProjeto($params);
    }

    public function setLocalizacaoProjeto(Request $request, $id_projeto)
    {
    	$id_regiao_localizacao_projeto = $request->input('id_regiao_localizacao_projeto');
    	if($id_regiao_localizacao_projeto != null) $ft_regiao_localizacao_projeto = $this->ft_representante;
    	else $ft_regiao_localizacao_projeto = $request->input('ft_regiao_localizacao_projeto');

    	$tx_nome_regiao_localizacao_projeto = $request->input('tx_nome_regiao_localizacao_projeto');
    	if($tx_nome_regiao_localizacao_projeto != null) $ft_nome_regiao_localizacao_projeto = $this->ft_representante;
    	else $ft_nome_regiao_localizacao_projeto = $request->input('ft_nome_regiao_localizacao_projeto');

    	$bo_oficial = false;

    	$params = [$id_projeto, $id_regiao_localizacao_projeto, $ft_regiao_localizacao_projeto, $tx_nome_regiao_localizacao_projeto, $ft_nome_regiao_localizacao_projeto, $bo_oficial];
    	$result = $this->dao->setLocalizacaoProjeto($params);
    }

    public function updateLocalizacaoProjeto(Request $request, $id_localizacao)
    {
    	$json = DB::select('SELECT * FROM osc.tb_localizacao_projeto WHERE id_localizacao_projeto = ?::int',[$id_localizacao]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$id_projeto = $request->input('id_projeto');
    			$id_regiao_localizacao_projeto = $request->input('id_regiao_localizacao_projeto');
    			if($value->id_regiao_localizacao_projeto != $id_regiao_localizacao_projeto) $ft_regiao_localizacao_projeto = $this->ft_representante;
    			else $ft_regiao_localizacao_projeto = $request->input('ft_regiao_localizacao_projeto');

    			$tx_nome_regiao_localizacao_projeto = $request->input('tx_nome_regiao_localizacao_projeto');
    			if($value->tx_nome_regiao_localizacao_projeto != $tx_nome_regiao_localizacao_projeto) $ft_nome_regiao_localizacao_projeto = $this->ft_representante;
    			else $ft_nome_regiao_localizacao_projeto = $request->input('ft_nome_regiao_localizacao_projeto');

    			$params = [$id_projeto, $id_localizacao, $id_regiao_localizacao_projeto, $ft_regiao_localizacao_projeto, $tx_nome_regiao_localizacao_projeto, $ft_nome_regiao_localizacao_projeto];
    			$resultDao = $this->dao->updateLocalizacaoProjeto($params);
    			$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function deleteLocalizacaoProjeto($id_localizacao, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_localizacao_projeto WHERE id_localizacao_projeto = ?::int',[$id_localizacao]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_localizacao];
    			$resultDao = $this->dao->deleteLocalizacaoProjeto($params);
    			$result = ['msg' => 'Localizacao do Projeto excluida'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setObjetivoProjeto(Request $request, $id_projeto)
    {
    	$cd_meta_projeto = $request->input('cd_meta_projeto');
    	if($cd_meta_projeto != null) $ft_objetivo_projeto = $this->ft_representante;
    	else $ft_objetivo_projeto = $request->input('ft_objetivo_projeto');

    	$bo_oficial = false;

    	$params = [$id_projeto, $cd_meta_projeto, $ft_objetivo_projeto, $bo_oficial];
    	$result = $this->dao->setObjetivoProjeto($params);
    }

    public function updateObjetivoProjeto(Request $request, $id_objetivo)
    {
    	$json = DB::select('SELECT * FROM osc.tb_objetivo_projeto WHERE id_objetivo_projeto = ?::int',[$id_objetivo]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$id_projeto = $request->input('id_projeto');

    			$cd_meta_projeto = $request->input('cd_meta_projeto');
    			if($value->cd_meta_projeto != $cd_meta_projeto) $ft_objetivo_projeto = $this->ft_representante;
    			else $ft_objetivo_projeto = $request->input('ft_objetivo_projeto');

    			$params = [$id_projeto, $id_objetivo, $cd_meta_projeto, $ft_objetivo_projeto];
    			$resultDao = $this->dao->updateObjetivoProjeto($params);
    			$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function deleteObjetivoProjeto($id_objetivo, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_objetivo_projeto WHERE id_objetivo_projeto = ?::int',[$id_objetivo]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_objetivo];
    			$resultDao = $this->dao->deleteObjetivoProjeto($params);
    			$result = ['msg' => 'Objetivo do Projeto excluido'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setParceiraProjeto(Request $request, $id_projeto)
    {
    	$id_osc = $request->input('id_osc');
    	if($id_osc != null) $ft_osc_parceira_projeto = $this->ft_representante;
    	else $ft_osc_parceira_projeto = $request->input('ft_osc_parceira_projeto');

    	$bo_oficial = false;

    	$params = [$id_projeto, $id_osc, $ft_osc_parceira_projeto, $bo_oficial];
    	$result = $this->dao->setParceiraProjeto($params);
    }

    public function deleteParceiraProjeto($id_parceira, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_osc_parceira_projeto WHERE id_osc = ?::int',[$id_parceira]);

    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_parceira];
    			$resultDao = $this->dao->deleteParceiraProjeto($params);
    			$result = ['msg' => 'Parceira do Projeto excluida'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setRecursosOsc(Request $request, $id_osc)
    {
		$recursos_req = $request->fonte_recursos;

		$query = "SELECT * FROM osc.tb_recursos_osc WHERE id_osc = ?::INTEGER;";
		$recursos_db = DB::select($query, [$id_osc]);

		$array_insert = array();
		$array_update = array();
		$array_delete = $recursos_db;

		$flag_delete = true;

		foreach($recursos_req as $key_req => $value_req){
			$cd_fonte_recursos_osc = $value_req['cd_fonte_recursos_osc'];

			$dt_ano_recursos_osc = null;
			if($value_req['dt_ano_recursos_osc']){
				$dt_ano_recursos_osc = $value_req['dt_ano_recursos_osc'];

				if(strlen($dt_ano_recursos_osc) == 4){
					$dt_ano_recursos_osc = $dt_ano_recursos_osc.'-01-01';
				}

				$date = date_create($dt_ano_recursos_osc);
				$dt_ano_recursos_osc = date_format($date, "Y-m-d");
			}

			$nr_valor_recursos_osc = null;
			if(isset($value_req['nr_valor_recursos_osc'])){
				$nr_valor_recursos_osc = $this->formatacaoUtil->converMoneyToDouble($value_req['nr_valor_recursos_osc']);
			}

			$params = ["id_osc" => $id_osc, "cd_fonte_recursos_osc" => $cd_fonte_recursos_osc, "dt_ano_recursos_osc" => $dt_ano_recursos_osc, "nr_valor_recursos_osc" => $nr_valor_recursos_osc];

			$flag_insert = true;

			foreach ($recursos_db as $key_db => $value_db) {
				if($value_db->cd_fonte_recursos_osc == $cd_fonte_recursos_osc && $value_db->dt_ano_recursos_osc == $dt_ano_recursos_osc){
					$flag_insert = false;

					if(!$nr_valor_recursos_osc){
						foreach ($array_delete as $key => $value) {
							if($value->id_recursos_osc == $value_db->id_recursos_osc){
								$flag_delete = $this->deleteRecursosOsc($value);
							}
						}
					}
					else if($value_db->nr_valor_recursos_osc != $nr_valor_recursos_osc){
						$params['id_recursos_osc'] = $value_db->id_recursos_osc;
						$params['recursos_osc_db'] = $recursos_db;
						array_push($array_update, $params);
					}
				}
			}

			if($flag_insert){
				if($nr_valor_recursos_osc){
					array_push($array_insert, $params);
				}
			}

			foreach ($array_delete as $key => $value) {
				if($value->cd_fonte_recursos_osc == $cd_fonte_recursos_osc && $value->dt_ano_recursos_osc == $dt_ano_recursos_osc){
					unset($array_delete[$key]);
				}
			}
		}

		$flag_insert = true;
		foreach($array_insert as $key => $value){
			$flag_insert = $this->insertRecursosOsc($value);
		}

		$flag_update = true;
		foreach($array_update as $key => $value){
			$flag_update = $this->updateRecursosOsc($value);
		}

		foreach($array_delete as $key => $value){
			$flag_delete = $this->deleteRecursosOsc($value);
		}

    	if($flag_insert || $flag_update || $flag_delete){
			$result = ['msg' => 'Recursos da OSC atualizados.'];

			if(!$flag_insert){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na inserção de algum novo recurso.';
			}
			if(!$flag_update){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na atualização de algum recurso.';
			}
			if(!$flag_delete){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na exclusão de algum recurso.';
			}

    		$this->configResponse($result, 200);
    	}
		else{
			$result = ['msg' => 'Ocorreu um erro.'];
			$this->configResponse($result, 400);
		}

		return $this->response();
    }

    private function insertRecursosOsc($params)
    {
		$id_osc = $params['id_osc'];

    	$cd_fonte_recursos_osc = $params['cd_fonte_recursos_osc'];
    	$ft_fonte_recursos_osc = $this->ft_representante;

    	$dt_ano_recursos_osc = $params['dt_ano_recursos_osc'];
    	$ft_ano_recursos_osc = $this->ft_representante;

    	$nr_valor_recursos_osc = $params['nr_valor_recursos_osc'];
    	$ft_valor_recursos_osc = $this->ft_representante;

    	$params = [$id_osc, $cd_fonte_recursos_osc, $ft_fonte_recursos_osc, $dt_ano_recursos_osc, $ft_ano_recursos_osc, $nr_valor_recursos_osc, $ft_valor_recursos_osc];
    	$resultDao = $this->dao->insertRecursosOsc($params);

    	return $resultDao;
    }

    private function updateRecursosOsc($params)
    {
		$id_osc = $params['id_osc'];
    	$id_recursos_osc = $params['id_recursos_osc'];
    	$recursos_db = $params['recursos_osc_db'];

    	foreach($recursos_db as $key => $value){
    		if($value->id_recursos_osc == $id_recursos_osc){
    			$cd_fonte_recursos_osc = $params['cd_fonte_recursos_osc'];
    			if($value->cd_fonte_recursos_osc != $cd_fonte_recursos_osc) $ft_fonte_recursos_osc = $this->ft_representante;
    			else $ft_fonte_recursos_osc = $value->ft_fonte_recursos_osc;

    			$dt_ano_recursos_osc = $params['dt_ano_recursos_osc'];
    			if($value->dt_ano_recursos_osc != $dt_ano_recursos_osc) $ft_ano_recursos_osc = $this->ft_representante;
    			else $ft_ano_recursos_osc = $value->ft_ano_recursos_osc;

    			$nr_valor_recursos_osc = str_replace(',', '.', $params['nr_valor_recursos_osc']);
    			if($value->nr_valor_recursos_osc != $nr_valor_recursos_osc) $ft_valor_recursos_osc = $this->ft_representante;
    			else $ft_valor_recursos_osc = $value->ft_valor_recursos_osc;
    		}
    	}

    	$params = [$id_osc, $id_recursos_osc, $cd_fonte_recursos_osc, $ft_fonte_recursos_osc, $dt_ano_recursos_osc, $ft_ano_recursos_osc, $nr_valor_recursos_osc, $ft_valor_recursos_osc];
    	$resultDao = $this->dao->updateRecursosOsc($params);

		return $resultDao;
    }

    private function deleteRecursosOsc($params)
    {
		$id_osc = $params->id_osc;
		$id_recursos = $params->id_recursos_osc;

    	$params = [$id_recursos];
    	$resultDao = $this->dao->deleteRecursosOsc($params);

    	return $resultDao;
    }

    public function setRecursosOutroOsc(Request $request)
    {
    	$id = $request->input('id_osc');

    	$tx_nome_fonte_recursos_osc = $request->input('tx_nome_fonte_recursos_outro_osc');
    	if($tx_nome_fonte_recursos_osc != null) $ft_nome_fonte_recursos_osc = $this->ft_representante;
    	else $ft_nome_fonte_recursos_osc = $request->input('ft_nome_fonte_recursos_outro_osc');

    	$dt_ano_recursos_osc = $request->input('dt_ano_recursos_outro_osc');
    	if($dt_ano_recursos_osc != null) $ft_ano_recursos_osc = $this->ft_representante;
    	else $ft_ano_recursos_osc = $request->input('ft_ano_recursos_outro_osc');

    	$nr_valor_recursos_osc = str_replace(',', '.', $request->input('nr_valor_recursos_outro_osc'));
    	if($nr_valor_recursos_osc != null) $ft_valor_recursos_osc = $this->ft_representante;
    	else $ft_valor_recursos_osc = $request->input('ft_valor_recursos_outro_osc');

    	$params = [$id, $tx_nome_fonte_recursos_osc, $ft_nome_fonte_recursos_osc, $dt_ano_recursos_osc, $ft_ano_recursos_osc, $nr_valor_recursos_osc, $ft_valor_recursos_osc];
    	$resultDao = $this->dao->setRecursosOutroOsc($params);

    	if($resultDao->inserir_recursos_outro_osc){
    		$result = ['msg' => 'Recursos da OSC atualizado.'];
    		$this->configResponse($result, 200);
    	}else{
    		$result = ['msg' => 'Ocorreu um erro.'];
    		$this->configResponse($result, 400);
    	}

    	return $this->response();
    }

    public function updateRecursosOutroOsc(Request $request, $id)
    {
    	$id_recursos_osc = $request->input('id_recursos_outro_osc');
    	$json = DB::select('SELECT * FROM osc.tb_recursos_outro_osc WHERE id_recursos_outro_osc = ?::int',[$id_recursos_osc]);

    	foreach($json as $key => $value){
    		if($value->id_recursos_outro_osc == $id_recursos_osc){
    			$tx_nome_fonte_recursos_osc = $request->input('tx_nome_fonte_recursos_outro_osc');
    			if($value->tx_nome_fonte_recursos_outro_osc != $tx_nome_fonte_recursos_osc) $ft_nome_fonte_recursos_osc = $this->ft_representante;
    			else $ft_nome_fonte_recursos_osc = $request->input('ft_nome_fonte_recursos_outro_osc');

    			$dt_ano_recursos_osc = $request->input('dt_ano_recursos_outro_osc');
    			if($value->dt_ano_recursos_outro_osc != $dt_ano_recursos_osc) $ft_ano_recursos_osc = $this->ft_representante;
    			else $ft_ano_recursos_osc = $request->input('ft_ano_recursos_outro_osc');

    			$nr_valor_recursos_osc = $request->input('nr_valor_recursos_outro_osc');
    			if($value->nr_valor_recursos_outro_osc != $nr_valor_recursos_osc) $ft_valor_recursos_osc = $this->ft_representante;
    			else $ft_valor_recursos_osc = $request->input('ft_valor_recursos_outro_osc');
    		}
    	}

    	$params = [$id, $id_recursos_osc, $tx_nome_fonte_recursos_osc, $ft_nome_fonte_recursos_osc, $dt_ano_recursos_osc, $ft_ano_recursos_osc, $nr_valor_recursos_osc, $ft_valor_recursos_osc];
    	$resultDao = $this->dao->updateRecursosOutroOsc($params);

    	if($resultDao->status){
    		$result = ['msg' => $resultDao->mensagem];
    		$this->configResponse($result, 200);
    	}else{
    		$result = ['msg' => $resultDao->mensagem];
    		$this->configResponse($result, 400);
    	}

    	return $this->response();
    }

    public function deleteRecursosOutroOsc($id_recursosoutro, $id)
    {
    	$params = [$id_recursosoutro];
    	$result = $this->dao->deleteRecursosOutroOsc($params);

    	$result = ['msg' => 'Recursos da OSC atualizado.'];
    	$this->configResponse($result, 200);

    	return $this->response();
    }
}
