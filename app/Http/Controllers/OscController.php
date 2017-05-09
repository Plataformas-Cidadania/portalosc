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
		$result = ['msg' => 'Dados gerais atualizados.'];
		
        $id_usuario = $request->user()->id;
		
    	$dados_gerais_db = DB::select('SELECT * FROM osc.tb_dados_gerais WHERE id_osc = ?::INTEGER', [$id_osc]);
		
		$flag_insert = false;
		
		if($dados_gerais_db){
	    	foreach($dados_gerais_db as $key_db => $value_db){
				$im_logo = $request->input('im_logo');
				$ft_logo = $value_db->ft_logo;
				if($value_db->im_logo != $im_logo){
					$flag_insert = true;
					
					if($im_logo == '') $im_logo = null;
					$ft_logo = $this->ft_representante;
					
	                $tx_nome_campo = 'im_logo';
					$id_tabela = $value_db->id_osc;
	                $tx_dado_anterior = $value_db->im_logo;
	                $tx_dado_posterior = $im_logo;
					//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
				
				$tx_nome_fantasia_osc = $request->input('tx_nome_fantasia_osc');
				$ft_nome_fantasia_osc = $value_db->ft_nome_fantasia_osc;
				if($value_db->tx_nome_fantasia_osc != $tx_nome_fantasia_osc){
					$flag_insert = true;
					
					if($tx_nome_fantasia_osc == '') $tx_nome_fantasia_osc = null;
					$ft_nome_fantasia_osc = $this->ft_representante;
					
	                $tx_nome_campo = 'tx_nome_fantasia_osc';
					$id_tabela = $value_db->id_osc;
	                $tx_dado_anterior = $value_db->tx_nome_fantasia_osc;
	                $tx_dado_posterior = $tx_nome_fantasia_osc;
					//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
				
				$tx_sigla_osc = $request->input('tx_sigla_osc');
				$ft_sigla_osc = $value_db->ft_sigla_osc;
				if($value_db->tx_sigla_osc != $tx_sigla_osc){
					$flag_insert = true;
					
					if($tx_sigla_osc == '') $tx_sigla_osc = null;
					$ft_sigla_osc = $this->ft_representante;
					
	                $tx_nome_campo = 'tx_sigla_osc';
					$id_tabela = $value_db->id_osc;
	                $tx_dado_anterior = $value_db->tx_sigla_osc;
	                $tx_dado_posterior = $tx_sigla_osc;
					//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
				
				$cd_situacao_imovel_osc = null;
				$ft_situacao_imovel_osc = $value_db->ft_situacao_imovel_osc;
				
				if($request->input('cd_situacao_imovel_osc')) $cd_situacao_imovel_osc = $request->input('cd_situacao_imovel_osc');
				
				if($value_db->cd_situacao_imovel_osc != $cd_situacao_imovel_osc){
					$flag_insert = true;
					
					if($cd_situacao_imovel_osc == '') $cd_situacao_imovel_osc = null;
					$ft_situacao_imovel_osc = $this->ft_representante;
					
	                $tx_nome_campo = 'cd_situacao_imovel_osc';
					$id_tabela = $value_db->id_osc;
	                $tx_dado_anterior = $value_db->tx_sigla_osc;
	                $tx_dado_posterior = $cd_situacao_imovel_osc;
					//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
				
				$tx_nome_responsavel_legal = $request->input('tx_nome_responsavel_legal');
				$ft_nome_responsavel_legal = $value_db->ft_nome_responsavel_legal;
				if($value_db->tx_nome_responsavel_legal != $tx_nome_responsavel_legal){
					$flag_insert = true;
					
					if($tx_nome_responsavel_legal == '') $tx_nome_responsavel_legal = null;
					$ft_nome_responsavel_legal = $this->ft_representante;
					
	                $tx_nome_campo = 'tx_nome_responsavel_legal';
					$id_tabela = $value_db->id_osc;
	                $tx_dado_anterior = $value_db->tx_nome_responsavel_legal;
	                $tx_dado_posterior = $tx_nome_responsavel_legal;
					//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
				
				$dt_ano_cadastro_cnpj = null;
				if($request->input('dt_ano_cadastro_cnpj')){
					$dt_ano_cadastro_cnpj = $request->input('dt_ano_cadastro_cnpj');
					if(strlen($dt_ano_cadastro_cnpj) == 4){
						$dt_ano_cadastro_cnpj = $dt_ano_cadastro_cnpj.'-01-01';
					}
					else{
						$date = date_create($dt_ano_cadastro_cnpj);
						$dt_ano_cadastro_cnpj = date_format($date, "Y-m-d");
					}
				}
				
				$ft_ano_cadastro_cnpj = $value_db->ft_ano_cadastro_cnpj;
				if($value_db->dt_ano_cadastro_cnpj != $dt_ano_cadastro_cnpj){
					$flag_insert = true;
					
					$ft_ano_cadastro_cnpj = $this->ft_representante;
					
	                $tx_nome_campo = 'dt_ano_cadastro_cnpj';
					$id_tabela = $value_db->id_osc;
	                $tx_dado_anterior = $value_db->dt_ano_cadastro_cnpj;
	                $tx_dado_posterior = $dt_ano_cadastro_cnpj;
					//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
				
				$dt_fundacao_osc = null;
				if($request->input('dt_fundacao_osc')){
					$dt_fundacao_osc = $request->input('dt_fundacao_osc');
					if(strlen($dt_fundacao_osc) == 4){
						$dt_fundacao_osc = $dt_fundacao_osc.'-01-01';
					}
					else{
						$date = date_create($dt_fundacao_osc);
						$dt_fundacao_osc = date_format($date, "Y-m-d");
					}
				}
				
				$ft_fundacao_osc = $value_db->ft_fundacao_osc;
				if($value_db->dt_fundacao_osc != $dt_fundacao_osc){
					$flag_insert = true;
					
					$ft_fundacao_osc = $this->ft_representante;
					
	                $tx_nome_campo = 'dt_fundacao_osc';
					$id_tabela = $value_db->id_osc;
	                $tx_dado_anterior = $value_db->dt_fundacao_osc;
	                $tx_dado_posterior = $tx_nome_responsavel_legal;
					//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
				
				$tx_resumo_osc = $request->input('tx_resumo_osc');
				$ft_resumo_osc = $value_db->ft_resumo_osc;
				if($value_db->tx_resumo_osc != $tx_resumo_osc){
					$flag_insert = true;
					
					if($tx_resumo_osc == '') $tx_resumo_osc = null;
					$ft_resumo_osc = $this->ft_representante;
					
	                $tx_nome_campo = 'tx_resumo_osc';
					$id_tabela = $value_db->id_osc;
	                $tx_dado_anterior = $value_db->tx_resumo_osc;
	                $tx_dado_posterior = $tx_nome_responsavel_legal;
					//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
				}
				
				$this->setApelido($request, $id_osc);
				$this->setContatos($request, $id_osc);
	    	}
			
			if($flag_insert){
				$params = [$im_logo, $ft_logo, $id_osc];
	    		$resultDao = $this->dao->updateLogo($params);
				
	    		$params = [$id_osc, $tx_nome_fantasia_osc, $ft_nome_fantasia_osc, $tx_sigla_osc, $ft_sigla_osc, $cd_situacao_imovel_osc, $ft_situacao_imovel_osc, $tx_nome_responsavel_legal, $ft_nome_responsavel_legal, $dt_ano_cadastro_cnpj, $ft_ano_cadastro_cnpj, $dt_fundacao_osc, $ft_fundacao_osc, $tx_resumo_osc, $ft_resumo_osc];
	    		$resultDao = $this->dao->updateDadosGerais($params);
				
				$result = ['msg' => $resultDao->mensagem];
			}
			
    		$this->configResponse($result);
    	}else{
    		$result = ['msg' => 'Não existe OSC com este ID.'];
    		$this->configResponse($result, 400);
    	}
		
    	return $this->response();
    }
	
    private function setApelido(Request $request, $id_osc)
    {
        $id_usuario = $request->user()->id;
		
    	$osc_db = DB::select('SELECT * FROM osc.tb_osc WHERE id_osc = ?::INTEGER', [$id_osc]);
		
		$flag_insert = false;
    	foreach($osc_db as $key_db => $value_db){
			$tx_apelido_osc = $request->input('tx_apelido_osc');
			$ft_apelido_osc = $value_db->ft_apelido_osc;
			if($value_db->tx_apelido_osc != $tx_apelido_osc){
				$flag_insert = true;
				
				if($tx_apelido_osc == '') $tx_apelido_osc = null;
				$ft_apelido_osc = $this->ft_representante;
				
				$tx_nome_campo = 'tx_apelido_osc';
				$id_tabela = $value_db->id_osc;
				$tx_dado_anterior = $value_db->tx_apelido_osc;
				$tx_dado_posterior = $tx_apelido_osc;
				//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
			}
    	}
		
		if($flag_insert){
    		$params = [$id_osc, $tx_apelido_osc, $ft_apelido_osc];
    		$result = $this->dao->updateApelido($params);
		}
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
		
		$flag_insert = false;
		foreach($contatos_db as $key_db => $value_db){
			$tx_telefone = $request->input('tx_telefone');
			$ft_telefone = $value_db->ft_telefone;
			if($value_db->tx_telefone != $tx_telefone){
				$flag_insert = true;
				
				if($tx_telefone == '') $tx_telefone = null;
				$ft_telefone = $this->ft_representante;
				
				$tx_nome_campo = 'tx_telefone';
				$id_tabela = $value_db->id_osc;
				$tx_dado_anterior = $value_db->tx_telefone;
				$tx_dado_posterior = $tx_telefone;
				//$resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
			}
			
			$tx_email = $request->input('tx_email');
			$ft_email = $value_db->ft_email;
			if($value_db->tx_email != $tx_email){
				$flag_insert = true;
				
				if($tx_email == '') $tx_email = null;
				$ft_email = $this->ft_representante;
				
				$tx_nome_campo = 'tx_email';
				$id_tabela = $value_db->id_osc;
				$tx_dado_anterior = $value_db->tx_email;
				$tx_dado_posterior = $tx_email;
				//$resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
			}
			
			$tx_site = $request->input('tx_site');
			$ft_site = $value_db->ft_site;
			if($value_db->tx_site != $tx_site){
				$flag_insert = true;
				
				if($tx_site == '') $tx_site = null;
				$ft_site = $this->ft_representante;
				
				$tx_nome_campo = 'tx_site';
				$id_tabela = $value_db->id_osc;
				$tx_dado_anterior = $value_db->tx_site;
				$tx_dado_posterior = $tx_site;
				//$resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
			}
		}
		
		if($flag_insert){
			$params = [$id_osc, $tx_telefone, $ft_telefone, $tx_email, $ft_email, $tx_site, $ft_site];
			$result = $this->dao->updateContatos($params);
		}
    }
	
	private function insertContatos(Request $request, $id_osc)
	{
        $id_usuario = $request->user()->id;
		
		$tx_telefone = $request->input('tx_telefone');
		if($tx_telefone == '') $tx_telefone = null;
        $ft_telefone = $this->ft_representante;
        
        //$tx_nome_campo = 'tx_telefone';
        //$id_tabela = $value->id_osc;
        //$tx_dado_anterior = $value->tx_telefone;
        //$tx_dado_posterior = $telefone;
        //$resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
		
    	$tx_email = $request->input('tx_email');
		if($tx_email == '') $tx_email = null;
        $ft_email = $this->ft_representante;
        
        //$tx_nome_campo = 'tx_email';
        //$id_tabela = $value->id_osc;
        //$tx_dado_anterior = $value->tx_email;
        //$tx_dado_posterior = $email;
        //$resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
		
    	$tx_site = $request->input('tx_site');
		if($tx_site == '') $tx_site = null;
        $ft_site = $this->ft_representante;
        
        //$tx_nome_campo = 'tx_site';
        //$id_tabela = $value->id_osc;
        //$tx_dado_anterior = $value->tx_site;
        //$tx_dado_posterior = $site;
        //$resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
		
		$params = [$id_osc, $tx_telefone, $ft_telefone, $tx_email, $ft_email, $tx_site, $ft_site];
		$result = $this->dao->insertContatos($params);
	}
	
    public function setAreaAtuacao(Request $request, $id_osc)
    {
		$query = "SELECT * FROM osc.tb_area_atuacao WHERE id_osc = ?::INTEGER;";
		$area_atuacao_db = DB::select($query, [$id_osc]);
		
		$array_insert = array();
		$array_update = array();
		$array_delete = $area_atuacao_db;
		$array_area_atuacao_outra = array();
		
		$cd_area_atuacao_outra = 10;
		$array_cd_subarea_atuacao_outra = array(2, 5, 8, 16, 18, 20, 25, 28, 34);
		
		$array_macro = array();
		
		if($request->area_atuacao){
			$area_atuacao_req = $request->area_atuacao;
	    	foreach($area_atuacao_req as $key_req => $value_area_req){
				$cd_area_atuacao = $value_area_req['cd_area_atuacao'];
				
	            $cd_subarea_atuacao = null;
	            
				if($value_area_req['subarea_atuacao'] && $cd_area_atuacao != $cd_area_atuacao_outra){
					$tx_nome_outra = null;
					
	    			foreach($value_area_req['subarea_atuacao'] as $key_subarea_req => $value_subarea_req){
	    				$cd_subarea_atuacao = $value_subarea_req['cd_subarea_atuacao'];
						if(in_array($cd_subarea_atuacao, $array_cd_subarea_atuacao_outra)){
							$tx_nome_outra = $value_subarea_req['tx_nome_subarea_atuacao_outra'];
						}
						else{
							$tx_nome_outra = null;
						}
						
						$params = ["cd_area_atuacao" => $cd_area_atuacao, "cd_subarea_atuacao" => $cd_subarea_atuacao, "tx_nome_outra" => $tx_nome_outra];
						
						$flag_insert = true;
						$flag_update = false;
						foreach ($area_atuacao_db as $key_area_db => $value_area_db) {
							if($value_area_db->cd_area_atuacao == $cd_area_atuacao && $value_area_db->cd_subarea_atuacao == $cd_subarea_atuacao){
								$flag_insert = false;
								if($value_area_db->tx_nome_outra != $tx_nome_outra && in_array($params['cd_subarea_atuacao'], $array_cd_subarea_atuacao_outra)){
									$flag_update = true;
								}
								if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
							}
						}
						
						if($flag_insert){
							array_push($array_insert, $params);
							if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
						}
						
						if($flag_update){
							array_push($array_update, $params);
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
					$tx_nome_outra = $value_area_req['tx_nome_area_atuacao_outra'];
					
					$params = ["cd_area_atuacao" => $cd_area_atuacao, "cd_subarea_atuacao" => null, "tx_nome_outra" => $tx_nome_outra];
					
					$flag_insert = true;
					$flag_update = false;
					foreach ($area_atuacao_db as $key_area_db => $value_area_db) {
						if($value_area_db->cd_area_atuacao == $cd_area_atuacao && $value_area_db->cd_subarea_atuacao == null){
							$flag_insert = false;
							if($value_area_db->tx_nome_outra != $tx_nome_outra && $params['cd_area_atuacao'] == $cd_area_atuacao_outra){
								$flag_update = true;
							}
							if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
						}
					}
					
					if($flag_insert){
						array_push($array_insert, $params);
						if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
					}
					
					if($flag_update){
						array_push($array_update, $params);
						if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
					}
					
					foreach ($array_delete as $key_area_del => $value_area_del) {
						if($value_area_del->cd_area_atuacao == $cd_area_atuacao && $value_area_del->cd_subarea_atuacao == $cd_subarea_atuacao){
							unset($array_delete[$key_area_del]);
						}
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
			foreach($array_delete as $key => $value){
				$this->deleteAreaAtuacao($value, $id_osc);
			}
			
			foreach($array_update as $key => $value){
				$this->updateAreaAtuacao($value, $id_osc);
			}
			
			foreach($array_insert as $key => $value){
				$this->insertAreaAtuacao($value, $id_osc);
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
	
    public function setDescricao(Request $request, $id_osc)
    {
		$result = ['msg' => "Descrição atualizada."];
		
		$id_usuario = $request->user()->id;
		
    	$descricao_db = DB::select('SELECT * FROM osc.tb_dados_gerais WHERE id_osc = ?::INTEGER', [$id_osc]);
		
		$flag_insert = false;
		
    	foreach($descricao_db as $key_db => $value_db){
			$tx_historico = $tx_historico = $request->input('tx_historico');
			$ft_historico = $value_db->ft_historico;
			if($value_db->tx_historico != $tx_historico){
				$flag_insert = true;
				$ft_historico = $this->ft_representante;
				
				$tx_nome_campo = 'tx_historico';
				$id_tabela = $value_db->id_osc;
				$tx_dado_anterior = $value_db->tx_historico;
				$tx_dado_posterior = $tx_historico;
				//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
			}
			
			$tx_missao_osc = $request->input('tx_missao_osc');
			$ft_missao_osc = $value_db->ft_missao_osc;
			if($value_db->tx_missao_osc != $tx_missao_osc){
				$flag_insert = true;
				$ft_missao_osc = $this->ft_representante;
				
				$tx_nome_campo = 'tx_missao_osc';
				$id_tabela = $value_db->id_osc;
				$tx_dado_anterior = $value_db->tx_missao_osc;
				$tx_dado_posterior = $tx_missao_osc;
				//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
			}
			
			$tx_visao_osc = $request->input('tx_visao_osc');
			$ft_visao_osc = $value_db->ft_visao_osc;
			if($value_db->tx_visao_osc != $tx_visao_osc){
				$flag_insert = true;
				$ft_visao_osc = $this->ft_representante;
				
				$tx_nome_campo = 'tx_visao_osc';
				$id_tabela = $value_db->id_osc;
				$tx_dado_anterior = $value_db->tx_visao_osc;
				$tx_dado_posterior = $tx_visao_osc;
				//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
			}
			
			$tx_finalidades_estatutarias = $request->input('tx_finalidades_estatutarias');
			$ft_finalidades_estatutarias = $value_db->ft_finalidades_estatutarias;
			if($value_db->tx_finalidades_estatutarias != $tx_finalidades_estatutarias){
				$flag_insert = true;
				$ft_finalidades_estatutarias = $this->ft_representante;
				
				$tx_nome_campo = 'tx_finalidades_estatutarias';
				$id_tabela = $value_db->id_osc;
				$tx_dado_anterior = $value_db->tx_finalidades_estatutarias;
				$tx_dado_posterior = $tx_finalidades_estatutarias;
				//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
			}
			
			$tx_link_estatuto_osc = $request->input('tx_link_estatuto_osc');
			$ft_link_estatuto_osc = $value_db->ft_link_estatuto_osc;
			if($value_db->tx_link_estatuto_osc != $tx_link_estatuto_osc){
				$flag_insert = true;
				$ft_link_estatuto_osc = $this->ft_representante;
				
				$tx_nome_campo = 'tx_link_estatuto_osc';
				$id_tabela = $value_db->id_osc;
				$tx_dado_anterior = $value_db->tx_link_estatuto_osc;
				$tx_dado_posterior = $tx_link_estatuto_osc;
				//$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
			}
    	}
		
		if($flag_insert){
    		$params = [$id_osc, $tx_historico, $ft_historico, $tx_missao_osc, $ft_missao_osc, $tx_visao_osc, $ft_visao_osc, $tx_finalidades_estatutarias, $ft_finalidades_estatutarias, $tx_link_estatuto_osc, $ft_link_estatuto_osc];
    		$resultDao = $this->dao->updateDescricao($params);
	    	$result = ['msg' => $resultDao->mensagem];
		}
		
    	$this->configResponse($result);
    	return $this->response();
    }
	
    public function setCertificado(Request $request, $id_osc)
    {
    	$req = $request->certificado;
    	
    	$query = "SELECT * FROM osc.tb_certificado WHERE id_osc = ?::INTEGER;";
    	$db = DB::select($query, [$id_osc]);
    	
    	$array_insert = array();
    	$array_update = array();
    	$array_delete = $db;
    	
    	if($req){
	    	foreach($req as $key_req => $value_req){
	    		$id_certificado = $value_req['id_certificado'];
	    		
	    		$cd_certificado = $value_req['cd_certificado'];
	    	    
	    		$dt_inicio_certificado = null;
	    		if(isset($value_req['dt_inicio_certificado'])){
	    			if($value_req['dt_inicio_certificado'] != null){
	    				$date = date_create($value_req['dt_inicio_certificado']);
	    				$dt_inicio_certificado = date_format($date, "Y-m-d");
	    			}
	    		}
	    		
	    		$dt_fim_certificado = null;
	    		if(isset($value_req['dt_fim_certificado'])){
	    			if($value_req['dt_fim_certificado'] != null){
	    				$date = date_create($value_req['dt_fim_certificado']);
	    				$dt_fim_certificado = date_format($date, "Y-m-d");
	    			}
	    		}
	    		
	    		$params = ["id_osc" => $id_osc, "cd_certificado" => $cd_certificado, "dt_inicio_certificado" => $dt_inicio_certificado, "dt_fim_certificado" => $dt_fim_certificado];
	    		
	    		$flag_insert = true;
	    		$flag_update = false;
	    		foreach ($db as $key_db => $value_db) {
	    			if($id_certificado == null){
	    				if($cd_certificado != $value_db->cd_certificado || $cd_certificado == 7 || $cd_certificado == 8)
	    					$flag_insert = true;
	    				else
	    					$flag_insert = false;
	    			}else{
	    				$flag_insert = false;
	    				if($value_db->dt_inicio_certificado != $dt_inicio_certificado || $value_db->dt_fim_certificado != $dt_fim_certificado){
	    					$flag_update = true;
	    			
	    					$params = ["id_certificado" => $id_certificado, "id_osc" => $id_osc, "cd_certificado" => $cd_certificado, "dt_inicio_certificado" => $dt_inicio_certificado, "dt_fim_certificado" => $dt_fim_certificado];
	    					$params['ft_certificado'] = $value_db->ft_certificado;
	    			
	    					if($value_db->dt_inicio_certificado != $dt_inicio_certificado){
	    						$params['ft_inicio_certificado'] = $this->ft_representante;
	    					}
	    					else{
	    						$params['ft_inicio_certificado'] = $value_db->ft_inicio_certificado;
	    					}
	    			
	    					if($value_db->dt_fim_certificado != $dt_fim_certificado){
	    						$params['ft_fim_certificado'] = $this->ft_representante;
	    					}
	    					else{
	    						$params['ft_fim_certificado'] = $value_db->ft_fim_certificado;
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
	    		
	    		foreach ($array_delete as $key_del => $value_del) {
	    			if($value_del->id_certificado == $id_certificado){
	    				unset($array_delete[$key_del]);
	    			}
	    		}
	    	}
    	}
    	foreach($array_insert as $key => $value){
    		$this->insertCertificado($value);
    	}
    	
    	foreach($array_update as $key => $value){
    		$this->updateCertificado($value);
    	}
    	
    	$flag_error_delete = false;
    	foreach($array_delete as $key => $value){
    		if($value->bo_oficial){
    			$flag_error_delete = true;
    		}
    		else{
    			$this->deleteCertificado($value);
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
	
	private function insertCertificado($params)
	{
		$id_osc = $params['id_osc'];
		
		$cd_certificado = $params['cd_certificado'];
		if($cd_certificado != null) $ft_certificado = $this->ft_representante;
		else $ft_certificado = null;
		
		$dt_inicio_certificado = $params['dt_inicio_certificado'];
		if($dt_inicio_certificado != null) $ft_inicio_certificado = $this->ft_representante;
		else $ft_inicio_certificado = null;
		
		$dt_fim_certificado = $params['dt_fim_certificado'];
		if($dt_fim_certificado != null) $ft_fim_certificado = $this->ft_representante;
		else $ft_fim_certificado = null;
		
		$bo_oficial = false;
		
		$params = [$id_osc, $cd_certificado, $ft_certificado, $dt_inicio_certificado, $ft_inicio_certificado, $dt_fim_certificado, $ft_fim_certificado, $bo_oficial];
		$result = $this->dao->insertCertificado($params);
		
		return $result;
	}
	
	private function updateCertificado($params)
	{
		$id_osc = $params['id_osc'];
		$id_certificado = $params['id_certificado'];
		$json = DB::select('SELECT * FROM osc.tb_certificado WHERE id_osc = ?::INTEGER AND id_certificado = ?::INTEGER;', [$id_osc, $id_certificado]);
		
		foreach($json as $key => $value){
			$bo_oficial = $value->bo_oficial;
			if(!$bo_oficial){
				
				$cd_certificado = $params['cd_certificado'];
				if($value->cd_certificado != $cd_certificado) $ft_certificado = $this->ft_representante;
				else $ft_certificado = $json[$key]->ft_certificado;
				
				$dt_inicio_certificado = $params['dt_inicio_certificado'];
				if($value->dt_inicio_certificado != $dt_inicio_certificado) $ft_inicio_certificado = $this->ft_representante;
				else $ft_inicio_certificado = $json[$key]->ft_inicio_certificado;
				
				$dt_fim_certificado = $params['dt_fim_certificado'];
				if($value->dt_fim_certificado != $dt_fim_certificado) $ft_fim_certificado = $this->ft_representante;
				else $ft_fim_certificado = $json[$key]->ft_fim_certificado;
				
				$params = [$cd_certificado, $dt_inicio_certificado, $ft_inicio_certificado, $dt_fim_certificado, $ft_fim_certificado, $id_osc, $id_certificado];
				$resultDao = $this->dao->updateCertificado($params);
	
				$result = ['msg' => "Certificados atualizado"];
			}else{
				$result = ['msg' => 'Dado Oficial, não pode ser modificado.'];
			}
		}
		$this->configResponse($result);
		return $this->response();
	}
	
	private function deleteCertificado($params)
	{
		$id_certificado = $params->id_certificado;
		$params = [$id_certificado];
		$result = $this->dao->deleteCertificado($params);
		
		return $result;
	}
	
	public function setDirigente(Request $request, $id_osc)
	{
		$dirigente_req = $request->governanca;
		
		$query = "SELECT * FROM osc.tb_governanca WHERE id_osc = ?::INTEGER;";
		$diregente_db = DB::select($query, [$id_osc]);
		
		$array_insert = array();
		$array_update = array();
		$array_delete = $diregente_db;
		
		if($dirigente_req){
			foreach($dirigente_req as $key_req => $value_req){
				$id_dirigente = $value_req['id_dirigente'];
				$tx_cargo_dirigente = $value_req['tx_cargo_dirigente'];
				$tx_nome_dirigente = $value_req['tx_nome_dirigente'];
				
				$params = array();
				$params['id_osc'] = $id_osc;
				$params['tx_cargo_dirigente'] = $tx_cargo_dirigente;
				$params['tx_nome_dirigente'] = $tx_nome_dirigente;
				
				if($id_dirigente){
					foreach ($diregente_db as $key_db => $value_db) {
						if($value_db->id_dirigente == $id_dirigente){
							unset($array_delete[$key_db]);
							
							if($value_db->tx_nome_dirigente != $tx_nome_dirigente || $value_db->tx_nome_dirigente != $tx_nome_dirigente){
								$params['id_dirigente'] = $id_dirigente;
								$params['dirigente_db'] = $value_db;
								array_push($array_update, $params);
							}
						}
					}
				}
				else{
					array_push($array_insert, $params);
				}
			}
		}
		
		foreach($array_delete as $key => $value){
			$this->deleteDirigente($value);
		}
		
		foreach($array_update as $key => $value){
			$this->updateDirigente($value);
		}
		
		foreach($array_insert as $key => $value){
			$this->insertDirigente($value);
		}
		
		$result = ['msg' => 'Governança atualizada.'];
		$this->configResponse($result, 200);
		
		return $this->response();
	}
	
    private function insertDirigente($params)
    {
    	$id_osc = $params['id_osc'];
    	$cargo = $params['tx_cargo_dirigente'];
    	$fonte_cargo = $this->ft_representante;
    	$nome = $params['tx_nome_dirigente'];
    	$fonte_nome = $this->ft_representante;
    	$bo_oficial = false;
		
    	$params = [$id_osc, $cargo, $fonte_cargo, $nome, $fonte_nome, $bo_oficial];
    	$result = $this->dao->insertDirigente($params);
		
    	return $result;
    }
	
    private function updateDirigente($params)
    {
    	$dirigente_db = $params['dirigente_db'];
		
    	$id_osc = $params['id_osc'];
    	$id_dirigente = $params['id_dirigente'];
		
    	$cargo = $params['tx_cargo_dirigente'];
    	$fonte_cargo = $dirigente_db->ft_cargo_dirigente;
    	
    	$nome = $params['tx_nome_dirigente'];
    	$fonte_nome = $dirigente_db->ft_nome_dirigente;
		
		if($dirigente_db->tx_nome_dirigente != $nome){
			$fonte_nome = $this->ft_representante;
		}
		
		if($dirigente_db->tx_cargo_dirigente != $cargo){
			$fonte_nome = $this->ft_representante;
		}
		
    	$params = [$id_osc, $id_dirigente, $cargo, $fonte_cargo, $nome, $fonte_nome];
    	$result = $this->dao->updateDirigente($params);
		
    	return $result;
    }
	
    private function deleteDirigente($params)
    {
    	$id_dirigente = $params->id_dirigente;
		
    	$params = [$id_dirigente];
    	$result = $this->dao->deleteDirigente($params);
		
    	return $result;
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
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado.'];
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
    			$result = ['msg' => 'Membro do Conselho excluído.'];
    		}
    		else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluído.'];
    		}
    	}
		
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setRelacoesTrabalho(Request $request, $id_osc)
    {
    	$nr_trabalhadores_voluntarios = null;
    	if($request->input('relacoes_trabalho')){
    		$relacoes_trabalho = $request->input('relacoes_trabalho');
    		$nr_trabalhadores_voluntarios = $relacoes_trabalho['nr_trabalhadores_voluntarios'];
    	}
    	else if($request->input('nr_trabalhadores_voluntarios')){
    		$nr_trabalhadores_voluntarios = $request->input('nr_trabalhadores_voluntarios');
    	}
		
    	$relacoes_trabalho_db = DB::select('SELECT * FROM osc.tb_relacoes_trabalho WHERE id_osc = ?::INTEGER', [$id_osc]);
		
    	$array_insert = array();
    	$array_update = array();
    	
    	if($relacoes_trabalho_db){
	    	foreach($relacoes_trabalho_db as $key_db => $value_db){
		    	if($value_db->nr_trabalhadores_voluntarios != $nr_trabalhadores_voluntarios){
					$params = ['id_osc' => $id_osc, 'nr_trabalhadores_voluntarios' => $nr_trabalhadores_voluntarios];
		    		array_push($array_update, $params);
		    	}
	    	}
    	}
    	else{
    		$params = ['id_osc' => $id_osc, 'nr_trabalhadores_voluntarios' => $nr_trabalhadores_voluntarios];
    		array_push($array_insert, $params);
    	}
		
    	foreach($array_insert as $key => $value){
			$this->insertRelacoesTrabalho($value);
		}
		
    	foreach($array_update as $key => $value){
			$this->updateRelacoesTrabalho($value);
		}
		
    	$result = ['msg' => 'Relações de trabalho atualizada.'];
    	$this->configResponse($result, 200);
    	return $this->response();
    }
	
    private function insertRelacoesTrabalho($params){
		$id_osc = $params['id_osc'];
		$nr_trabalhadores_voluntarios = $params['nr_trabalhadores_voluntarios'];
    	$ft_trabalhadores_voluntarios = $this->ft_representante;
		
    	$params = [$id_osc, $nr_trabalhadores_voluntarios, $ft_trabalhadores_voluntarios];
    	$result = $this->dao->insertRelacoesTrabalho($params);
		
    	return $result;
    }
	
    private function updateRelacoesTrabalho($params){
		$id_osc = $params['id_osc'];
		$nr_trabalhadores_voluntarios = $params['nr_trabalhadores_voluntarios'];
    	$ft_trabalhadores_voluntarios = $this->ft_representante;
		
    	$params = [$id_osc, $nr_trabalhadores_voluntarios, $ft_trabalhadores_voluntarios];
    	$result = $this->dao->updateRelacoesTrabalho($params);
		
    	return $result;
    }
	
    public function outrosTrabalhadores(Request $request, $id)
    {
    	$result = DB::select('SELECT * FROM osc.tb_relacoes_trabalho_outra WHERE id_osc = ?::int',[$id]);
    	if($result != null){
    		$this->updateOutrosTrabalhadores($request, $id);
    	}
    	else{
    		$this->setOutrosTrabalhadores($request, $id);
    	}
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
		$req = $request->conselho;
		
		$query = "SELECT * FROM osc.tb_participacao_social_conselho WHERE id_osc = ?::INTEGER;";
		$db = DB::select($query, [$id_osc]);
		
		$array_insert = array();
		$array_update = array();
		$array_delete = $db;
		
		$array_insert_membro_conselho = array();
		$array_delete_membro_conselho = array();
		
		if($req){
			foreach($req as $key_req => $value_req){
				if(isset($value_req['conselho'])){
					$conselho = $value_req['conselho'];
					
					if(isset($conselho['cd_conselho'])){
						$cd_conselho = $conselho['cd_conselho'];
						
						$cd_tipo_participacao = null;
						if($conselho['cd_tipo_participacao']){
							$cd_tipo_participacao = $conselho['cd_tipo_participacao'];
						}
						
						$tx_nome_conselho = null;
						if($conselho['tx_nome_conselho']){
							$tx_nome_conselho = $conselho['tx_nome_conselho'];
						}
						
						$cd_periodicidade_reuniao_conselho = null;
						if($conselho['cd_periodicidade_reuniao_conselho']){
							$cd_periodicidade_reuniao_conselho = $conselho['cd_periodicidade_reuniao_conselho'];
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
						
						$params = ["cd_conselho" => $cd_conselho, "tx_nome_conselho" => $tx_nome_conselho, "cd_tipo_participacao" => $cd_tipo_participacao, "cd_periodicidade_reuniao_conselho" => $cd_periodicidade_reuniao_conselho, "dt_data_inicio_conselho" => $dt_data_inicio_conselho, "dt_data_fim_conselho" => $dt_data_fim_conselho, "representante" => $representante];
						
						$flag_insert = true;
						$flag_update = false;
						foreach ($db as $key_conselho_db => $value_conselho_db) {
							
							if($value_conselho_db->cd_conselho == $cd_conselho){
								$flag_insert = false;
								
								$id_conselho = $conselho['id_conselho'];
								$json_outro = DB::select('SELECT * FROM osc.tb_participacao_social_conselho_outro WHERE id_conselho = ?::INTEGER;', [$id_conselho]);
								
								foreach($json_outro as $key_outro => $value_outro){
									if($value_outro->tx_nome_conselho != $tx_nome_conselho){
										$flag_update = true;
									}
								}
							
								if($value_conselho_db->cd_tipo_participacao != $cd_tipo_participacao || $value_conselho_db->cd_periodicidade_reuniao_conselho != $cd_periodicidade_reuniao_conselho || $value_conselho_db->dt_data_inicio_conselho != $dt_data_inicio_conselho || $value_conselho_db->dt_data_fim_conselho != $dt_data_fim_conselho || $tx_nome_conselho != null){
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
			$result = ['msg' => 'Participação social em conselhos atualizada.'];
			$this->configResponse($result, 200);
		}
		else{
			$result = ['msg' => 'Participação social em conselhos atualizada.'];
			$this->configResponse($result, 200);
		}
		
		return $this->response();
	}
	
    private function insertParticipacaoSocialConselho($params, $id_osc)
    {
    	$cd_conselho = $params['cd_conselho'];
    	$ft_conselho = $this->ft_representante;
    	
    	$tx_nome_conselho = $params['tx_nome_conselho'];
		$ft_nome_conselho = $this->ft_representante;
    	
    	$cd_tipo_participacao = $params['cd_tipo_participacao'];
    	$ft_tipo_participacao = $this->ft_representante;
		
    	$cd_periodicidade_reuniao_conselho = $params['cd_periodicidade_reuniao_conselho'];
    	$ft_periodicidade_reuniao = $this->ft_representante;
		
    	$dt_inicio_conselho = $params['dt_data_inicio_conselho'];
    	$ft_dt_inicio_conselho = $this->ft_representante;
		
    	$dt_fim_conselho = $params['dt_data_fim_conselho'];
    	$ft_dt_fim_conselho = $this->ft_representante;
		
    	$bo_oficial = false;
		
		$representantes = $params['representante'];
		
    	$params = [$id_osc, $cd_conselho, $ft_conselho, $cd_tipo_participacao, $ft_tipo_participacao, $cd_periodicidade_reuniao_conselho, $ft_periodicidade_reuniao, $dt_inicio_conselho, $ft_dt_inicio_conselho, $dt_fim_conselho, $ft_dt_fim_conselho, $bo_oficial];
    	$result = $this->dao->insertParticipacaoSocialConselho($params);
		
		if($result){
			$id_conselho = $result->id_conselho;
			foreach ($representantes as $key_representante => $value_representante) {
				$tx_nome_representante_conselho = $value_representante;
				
				$params = [$id_osc, $id_conselho, $tx_nome_representante_conselho];
				$result = $this->insertMembroParticipacaoSocialConselho($params);
			}
			
			if($tx_nome_conselho != null){
				$params = [$tx_nome_conselho, $ft_nome_conselho, $id_conselho];
				$this->dao->setParticipacaoSocialConselhoOutro($params);
			}
		}
		
    }
	
	private function insertMembroParticipacaoSocialConselho($params){
		$ft_nome_representante_conselho = $this->ft_representante;
		$bo_oficial = false;
		array_push($params, $ft_nome_representante_conselho, $bo_oficial);
		
		$result = $this->dao->insertMembroParticipacaoSocialConselho($params);
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
    			else $ft_tipo_participacao = $value->ft_tipo_participacao;
    			
    			$tx_nome_conselho = $params['tx_nome_conselho'];
    			$ft_nome_conselho = $this->ft_representante;
				
    			$cd_periodicidade_reuniao_conselho = $params['cd_periodicidade_reuniao_conselho'];
    			if($value->cd_periodicidade_reuniao_conselho != $cd_periodicidade_reuniao_conselho) $ft_periodicidade_reuniao = $this->ft_representante;
    			else $ft_periodicidade_reuniao = $value->ft_periodicidade_reuniao;
				
    			$dt_inicio_conselho = $params['dt_data_inicio_conselho'];
    			if($value->dt_data_inicio_conselho != $dt_inicio_conselho) $ft_dt_inicio_conselho = $this->ft_representante;
    			else $ft_dt_inicio_conselho = $value->ft_data_inicio_conselho;
				
    			$dt_fim_conselho = $params['dt_data_fim_conselho'];
    			if($value->dt_data_fim_conselho != $dt_fim_conselho) $ft_dt_fim_conselho = $this->ft_representante;
    			else $ft_dt_fim_conselho = $value->ft_data_fim_conselho;
				
    			$params = [$id_osc, $cd_conselho, $cd_tipo_participacao, $ft_tipo_participacao, $cd_periodicidade_reuniao_conselho, $ft_periodicidade_reuniao, $dt_inicio_conselho, $ft_dt_inicio_conselho, $dt_fim_conselho, $ft_dt_fim_conselho];
    			$resultDao = $this->dao->updateParticipacaoSocialConselho($params);
    			
    			$id_conselho = $value->id_conselho;
    			$json_outro = DB::select('SELECT * FROM osc.tb_participacao_social_conselho_outro WHERE id_conselho = ?::INTEGER;', [$id_conselho]);
    			     			 
    			if(count($json_outro)>0){
    				if($tx_nome_conselho != null){
    					foreach($json_outro as $key_outro => $value_outro){
    						if($id_conselho == $value_outro->id_conselho){
    							if($value_outro->tx_nome_conselho != $tx_nome_conselho){ 
    								$ft_nome_conselho = $this->ft_representante;
    								
    								$params = [$tx_nome_conselho, $ft_nome_conselho, $id_conselho];
    								$this->dao->updateParticipacaoSocialConselhoOutro($params);
    							}
    						}
    					}
    				}else{
    					$this->deleteParticipacaoSocialConselhoOutro($id_conselho, $id_osc);
    				}
    			
    			}else{
    				if($tx_nome_conselho != null){
    					$params = [$tx_nome_conselho, $ft_nome_conselho, $id_conselho];
    					$this->dao->setParticipacaoSocialConselhoOutro($params);
    				}
    			}
    			
    			$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado.'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    private function deleteParticipacaoSocialConselho($cd_conselho, $id_osc)
    {
    	$params = [$id_osc, $cd_conselho];
    	$id_conselho = $this->dao->selectIdParticipacaoSocialConselho($params);
    	
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conselho_outro WHERE id_conselho = ?::INTEGER;', [$id_conselho]);
    	 
    	foreach($json as $key => $value){
    		if($id_conselho == $value->id_conselho){
    			$this->deleteParticipacaoSocialConselhoOutro($id_conselho, $id_osc);
    		}
    	}
		
		$params = [$id_conselho];
		$this->dao->deleteMembroParticipacaoSocialConselhoByIdConselho($params);
		
		$params = [$id_osc, $cd_conselho];
		$result = $this->dao->deleteParticipacaoSocialConselho($params);
		
		return $result;
    }
	
	private function deleteMembroParticipacaoSocialConselho($params){
		$result = $this->dao->deleteMembroParticipacaoSocialConselho($params);
	}
	
	public function deleteParticipacaoSocialConselhoOutro($id_conselho, $id)
	{		
		$json_conselho = DB::select('SELECT * FROM osc.tb_participacao_social_conselho WHERE id_conselho = ?::int',[$id_conselho]);
		foreach($json_conselho as $key_conselho => $value){
			$id_osc = $json_conselho[$key_conselho]->id_osc;
			if($id_osc == $id){
				$bo_oficial = $json_conselho[$key_conselho]->bo_oficial;
				if(!$bo_oficial){
					$params = [$id_conselho];
					$resultDao = $this->dao->deleteParticipacaoSocialConselhoOutro($params);
					$result = ['msg' => 'Participacao Social Conselho Outro excluido'];
				}else{
					$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
				}
			}else{
				$result = ['msg' => 'Erro_osc'];
			}
		}
		
		$this->configResponse($result);
		return $this->response();
	}
	
    public function setParticipacaoSocialConferencia(Request $request, $id_osc)
    {
		$req = $request->conferencia;
		
		$query = "SELECT * FROM osc.tb_participacao_social_conferencia WHERE id_osc = ?::INTEGER;";
		$db = DB::select($query, [$id_osc]);
		
		$array_insert = array();
		$array_update = array();
		$array_delete = $db;
		
		$result = ['msg' => 'Participação social em conferência atualizada'];
		if($req){
			foreach($req as $key_req => $value_req){
				$flag_insert = true;
				
				$cd_conferencia = null;
				if(isset($value_req['cd_conferencia'])){
					$cd_conferencia = $value_req['cd_conferencia'];
					
					$tx_nome_conferencia = null;
					if($value_req['tx_nome_conferencia']){
						$tx_nome_conferencia = $value_req['tx_nome_conferencia'];
					}
					
					$dt_ano_realizacao = null;
					if($value_req['dt_ano_realizacao']){
						if(strlen($value_req['dt_ano_realizacao']) == 4){
							$dt_ano_realizacao = $value_req['dt_ano_realizacao'].'-01-01';
						}
						else{
							$dt_ano_realizacao = $value_req['dt_ano_realizacao'];
						}
						
						$date = date_create($dt_ano_realizacao);
						$dt_ano_realizacao = date_format($date, "Y-m-d");
					}
					
					$cd_forma_participacao_conferencia = null;
					if($value_req['cd_forma_participacao_conferencia']){
						$cd_forma_participacao_conferencia = $value_req['cd_forma_participacao_conferencia'];
					}
					
					$params = ["id_osc" => $id_osc, "cd_conferencia" => $cd_conferencia, "tx_nome_conferencia" => $tx_nome_conferencia, "dt_ano_realizacao" => $dt_ano_realizacao, "cd_forma_participacao_conferencia" => $cd_forma_participacao_conferencia];
					
					foreach ($db as $key_db => $value_db) {
						if($value_db->cd_conferencia == $cd_conferencia && $value_db->dt_ano_realizacao == $dt_ano_realizacao){
							$flag_insert = false;
							
							$params['ft_conferencia'] = $value_db->ft_conferencia;
							$params['ft_ano_realizacao'] = $value_db->ft_ano_realizacao;
							$params['bo_oficial'] = $value_db->bo_oficial;
							
							$id_conferencia = $value_db->id_conferencia;
							$json_outra = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia = ?::INTEGER;', [$id_conferencia]);
								
							foreach($json_outra as $key_outra => $value_outra){
								if($value_db->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia || $value_outra->tx_nome_conferencia != $tx_nome_conferencia){
									$params['id_conferencia'] = $value_db->id_conferencia;
									
									if($value_db->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia){
										$params['ft_forma_participacao_conferencia'] = $this->ft_representante;
									}else{
										$params['ft_forma_participacao_conferencia'] = $value_db->ft_forma_participacao_conferencia;
									}
									
									array_push($array_update, $params);
								}
							}
							
							if($value_db->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia || $tx_nome_conferencia != null){
								$params['id_conferencia'] = $value_db->id_conferencia;
									
								if($value_db->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia){
									$params['ft_forma_participacao_conferencia'] = $this->ft_representante;
								}else{
									$params['ft_forma_participacao_conferencia'] = $value_db->ft_forma_participacao_conferencia;
								}
									
								array_push($array_update, $params);
							}
						}
					}
					
					if($flag_insert){
						array_push($array_insert, $params);
					}
					
					foreach ($array_delete as $key => $value) {
						if($value->cd_conferencia == $cd_conferencia && $value->dt_ano_realizacao == $dt_ano_realizacao){
							unset($array_delete[$key]);
						}
					}
				}
			}
		}
		
		$flag_operation_delete = false;
		foreach($array_delete as $key => $value){
			if($value->bo_oficial){
				$flag_operation_delete = true;
			}
			else{
				$flag_operation_delete = $this->deleteParticipacaoSocialConferencia($value);
			}
		}
		
		$flag_operation_update = true;
		foreach($array_update as $key => $value){
			$flag_operation_update = $this->updateParticipacaoSocialConferencia($value);
		}
		
		$flag_operation_insert = true;
		foreach($array_insert as $key => $value){
			$flag_operation_insert = $this->insertParticipacaoSocialConferencia($value);
		}
		
    	if($flag_operation_insert || $flag_operation_update || $flag_operation_delete){
    		/*
			if(!$flag_insert){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na inserção de algum nova conferência.';
			}
			if(!$flag_update){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na atualização de alguma conferência.';
			}
			if(!$flag_delete){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na exclusão de alguma conferência.';
			}
			*/
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
    	
    	$tx_nome_conferencia = $params['tx_nome_conferencia'];
    	$ft_nome_conferencia = $this->ft_representante;
		
    	$dt_ano_realizacao = $params['dt_ano_realizacao'];
    	$ft_ano_realizacao = $this->ft_representante;
		
    	$cd_forma_participacao_conferencia = $params['cd_forma_participacao_conferencia'];
    	$ft_forma_participacao_conferencia = $this->ft_representante;
		
    	$bo_oficial = false;
		
    	$params = [$cd_conferencia, $ft_conferencia, $id_osc, $dt_ano_realizacao, $ft_ano_realizacao, $cd_forma_participacao_conferencia, $ft_forma_participacao_conferencia, $bo_oficial];
    	$result = $this->dao->insertParticipacaoSocialConferencia($params);
    	
    	if($result){
    		$id_conferencia = $result->id_conferencia;
    		
    		if($tx_nome_conferencia != null){
    			$params = [$tx_nome_conferencia, $ft_nome_conferencia, $id_conferencia];
    			$this->dao->setParticipacaoSocialConferenciaOutra($params);
    		}
    	}
    }
	
    private function updateParticipacaoSocialConferencia($params)
    {
		$id_osc = $params['id_osc'];
    	$id_conferencia = $params['id_conferencia'];
    	$cd_conferencia = $params['cd_conferencia'];
    	$ft_conferencia = $params['ft_conferencia'];
    	$tx_nome_conferencia = $params['tx_nome_conferencia'];
    	$ft_nome_conferencia = $this->ft_representante;
    	$dt_ano_realizacao = $params['dt_ano_realizacao'];
    	$ft_ano_realizacao = $params['ft_ano_realizacao'];
    	$bo_oficial = $params['bo_oficial'];
    	
		$result = ['msg' => 'Participação social em conferência atualizada.'];
		
    	if($bo_oficial == false){
    		$cd_forma_participacao_conferencia = $params['cd_forma_participacao_conferencia'];
    		if($params['cd_forma_participacao_conferencia'] != $cd_forma_participacao_conferencia) $ft_forma_participacao_conferencia = $this->ft_representante;
    		else $ft_forma_participacao_conferencia = $params['ft_forma_participacao_conferencia'];
			
    		$params = [$id_osc, $id_conferencia, $cd_conferencia, $ft_conferencia, $dt_ano_realizacao, $ft_ano_realizacao, $cd_forma_participacao_conferencia, $ft_forma_participacao_conferencia];
    		$resultDao = $this->dao->updateParticipacaoSocialConferencia($params);
    		
    		$json_outra = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia = ?::INTEGER;', [$id_conferencia]);
    		
    		if(count($json_outra)>0){
    			if($tx_nome_conferencia != null){
    				foreach($json_outra as $key_outra => $value_outra){
    					if($id_conferencia == $value_outra->id_conferencia){
    						if($value_outra->tx_nome_conferencia != $tx_nome_conferencia){ 
    							$ft_nome_conferencia = $this->ft_representante;
    							
    							$params = [$tx_nome_conferencia, $ft_nome_conferencia, $id_conferencia];
    							$this->dao->updateParticipacaoSocialConferenciaOutra($params);
    						}
    					}
    				}
    			}else{
    				$this->deleteParticipacaoSocialConferenciaOutra($id_conferencia, $id_osc);
    			}
    		}else{
    			if($tx_nome_conferencia != null){
    				$params = [$tx_nome_conferencia, $ft_nome_conferencia, $id_conferencia];
    				$this->dao->setParticipacaoSocialConferenciaOutra($params);
    			}
    		}
   
    		$result = ['msg' => $resultDao->mensagem];
    	}else{
    		$result = ['msg' => 'Dado Oficial, não pode ser modificado.'];
    	}
    	
    	$this->configResponse($result);
    	return $this->response();
    }
	
    private function deleteParticipacaoSocialConferencia($params)
    {
		$id_osc = $params->id_osc;
		$id_conferencia = $params->id_conferencia;
		
		$json = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia = ?::INTEGER;', [$id_conferencia]);
		
		foreach($json as $key => $value){
			if($id_conferencia == $value->id_conferencia){
				$this->deleteParticipacaoSocialConferenciaOutra($id_conferencia, $id_osc);
			}
		}

    	$params = [$id_conferencia];
    	$resultDao = $this->dao->deleteParticipacaoSocialConferencia($params);

    	return $resultDao;
    }
    
    public function deleteParticipacaoSocialConferenciaOutra($id_conferencia, $id)
    {
    	$json_conferencia = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia WHERE id_conferencia = ?::int',[$id_conferencia]);
    	foreach($json_conferencia as $key_conferencia => $value){
    		$id_osc = $json_conferencia[$key_conferencia]->id_osc;
    		if($id_osc == $id){
    			$bo_oficial = $json_conferencia[$key_conferencia]->bo_oficial;
    			if(!$bo_oficial){
    				$params = [$id_conferencia];
    				$resultDao = $this->dao->deleteParticipacaoSocialConferenciaOutra($params);
    				$result = ['msg' => 'Participacao Social Conferencia Outra excluida'];
    			}else{
    				$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    			}
    		}else{
    			$result = ['msg' => 'Erro_osc'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
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
	
    public function setParticipacaoSocialOutra(Request $request, $id_osc)
    {	
    	$req = $request->outra;
    	
    	$query = "SELECT * FROM osc.tb_participacao_social_outra WHERE id_osc = ?::INTEGER;";
    	$db = DB::select($query, [$id_osc]);
    	
    	$array_insert = array();
    	$array_delete = $db;
    	
    	$result = ['msg' => 'Participação social outra da OSC atualizada.'];
    	if($req){
	    	foreach($req as $key_req => $value_req){
	    		$tx_nome_participacao_social_outra = null;
	    		if(isset($value_req['tx_nome_participacao_social_outra'])){
	    			$tx_nome_participacao_social_outra = $value_req['tx_nome_participacao_social_outra'];
	    		}
	    		
	    		$params = ["id_osc" => $id_osc, "tx_nome_participacao_social_outra" => $tx_nome_participacao_social_outra];
	    		
	    		$flag_insert = true;
	    		
	    		foreach ($db as $key_db => $value_db) {
	    			if($value_db->tx_nome_participacao_social_outra == $tx_nome_participacao_social_outra){
	    				$flag_insert = false;
	    			}
	    		}
	    		
	    		if($flag_insert){
	    			array_push($array_insert, $params);
	    		}
	    		
	    		foreach ($array_delete as $key => $value) {
	    			if($value->tx_nome_participacao_social_outra == $tx_nome_participacao_social_outra){
	    				unset($array_delete[$key]);
	    			}
	    		}
	    	}
    	}
    	
    	$flag_insert = true;
    	foreach($array_insert as $key => $value){
    		$flag_insert = $this->insertParticipacaoSocialOutra($value);
    	}
    	
    	$flag_delete = true;
    	foreach($array_delete as $key => $value){
    		$flag_delete = $this->deleteParticipacaoSocialOutra($value);
    	}
    	
    	if($flag_insert || $flag_update || $flag_delete){
    		/*
    		if(!$flag_insert){
    			$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na inserção de algum nova conferência.';
    		}
    		if(!$flag_update){
    			$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na atualização de alguma conferência.';
    		}
    		if(!$flag_delete){
    			$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na exclusão de alguma conferência.';
    		}
    		*/
    		$this->configResponse($result, 200);
    	}
    	else{
    		$result = ['msg' => 'Ocorreu um erro.'];
    		$this->configResponse($result, 400);
    	}
    	
    	return $this->response();
    }
	
    private function insertParticipacaoSocialOutra($params)
    {
    	$id_osc = $params['id_osc'];
    	$tx_nome_participacao_social_outra = $params['tx_nome_participacao_social_outra'];
    	$ft_participacao_social_outra = $this->ft_representante;
    	$bo_oficial = false;
		
    	$params = [$id_osc, $tx_nome_participacao_social_outra, $ft_participacao_social_outra, $bo_oficial];
    	$result = $this->dao->insertParticipacaoSocialOutra($params);
    	
    	return $result;
    }
	
    private function deleteParticipacaoSocialOutra($params)
    {
    	$id_participacao_social_outra = $params->id_participacao_social_outra;
		
    	$params = [$id_participacao_social_outra];
    	$result = $this->dao->deleteParticipacaoSocialOutra($params);
		
    	return $result;
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
	
    public function setConselhoFiscal(Request $request, $id_osc)
    {
		$conselho_fiscal_req = $request->conselho_fiscal;
		
		$query = "SELECT * FROM osc.tb_conselho_fiscal WHERE id_osc = ?::INTEGER;";
		$conselho_fiscal_db = DB::select($query, [$id_osc]);
		
		$array_insert = array();
		$array_update = array();
		$array_delete = $conselho_fiscal_db;
		
		if($conselho_fiscal_req){
			foreach($conselho_fiscal_req as $key_req => $value_req){
				$id_conselheiro = $value_req['id_conselheiro'];
				$tx_nome_conselheiro = $value_req['tx_nome_conselheiro'];
				
				$params = array();
				$params['id_osc'] = $id_osc;
				$params['tx_nome_conselheiro'] = $tx_nome_conselheiro;
				
				if($id_conselheiro){
					foreach ($conselho_fiscal_db as $key_db => $value_db) {
						if($value_db->id_conselheiro == $id_conselheiro){
							unset($array_delete[$key_db]);
							if($value_db->tx_nome_conselheiro != $tx_nome_conselheiro){
								$params['id_conselheiro'] = $id_conselheiro;
								$params['conselho_fiscal_db'] = $value_db;
								array_push($array_update, $params);
							}
						}
					}
				}
				else{
					array_push($array_insert, $params);
				}
			}
		}
		
		foreach($array_delete as $key => $value){
			$this->deleteConselhoFiscal($value);
		}
		
		foreach($array_update as $key => $value){
			$this->updateConselhoFiscal($value);
		}
		
		foreach($array_insert as $key => $value){
			$this->insertConselhoFiscal($value);
		}
		
		$result = ['msg' => 'Conselho fiscal atualizado.'];
		$this->configResponse($result, 200);
		
		return $this->response();
    }
	
    private function deleteConselhoFiscal($params)
    {
    	$id_conselho_fiscal = $params->id_conselheiro;
		
    	$params = [$id_conselho_fiscal];
    	$result = $this->dao->deleteConselhoFiscal($params);
		
    	return $result;
    }
	
    private function updateConselhoFiscal($params)
    {
    	$conselho_fiscal_db = $params['conselho_fiscal_db'];
		
    	$id_osc = $params['id_osc'];
    	$id_conselheiro = $params['id_conselheiro'];
    	$tx_nome_conselheiro = $params['tx_nome_conselheiro'];
    	$ft_nome_conselheiro = $conselho_fiscal_db->ft_nome_conselheiro;
		
    	if($conselho_fiscal_db->tx_nome_conselheiro != $tx_nome_conselheiro){
    		$ft_nome_conselheiro = $this->ft_representante;
    	}
		
    	$params = [$id_osc, $id_conselheiro, $tx_nome_conselheiro, $ft_nome_conselheiro];
    	$result = $this->dao->updateConselhoFiscal($params);
		
    	return $result;
    }
	
    private function insertConselhoFiscal($params)
    {
    	$id_osc = $params['id_osc'];
    	$nome = $params['tx_nome_conselheiro'];
    	$ft_nome = $this->ft_representante;
    	$bo_oficial = false;
		
    	$params = [$id_osc, $nome, $ft_nome, $bo_oficial];
    	$result = $this->dao->insertConselhoFiscal($params);
		
    	return $result;
    }
	
    public function setRelacoesTrabalhoGovernanca(Request $request, $id_osc)
    {
    	$this->setRelacoesTrabalho($request, $id_osc);
    	$this->setDirigente($request, $id_osc);
    	$this->setConselhoFiscal($request, $id_osc);
		
    	$result = ['msg' => 'Relações de trabalho e governança atualizado.'];
    	$this->configResponse($result, 200);
		
    	return $this->response();
    }
	
	public function setProjeto(Request $request)
    {
    	$id = $request->input('id_osc');
		
    	$flag_insert = false;
    	
		$tx_nome = null;
		if($request->input('tx_nome_projeto')){
			$tx_nome = $request->input('tx_nome_projeto');
			$flag_insert = true;
		}
    	$ft_nome = $this->ft_representante;
		
		$cd_status = null;
		if($request->input('cd_status_projeto')){
			$cd_status = $request->input('cd_status_projeto');
			$flag_insert = true;
		}
    	$ft_status = $this->ft_representante;
		
		$dt_data_inicio_projeto = null;
		if($request->input('dt_data_inicio_projeto')){
			$dt_data_inicio_projeto = $request->input('dt_data_inicio_projeto');
			$date = date_create($dt_data_inicio_projeto);
			$dt_data_inicio_projeto = date_format($date, "Y-m-d");
			$flag_insert = true;
		}
    	$ft_data_inicio = $this->ft_representante;
		
		$dt_data_fim_projeto = null;
		if($request->input('dt_data_fim_projeto')){
			$dt_data_fim_projeto = $request->input('dt_data_fim_projeto');
			$date = date_create($dt_data_fim_projeto);
			$dt_data_fim_projeto = date_format($date, "Y-m-d");
			$flag_insert = true;
		}
    	$ft_data_fim = $this->ft_representante;
		
		$nr_valor_total = null;
		if($request->input('nr_valor_total_projeto')){
			$nr_valor_total = $request->input('nr_valor_total_projeto');
			$nr_valor_total = $this->formatacaoUtil->converMoneyToDouble($nr_valor_total);
			$flag_insert = true;
		}
    	$ft_valor_total = $this->ft_representante;
		
		$tx_link = null;
		if($request->input('tx_link_projeto')){
			$tx_link = $request->input('tx_link_projeto');
			$flag_insert = true;
		}
    	$ft_link = $this->ft_representante;
		
		$cd_abrangencia = null;
		if($request->input('cd_abrangencia_projeto')){
			$cd_abrangencia = $request->input('cd_abrangencia_projeto');
			$flag_insert = true;
		}
    	$ft_abrangencia = $this->ft_representante;
		
		$tx_descricao = null;
		if($request->input('tx_descricao_projeto')){
			$tx_descricao = $request->input('tx_descricao_projeto');
			$flag_insert = true;
		}
    	$ft_descricao = $this->ft_representante;
		
		$nr_total_beneficiarios = null;
		if($request->input('nr_total_beneficiarios')){
			$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
			$flag_insert = true;
		}
    	$ft_total_beneficiarios = $this->ft_representante;
		
		$nr_valor_captado_projeto = null;
		if($request->input('nr_valor_captado_projeto')){
			$nr_valor_captado_projeto = $request->input('nr_valor_captado_projeto');
			$nr_valor_captado_projeto = $this->formatacaoUtil->converMoneyToDouble($nr_valor_captado_projeto);
			$flag_insert = true;
		}
    	$ft_valor_captado_projeto = $this->ft_representante;
		
		$cd_zona_atuacao_projeto = null;
		if($request->input('cd_zona_atuacao_projeto')){
			$cd_zona_atuacao_projeto = $request->input('cd_zona_atuacao_projeto');
			$flag_insert = true;
		}
    	$ft_zona_atuacao_projeto = $this->ft_representante;
		
		$tx_metodologia_monitoramento = null;
		if($request->input('tx_metodologia_monitoramento')){
			$tx_metodologia_monitoramento = $request->input('tx_metodologia_monitoramento');
			$flag_insert = true;
		}
    	$ft_metodologia_monitoramento = $this->ft_representante;
		
		$tx_identificador_projeto_externo = null;
		if($request->input('tx_identificador_projeto_externo')){
			$tx_identificador_projeto_externo = $request->input('tx_identificador_projeto_externo');
			$flag_insert = true;
		}
    	$ft_identificador_projeto_externo = $this->ft_representante;
		
		$bo_oficial = false;
		
		$params = [$id, $tx_nome, $ft_nome, $cd_status, $ft_status, $dt_data_inicio_projeto, $ft_data_inicio,
				$dt_data_fim_projeto, $ft_data_fim, $nr_valor_total, $ft_valor_total, $tx_link, $ft_link, $cd_abrangencia,
    			$ft_abrangencia, $tx_descricao, $ft_descricao, $nr_total_beneficiarios, $ft_total_beneficiarios,
    			$nr_valor_captado_projeto, $ft_valor_captado_projeto, $cd_zona_atuacao_projeto, $ft_zona_atuacao_projeto,
    			$tx_metodologia_monitoramento, $ft_metodologia_monitoramento, $tx_identificador_projeto_externo, $ft_identificador_projeto_externo, $bo_oficial];
		
		$publico_beneficiado = false;
		if($request->publico_beneficiado){
			$publico_beneficiado = true;
			$flag_insert = true;
		}
		
		$area_atuacao = false;
		//if($request->area_atuacao){
		//	$area_atuacao = true;
		//	$flag_insert = true;
		//}
		
		$area_atuacao_outra = false;
		//if($request->area_atuacao_outra){
		//	$area_atuacao_outra = true;
		//	$flag_insert = true;
		//}
		
		$localizacao = false;
		if($request->localizacao){
			$localizacao = true;
			$flag_insert = true;
		}
		
		$objetivo_meta = false;
		if($request->objetivo_meta){
			$objetivo_meta = true;
			$flag_insert = true;
		}
		
		$osc_parceira = false;
		//if($request->osc_parceira){
		//	$osc_parceira = true;
		//	$flag_insert = true;
		//}
		
		$financiador_projeto = false;
		if($request->financiador_projeto){
			$financiador_projeto = true;
			$flag_insert = true;
		}
		
		$fonte_recursos = false;
		if($request->fonte_recursos){
			$fonte_recursos = true;
			$flag_insert = true;
		}
		
		if($flag_insert){
			$result = $this->dao->setProjeto($params);
    		$id_projeto = $result->inserir_projeto;
    		
    		if($publico_beneficiado){
    			$this->setPublicoBeneficiado($request, $id_projeto);
    		}
    		
    		if($area_atuacao){
    			$this->setAreaAtuacaoProjeto($request, $id_projeto);
			}
			
	    	if($area_atuacao_outra){
	    		$this->setAreaAtuacaoOutraProjeto($request, $id_projeto);
			}
			
    		if($localizacao){
    			$this->setLocalizacaoProjeto($request, $id_projeto);
    		}
    		
    		if($objetivo_meta){
    			$this->setObjetivoProjeto($request, $id_projeto);
    		}
    		
	    	if($osc_parceira){
	    		$this->setParceiraProjeto($request, $id_projeto);
			}
			
			if($financiador_projeto){
				$this->setFinanciadorProjeto($request, $id_projeto);
			}
			
			if($fonte_recursos){
				$this->setFonteRecursosProjeto($request, $id_projeto);
			}
			
			$result = ['msg' => 'Projeto adicionado.'];
			$this->configResponse($result, 200);
		}
		else{
			$result = ['msg' => 'Não há dados há serem gravados.'];
			$this->configResponse($result, 400);
		}
		
    	return $this->response();
    }
	
	public function updateProjeto(Request $request, $id_osc)
    {
		$result = null;
		
    	$id_projeto = $request->input('id_projeto');
    	$json = DB::select('SELECT * FROM osc.tb_projeto WHERE id_projeto = ?::INTEGER', [$id_projeto]);
		
    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$tx_nome = null;
    			if($request->input('tx_nome_projeto')){
    				$tx_nome = $request->input('tx_nome_projeto');
    			}
    			if($value->tx_nome_projeto != $tx_nome) $ft_nome = $this->ft_representante;
    			else $ft_nome = $value->ft_nome_projeto;
				
    			$cd_status = null;
				if($request->input('cd_status_projeto')){
					$cd_status = $request->input('cd_status_projeto');
				}
    			if($value->cd_status_projeto != $cd_status) $ft_status = $this->ft_representante;
    			else $ft_status = $value->ft_status_projeto;
				
    			$dt_data_inicio_projeto = null;
    			if($request->input('dt_data_inicio_projeto')){
    				$dt_data_inicio_projeto = $request->input('dt_data_inicio_projeto');
    				$date = date_create($dt_data_inicio_projeto);
    				$dt_data_inicio_projeto = date_format($date, "Y-m-d");
    			}
    			if($value->dt_data_inicio_projeto != $dt_data_inicio_projeto) $ft_data_inicio = $this->ft_representante;
    			else $ft_data_inicio = $value->ft_data_inicio_projeto;
				
    			$dt_data_fim = null;
    			if($request->input('dt_data_fim_projeto')){
    				$dt_data_fim = $request->input('dt_data_fim_projeto');
    				$date = date_create($dt_data_fim);
    				$dt_data_fim = date_format($date, "Y-m-d");
    			}
    			if($value->dt_data_fim_projeto != $dt_data_fim) $ft_data_fim = $this->ft_representante;
    			else $ft_data_fim = $value->ft_data_fim_projeto;
				
    			$nr_valor_total = null;
    			if($request->input('nr_valor_total_projeto')){
					$nr_valor_total = $request->input('nr_valor_total_projeto');
					$nr_valor_total = $this->formatacaoUtil->converMoneyToDouble($nr_valor_total);
    			}
    			if($value->nr_valor_total_projeto != $nr_valor_total) $ft_valor_total = $this->ft_representante;
    			else $ft_valor_total = $value->ft_valor_total_projeto;
				
    			$tx_link = null;
    			if($request->input('tx_link_projeto')){
					$tx_link = $request->input('tx_link_projeto');
    			}
    			if($value->tx_link_projeto != $tx_link) $ft_link = $this->ft_representante;
    			else $ft_link = $value->ft_link_projeto;
				
    			$cd_abrangencia = null;
    			if($request->input('cd_abrangencia_projeto')){
					$cd_abrangencia = $request->input('cd_abrangencia_projeto');
    			}
    			if($value->cd_abrangencia_projeto != $cd_abrangencia) $ft_abrangencia = $this->ft_representante;
    			else $ft_abrangencia = $value->ft_abrangencia_projeto;
				
    			$tx_descricao = null;
    			if($request->input('tx_descricao_projeto')){
					$tx_descricao = $request->input('tx_descricao_projeto');
    			}
    			if($value->tx_descricao_projeto != $tx_descricao) $ft_descricao = $this->ft_representante;
    			else $ft_descricao = $value->ft_descricao_projeto;
				
    			$nr_total_beneficiarios = null;
    			if($request->input('nr_total_beneficiarios')){
					$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
    			}
    			if($value->nr_total_beneficiarios != $nr_total_beneficiarios) $ft_total_beneficiarios = $this->ft_representante;
    			else $ft_total_beneficiarios = $value->ft_total_beneficiarios;
				
    			$nr_valor_captado_projeto = null;
    			if($request->input('nr_valor_captado_projeto')){
					$nr_valor_captado_projeto = $request->input('nr_valor_captado_projeto');
					$nr_valor_captado_projeto = $this->formatacaoUtil->converMoneyToDouble($nr_valor_captado_projeto);
    			}
    			if($value->nr_valor_captado_projeto != $nr_valor_captado_projeto) $ft_valor_captado_projeto = $this->ft_representante;
    			else $ft_valor_captado_projeto = $value->ft_valor_captado_projeto;
				
    			$cd_zona_atuacao_projeto = null;
    			if($request->input('cd_zona_atuacao_projeto')){
					$cd_zona_atuacao_projeto = $request->input('cd_zona_atuacao_projeto');
    			}
    			if($value->cd_zona_atuacao_projeto != $cd_zona_atuacao_projeto) $ft_zona_atuacao_projeto = $this->ft_representante;
    			else $ft_zona_atuacao_projeto = $value->ft_zona_atuacao_projeto;
				
    			$tx_metodologia_monitoramento = null;
    			if($request->input('tx_metodologia_monitoramento')){
    				$tx_metodologia_monitoramento = $request->input('tx_metodologia_monitoramento');
    			}
				if($value->tx_metodologia_monitoramento != $tx_metodologia_monitoramento) $ft_metodologia_monitoramento = $this->ft_representante;
    			else $ft_metodologia_monitoramento = $value->ft_metodologia_monitoramento;
				
    			$tx_identificador_projeto_externo = null;
    			if($request->input('tx_identificador_projeto_externo')){
					$tx_identificador_projeto_externo = $request->input('tx_identificador_projeto_externo');
    			}
				if($value->tx_identificador_projeto_externo != $tx_identificador_projeto_externo) $ft_identificador_projeto_externo = $this->ft_representante;
    			else $ft_identificador_projeto_externo = $value->ft_identificador_projeto_externo;
				
    			if($request->publico_beneficiado) $this->updatePublicoBeneficiado($request, $id_projeto);
    			//if($request->area_atuacao) $this->updateAreaAtuacaoProjeto($request, $id_projeto);
    			//if($request->area_atuacao_outra) $this->updateAreaAtuacaoOutraProjeto($request, $id_projeto);
    			if($request->localizacao) $this->updateLocalizacaoProjeto($request, $id_projeto);
    			if($request->objetivo_meta) $this->updateObjetivoProjeto($request, $id_projeto);
    			//if($request->osc_parceira) $this->updateParceiraProjeto($request, $id_projeto);
				if($request->financiador_projeto) $this->updateFinanciadorProjeto($request, $id_projeto);
				if($request->fonte_recursos) $this->updateFonteRecursosProjeto($request, $id_projeto);
				
    			$params = [$id_osc, $id_projeto, $tx_nome, $ft_nome, $cd_status, $ft_status, $dt_data_inicio_projeto, $ft_data_inicio,
    					$dt_data_fim, $ft_data_fim, $nr_valor_total, $ft_valor_total, $tx_link, $ft_link, $cd_abrangencia,
    					$ft_abrangencia, $tx_descricao, $ft_descricao, $nr_total_beneficiarios, $ft_total_beneficiarios,
    					$nr_valor_captado_projeto, $ft_valor_captado_projeto, $cd_zona_atuacao_projeto, $ft_zona_atuacao_projeto,
    					$tx_metodologia_monitoramento, $ft_metodologia_monitoramento, $tx_identificador_projeto_externo, $ft_identificador_projeto_externo];
    			$resultDao = $this->dao->updateProjeto($params);
    			$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado.'];
    		}
    	}
		
    	$this->configResponse($result);
    	return $this->response();
    }
    
    public function deleteProjeto($id_projeto, $id)
    {
    	$json = DB::select('SELECT * FROM  osc.tb_projeto WHERE id_projeto = ?::int AND id_osc = ?::int',[$id_projeto, $id]);
 
    	if(count($json)>0){
	    	foreach($json as $key => $value){
	    		$bo_oficial = $json[$key]->bo_oficial;
	    		if(!$bo_oficial){
	    			$params = [$id_projeto];
			    	$resultDao = $this->dao->deleteProjeto($params);
			    	$result = ['msg' => 'Projeto excluído.'];
	    		}else{
	    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
	    		}
	    	}
    	}else{
    		$result = ['msg' => 'Erro'];
    	}
    	$this->configResponse($result);
    	return $this->response();
    }
	
    public function setPublicoBeneficiado(Request $request, $id_projeto)
    {
    	$result = null;
		
		$req = $request->input('publico_beneficiado');
		
		if($req){
			foreach($req as $key => $value){
		    	$nome_publico_beneficiado = null;
				if(isset($value['tx_nome_publico_beneficiado'])){
					$nome_publico_beneficiado = $value['tx_nome_publico_beneficiado'];
			    	$ft_publico_beneficiado = $this->ft_representante;
			    	$ft_publico_beneficiado_projeto = $this->ft_representante;
			    	$bo_oficial = false;
					
			    	$params = [$id_projeto, $nome_publico_beneficiado, $ft_publico_beneficiado, $ft_publico_beneficiado_projeto, $bo_oficial];
			    	$result = $this->dao->setPublicoBeneficiado($params);
				}
			}
		}
		
    	$this->configResponse($result);
    	return $this->response();
    }
	
    public function updatePublicoBeneficiado(Request $request, $id_projeto)
    {
    	$this->deletePublicoBeneficiado($id_projeto);
    	$result = $this->setPublicoBeneficiado($request, $id_projeto);
		
    	return $result;
    }
	
    private function deletePublicoBeneficiado($id_projeto)
    {
    	$params = [$id_projeto];
    	$resultDao = $this->dao->deletePublicoBeneficiado($params);
    	$result = ['msg' => 'Público beneficiado de projeto excluído.'];
		
    	$this->configResponse($result);
    	return $this->response();
    }
	
    public function setAreaAtuacaoProjeto(Request $request, $id_projeto)
    {
    	$req = $request->area_atuacao;
    	
    	if($req){
	    	foreach ($req as $key => $value){
	    		$cd_subarea_atuacao = $value['cd_area_atuacao_projeto'];
	    		$ft_area_atuacao_projeto = $this->ft_representante;
	    		$bo_oficial = false;
				
	    		$params = [$id_projeto, $cd_subarea_atuacao, $ft_area_atuacao_projeto, $bo_oficial];
	    		$this->dao->setAreaAtuacaoProjeto($params);
	    	}
    	}
    }
	
    public function updateAreaAtuacaoProjeto(Request $request, $id_projeto)
    {
    	$req = $request->area_atuacao;
		
    	$query = 'SELECT * FROM osc.tb_area_atuacao_projeto WHERE id_projeto = ?::INTEGER;';
    	$db = DB::select($query, [$id_projeto]);
		
    	$array_insert = array();
    	$array_delete = $db;
		
    	if($req){
	    	foreach($req as $key_req => $value_req){
	    		$cd_area_atuacao_projeto = $value_req['cd_area_atuacao_projeto'];
				
	    		$params = [$id_projeto, $cd_area_atuacao_projeto, $this->ft_representante, false];
				
	    		$flag_insert = true;
	    		foreach ($db as $key_db => $value_db) {
	    			if($value_db->cd_subarea_atuacao == $cd_area_atuacao_projeto){
	    				$flag_insert = false;
	    			}
	    		}
				
	    		if($flag_insert){
	    			array_push($array_insert, $params);
	    		}
				
	    		foreach ($array_delete as $key_del => $value_del) {
	    			if($value_del->cd_subarea_atuacao == $cd_area_atuacao_projeto){
	    				unset($array_delete[$key_del]);
	    			}
	    		}
	    	}
    	}
		
    	foreach($array_insert as $key => $value){
    		$this->dao->setAreaAtuacaoProjeto($value);
    	}
		
    	$flag_error_delete = false;
    	foreach($array_delete as $key => $value){
    		if($value->bo_oficial){
    			$flag_error_delete = true;
    		}
    		else{
    			$this->deleteAreaAtuacaoProjeto($value->id_area_atuacao_projeto);
    		}
    	}
		
    	if($flag_error_delete){
    		$result = ['msg' => 'Área de atuação de projeto atualizada.'];
    		$this->configResponse($result, 200);
    	}
    	else{
    		$result = ['msg' => 'Área de atuação de projeto atualizada.'];
    		$this->configResponse($result, 200);
    	}
		
    	return $this->response();
    }
	
    private function deleteAreaAtuacaoProjeto($id_area_atuacao)
    {
    	$params = [$id_area_atuacao];
    	$resultDao = $this->dao->deleteAreaAtuacaoProjeto($params);
    	$result = ['msg' => 'Área de atuação de projeto excluída.'];
		
    	$this->configResponse($result);
    	return $this->response();
    }
	
    public function setAreaAtuacaoOutraProjeto(Request $request, $id_projeto)
    {
    	$id_osc = $request->input('id_osc');
		
    	$req = $request->area_atuacao_outra;
    	if($req){
	    	foreach ($req as $key => $value){
				$tx_nome_area_atuacao_outra_projeto = null;
		    	if($value['tx_nome_area_atuacao_outra_projeto']) $tx_nome_area_atuacao_outra_projeto = $value['tx_nome_area_atuacao_outra_projeto'];
		    	$ft_nome_area_atuacao_declarada = $this->ft_representante;
				
		    	$ft_area_atuacao_outra_projeto = $this->ft_representante;
		    	$ft_area_atuacao_outra = $this->ft_representante;
				
		    	$params = [$id_osc, $id_projeto, $tx_nome_area_atuacao_outra_projeto, $ft_nome_area_atuacao_declarada, $ft_area_atuacao_outra_projeto, $ft_area_atuacao_outra];
		    	$this->dao->setAreaAtuacaoOutraProjeto($params);
	    	}
    	}
    }
	
    public function updateAreaAtuacaoOutraProjeto(Request $request, $id_projeto)
    {
    	$this->deleteAreaAtuacaoOutraProjeto($id_projeto);
    	$result = $this->setAreaAtuacaoOutraProjeto($request, $id_projeto);
		
    	return $result;
    }
	
    private function deleteAreaAtuacaoOutraProjeto($id_projeto)
    {
    	$params = [$id_projeto];
    	$resultDao = $this->dao->deleteAreaAtuacaoOutraProjeto($params);
    	$result = ['msg' => 'Outra área de atuação de projeto excluída.'];
		
    	$this->configResponse($result);
    	return $this->response();
    }
	
    public function setLocalizacaoProjeto(Request $request, $id_projeto)
    {
		$req = $request->input('localizacao');
		
		if($req){
			foreach($req as $key => $value){
		    	$id_regiao_localizacao_projeto = -1;
				if(isset($value['id_regiao_localizacao_projeto'])) $id_regiao_localizacao_projeto = $value['id_regiao_localizacao_projeto'];
		    	$ft_regiao_localizacao_projeto = $this->ft_representante;
				
		    	$tx_nome_regiao_localizacao_projeto = null;
				if(isset($value['tx_nome_regiao_localizacao_projeto'])) $tx_nome_regiao_localizacao_projeto = $value['tx_nome_regiao_localizacao_projeto'];
		    	$ft_nome_regiao_localizacao_projeto = $this->ft_representante;
				
		    	$bo_oficial = false;
				
		    	$params = [$id_projeto, $id_regiao_localizacao_projeto, $ft_regiao_localizacao_projeto, $tx_nome_regiao_localizacao_projeto, $ft_nome_regiao_localizacao_projeto, $bo_oficial];
		    	$result = $this->dao->setLocalizacaoProjeto($params);
			}
		}
    }
	
    public function updateLocalizacaoProjeto(Request $request, $id_projeto)
    {
    	$req = $request->localizacao;
		
    	$query = 'SELECT * FROM osc.tb_localizacao_projeto WHERE id_projeto = ?::INTEGER;';
    	$db = DB::select($query, [$id_projeto]);
		
    	$array_insert = array();
    	$array_delete = $db;
		
    	if($req){
	    	foreach($req as $key_req => $value_req){
	    		$tx_nome_regiao_localizacao_projeto = null;
				
	    		if($value_req['tx_nome_regiao_localizacao_projeto']){
		    		$id_regiao_localizacao_projeto = -1;
		    		if(isset($value_req['id_regiao_localizacao_projeto'])) $id_regiao_localizacao_projeto = $value_req['id_regiao_localizacao_projeto'];
		    		$ft_regiao_localizacao_projeto = $this->ft_representante;
					
		    		if(isset($value_req['tx_nome_regiao_localizacao_projeto'])) $tx_nome_regiao_localizacao_projeto = $value_req['tx_nome_regiao_localizacao_projeto'];
		    		$ft_nome_regiao_localizacao_projeto = $this->ft_representante;
					
		    		$bo_oficial = false;
					
		    		$params = [$id_projeto, $id_regiao_localizacao_projeto, $ft_regiao_localizacao_projeto, $tx_nome_regiao_localizacao_projeto, $ft_nome_regiao_localizacao_projeto, $bo_oficial];
					
		    		$flag_insert = true;
		    		foreach ($db as $key_db => $value_db) {
		    			if($value_db->tx_nome_regiao_localizacao_projeto == $tx_nome_regiao_localizacao_projeto){
		    				$flag_insert = false;
		    			}
		    		}
					
		    		if($flag_insert){
		    			array_push($array_insert, $params);
		    		}
	    		}
				
	    		foreach ($array_delete as $key_del => $value_del) {
	    			if($value_del->tx_nome_regiao_localizacao_projeto == $tx_nome_regiao_localizacao_projeto){
	    				unset($array_delete[$key_del]);
	    			}
	    		}
	    	}
    	}
		
    	foreach($array_insert as $key => $value){
    		$this->dao->setLocalizacaoProjeto($value);
    	}
		
    	$flag_error_delete = false;
    	foreach($array_delete as $key => $value){
    		if($value->bo_oficial){
    			$flag_error_delete = true;
    		}
    		else{
    			$this->deleteLocalizacaoProjeto($value->id_localizacao_projeto);
    		}
    	}
		
    	if($flag_error_delete){
    		$result = ['msg' => 'Localização do projeto atualizado.'];
    		$this->configResponse($result, 200);
    	}
    	else{
    		$result = ['msg' => 'Localização do projeto atualizado.'];
    		$this->configResponse($result, 200);
    	}
		
    	return $this->response();
    }
	
    private function deleteLocalizacaoProjeto($id_localizacao)
    {
    	$params = [$id_localizacao];
    	$resultDao = $this->dao->deleteLocalizacaoProjeto($params);
    	$result = ['msg' => 'Localização do projeto excluído.'];
		
    	$this->configResponse($result);
    	return $this->response();
    }
	
    public function setObjetivoProjeto(Request $request, $id_projeto)
    {
		$req = $request->objetivo_meta;
		
		if($req){
			foreach ($req as $key => $value){
				if(isset($value['cd_meta_projeto'])){
					$cd_meta_projeto = $value['cd_meta_projeto'];
			    	$ft_objetivo_projeto = $this->ft_representante;
			    	$bo_oficial = false;
					
					if($cd_meta_projeto){
			    		$params = [$id_projeto, $cd_meta_projeto, $ft_objetivo_projeto, $bo_oficial];
			    		$result = $this->dao->setObjetivoProjeto($params);
					}
				}
			}
		}
    }
	
    public function updateObjetivoProjeto(Request $request, $id_projeto)
    {
    	$req = $request->objetivo_meta;
		
    	$query = 'SELECT * 
    				FROM osc.tb_objetivo_projeto 
    				INNER JOIN syst.dc_meta_projeto 
    				ON tb_objetivo_projeto.cd_meta_projeto = dc_meta_projeto.cd_meta_projeto 
    				WHERE tb_objetivo_projeto.id_projeto = ?::INTEGER;';
    	$db = DB::select($query, [$id_projeto]);
		
    	$array_insert = array();
    	$array_delete = $db;
		
    	if($req){
	    	foreach($req as $key_req => $value_req){
	    		if(isset($value_req['cd_meta_projeto'])){
	    			$cd_meta_projeto = $value_req['cd_meta_projeto'];
	    			
	    			$params = [$id_projeto, $cd_meta_projeto, $this->ft_representante, false];
	    			
	    			$flag_insert = true;
	    			foreach ($db as $key_db => $value_db) {
	    				if($value_db->tx_codigo_meta_projeto == $cd_meta_projeto){
	    					$flag_insert = false;
	    				}
	    			}
	    			
	    			if($flag_insert){
	    				array_push($array_insert, $params);
	    			}
	    			
	    			foreach ($array_delete as $key_del => $value_del) {
	    				if($value_del->tx_codigo_meta_projeto == $cd_meta_projeto){
	    					unset($array_delete[$key_del]);
	    				}
	    			}
	    		}
	    		else if(isset($value_req)){
		    		$cd_meta_projeto = $value_req;
					
		    		$params = [$id_projeto, $cd_meta_projeto, $this->ft_representante, false];
		    		
		    		$flag_insert = true;
		    		foreach ($db as $key_db => $value_db) {
		    			if($value_db->tx_codigo_meta_projeto == $cd_meta_projeto){
		    				$flag_insert = false;
		    			}
		    		}
					
		    		if($flag_insert){
		    			array_push($array_insert, $params);
		    		}
					
		    		foreach ($array_delete as $key_del => $value_del) {
		    			if($value_del->tx_codigo_meta_projeto == $cd_meta_projeto){
		    				unset($array_delete[$key_del]);
		    			}
		    		}
	    		}
	    	}
    	}
    	
    	foreach($array_insert as $key => $value){
    		$this->dao->setObjetivoProjeto($value);
    	}
		
    	$flag_error_delete = false;
    	foreach($array_delete as $key => $value){
    		if($value->bo_oficial){
    			$flag_error_delete = true;
    		}
    		else{
    			$this->deleteObjetivoProjeto($value->id_objetivo_projeto);
    		}
    	}
		
    	if($flag_error_delete){
    		$result = ['msg' => 'Objetivos de projeto atualizado.'];
    		$this->configResponse($result, 200);
    	}
    	else{
    		$result = ['msg' => 'Objetivos de projeto atualizado.'];
    		$this->configResponse($result, 200);
    	}
		
    	return $this->response();
    }
	
    private function deleteObjetivoProjeto($id_objetivo)
    {
    	$params = [$id_objetivo];
    	$resultDao = $this->dao->deleteObjetivoProjeto($params);
    	$result = ['msg' => 'Objetivo do Projeto excluído.'];
		
    	$this->configResponse($result);
    	return $this->response();
    }
	
    public function setParceiraProjeto(Request $request, $id_projeto)
    {
    	$req = $request->osc_parceira;
		
    	foreach ($req as $key => $value){
		    $id_osc = $value['id_osc'];
		    $ft_osc_parceira_projeto = $this->ft_representante;
		    $bo_oficial = false;

		    $params = [$id_projeto, $id_osc, $ft_osc_parceira_projeto, $bo_oficial];
		    $result = $this->dao->setParceiraProjeto($params);
    	}
    }
	
    public function updateParceiraProjeto(Request $request, $id_projeto)
    {
    	$req = $request->osc_parceira;
		
    	$query = 'SELECT * FROM osc.tb_osc_parceira_projeto WHERE id_projeto = ?::INTEGER;';
    	$db = DB::select($query, [$id_projeto]);
		
    	$array_insert = array();
    	$array_delete = $db;
		
    	if($req){
	    	foreach($req as $key_req => $value_req){
	    		$id_osc = $value_req['id_osc'];
				
	    		$params = [$id_projeto, $id_osc, $this->ft_representante, false];
				
	    		$flag_insert = true;
	    		foreach ($db as $key_db => $value_db) {
	    			if($value_db->id_osc == $id_osc){
	    				$flag_insert = false;
	    			}
	    		}
				
	    		if($flag_insert){
	    			array_push($array_insert, $params);
	    		}
				
	    		foreach ($array_delete as $key_del => $value_del) {
	    			if($value_del->id_osc == $id_osc){
	    				unset($array_delete[$key_del]);
	    			}
	    		}
	    	}
    	}
		
    	foreach($array_insert as $key => $value){
    		$this->dao->setParceiraProjeto($value);
    	}
		
    	$flag_error_delete = false;
    	foreach($array_delete as $key => $value){
    		if($value->bo_oficial){
    			$flag_error_delete = true;
    		}
    		else{
    			$this->deleteParceiraProjeto($value->id_osc, $value->id_projeto);
    		}
    	}
		
    	if($flag_error_delete){
    		$result = ['msg' => 'OSC parceira de projeto atualizados.'];
    		$this->configResponse($result, 200);
    	}
    	else{
    		$result = ['msg' => 'OSC parceira de projeto atualizados.'];
    		$this->configResponse($result, 200);
    	}
		
    	return $this->response();
    }
	
    private function deleteParceiraProjeto($id_osc, $id_projeto)
    {
    	$params = [$id_osc, $id_projeto];
    	$resultDao = $this->dao->deleteParceiraProjeto($params);
    	$result = ['msg' => 'Parceria de projeto excluido.'];
		
    	$this->configResponse($result);
    	return $this->response();
    }
	
	public function setFinanciadorProjeto(Request $request, $id_projeto)
	{
		$req = $request->input('financiador_projeto');
		
		if($req){
			foreach($req as $key => $value){
				$tx_nome_financiador = null;
				if(isset($value['tx_nome_financiador'])) $tx_nome_financiador = $value['tx_nome_financiador'];
				$ft_nome_financiador = $this->ft_representante;
				
				$bo_oficial = false;
				
				$params = [$id_projeto, $tx_nome_financiador, $ft_nome_financiador, $bo_oficial];
				$result = $this->dao->insertFinanciadorProjeto($params);
			}
		}
	}
	
	public function updateFinanciadorProjeto(Request $request, $id_projeto)
	{
		$req = $request->financiador_projeto;
		
		$query = 'SELECT * FROM osc.tb_financiador_projeto WHERE id_projeto = ?::INTEGER;';
		$db = DB::select($query, [$id_projeto]);
		
		$array_insert = array();
		$array_delete = $db;
		
		if($req){
			foreach($req as $key_req => $value_req){
				$tx_nome_financiador = null;
				
				if($value_req['tx_nome_financiador']){
					if(isset($value_req['tx_nome_financiador'])) $tx_nome_financiador = $value_req['tx_nome_financiador'];
					$ft_nome_financiador = $this->ft_representante;
					
					$bo_oficial = false;
					
					$params = [$id_projeto, $tx_nome_financiador, $ft_nome_financiador, $bo_oficial];
					
					$flag_insert = true;
					foreach ($db as $key_db => $value_db) {
						if($value_db->tx_nome_financiador == $tx_nome_financiador){
							$flag_insert = false;
						}
					}
					
					if($flag_insert){
						array_push($array_insert, $params);
					}
				}
				
				foreach ($array_delete as $key_del => $value_del) {
					if($value_del->tx_nome_financiador == $tx_nome_financiador){
						unset($array_delete[$key_del]);
					}
				}
			}
		}
		
		foreach($array_insert as $key => $value){
			$this->dao->insertFinanciadorProjeto($value);
		}
		
		$flag_error_delete = false;
		foreach($array_delete as $key => $value){
			if($value->bo_oficial){
				$flag_error_delete = true;
			}
			else{
				$this->deleteFinanciadorProjeto($value->id_financiador_projeto);
			}
		}
		
		if($flag_error_delete){
			$result = ['msg' => 'Financiador do projeto atualizado.'];
			$this->configResponse($result, 200);
		}
		else{
			$result = ['msg' => 'Financiador do projeto atualizado.'];
			$this->configResponse($result, 200);
		}
		
		return $this->response();
	}
	
	private function deleteFinanciadorProjeto($id_localizacao)
	{
		$params = [$id_localizacao];
		$resultDao = $this->dao->deleteLocalizacaoProjeto($params);
		$result = ['msg' => 'Financiador do projeto excluído.'];
		
		$this->configResponse($result);
		return $this->response();
	}
	
    public function setFonteRecursosProjeto(Request $request, $id_projeto)
    {
    	$req = $request->fonte_recursos;
    	
    	if($req){
	    	foreach ($req as $key => $value){
	    		$cd_origem_fonte_recursos_projeto = $value['cd_origem_fonte_recursos_projeto'];
	    		$ft_fonte_recursos_projeto = $this->ft_representante;
	    		$bo_oficial = false;
				
	    		$params = [$id_projeto, $cd_origem_fonte_recursos_projeto, $ft_fonte_recursos_projeto, $bo_oficial];
	    		$this->dao->insertFonteRecursosProjeto($params);
	    	}
    	}
    }
	
    public function updateFonteRecursosProjeto(Request $request, $id_projeto)
    {
    	$req = $request->fonte_recursos;
		
    	$query = 'SELECT * FROM osc.tb_fonte_recursos_projeto WHERE id_projeto = ?::INTEGER;';
    	$db = DB::select($query, [$id_projeto]);
		
    	$array_insert = array();
    	$array_delete = $db;
		
    	if($req){
	    	foreach($req as $key_req => $value_req){
	    		if($value_req['cd_origem_fonte_recursos_projeto']){
		    		$cd_fonte_recursos_projeto = $value_req['cd_origem_fonte_recursos_projeto'];
					
		    		$params = [$id_projeto, $cd_fonte_recursos_projeto, $this->ft_representante, false];
					
		    		$flag_insert = true;
		    		foreach ($db as $key_db => $value_db) {
		    			if($value_db->cd_origem_fonte_recursos_projeto == $cd_fonte_recursos_projeto){
		    				$flag_insert = false;
		    			}
		    		}
					
		    		if($flag_insert){
		    			array_push($array_insert, $params);
		    		}
					
		    		foreach ($array_delete as $key_del => $value_del) {
		    			if($value_del->cd_origem_fonte_recursos_projeto == $cd_fonte_recursos_projeto){
		    				unset($array_delete[$key_del]);
		    			}
		    		}
	    		}
	    	}
    	}
		
    	foreach($array_insert as $key => $value){
    		$this->dao->insertFonteRecursosProjeto($value);
    	}
		
    	$flag_error_delete = false;
    	foreach($array_delete as $key => $value){
    		if($value->bo_oficial){
    			$flag_error_delete = true;
    		}
    		else{
    			$this->deleteFonteRecursosProjeto($value->id_fonte_recursos_projeto);
    		}
    	}
		
    	if($flag_error_delete){
    		$result = ['msg' => 'Fonte de recursos de projeto atualizada.'];
    		$this->configResponse($result, 200);
    	}
    	else{
    		$result = ['msg' => 'Fonte de recursos de projeto atualizada.'];
    		$this->configResponse($result, 200);
    	}
		
    	return $this->response();
    }
	
    private function deleteFonteRecursosProjeto($id)
    {
    	$params = [$id];
    	$resultDao = $this->dao->deleteAreaAtuacaoProjeto($params);
    	$result = ['msg' => 'Fonte de recursos de projeto excluída.'];
		
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
			$result = ['msg' => 'Recursos da OSC atualizado.'];
			/*
			if(!$flag_insert){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na inserção de algum novo recurso.';
			}
			if(!$flag_update){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na atualização de algum recurso.';
			}
			if(!$flag_delete){
				$result['msg'] = $result['msg'] . ' Mas ocorreu um erro na exclusão de algum recurso.';
			}
			*/
    		$this->configResponse($result, 200);
    	}
		else{
			$result = ['msg' => 'Ocorreu um erro'];
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
    		$result = ['msg' => 'Recursos outros da OSC atualizado.'];
    		$this->configResponse($result, 200);
    	}else{
    		$result = ['msg' => 'Ocorreu um erro'];
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
