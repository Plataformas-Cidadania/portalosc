<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Util\FormatacaoUtil;
use App\Dao\OscDao;
use App\Dao\LogDao;
use App\Services\Osc\ObterBarraTransparenciaService;
use App\Services\Osc\ObterListaOscsAtualizadasService;
use App\Services\Osc\ObterListaOscsAreaAtuacaoService;
use App\Services\Osc\ObterDataAtualizacaoService;
use App\Services\Osc\Certificado\EditarCertificadoOscService;
use App\Services\Osc\FonteRecursos\EditarFonteRecursosOscService;

use App\Services\Osc\EditarDadosGerais\Service as EditarDadosGerais;

use App\Services\BaseService;
use App\Dto\RequisicaoDto;
use App\Dto\RespostaDto;

class OscController extends Controller
{
	private $dao;
    private $log;
	private $ft_representante;
	private $formatacaoUtil;
	private $logController;
	private $fontesEditaveis;
	
	public function __construct()
	{
		$this->dao = new OscDao();
		$this->ft_representante = 'Representante de OSC';
		$this->fontesEditaveis = ['Representante de OSC', 'Representante', null];
		$this->log = new LogDao();
		$this->formatacaoUtil = new FormatacaoUtil();
		$this->logController = new LogController();
		
		parent::__construct(new BaseService(), new RequisicaoDto(), new RespostaDto());
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
	
    public function editarDadosGerais(Request $request, $id_osc, EditarDadosGerais $service)
    {
    	$extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        
        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);
        
        return $response;
	}
	
	private function setObjetivoOsc(Request $request, $id_osc, $id_usuario)
	{
		$result = true;
		
		if(array_key_exists('objetivo_metas', $request->all())){
			$dict_db = array();
			$db = DB::select('SELECT cd_meta_projeto, cd_objetivo_projeto FROM syst.dc_meta_projeto');
			foreach($db as $value){
				$dict_db[$value->cd_meta_projeto] = $value->cd_objetivo_projeto;
			}
			
			$objetivos_db = array();
			$db = DB::select('SELECT cd_meta_osc FROM osc.tb_objetivo_osc WHERE id_osc = ?::INTEGER', [$id_osc]);
			$objetivos_db = array_map(function($o) { return $o->cd_meta_osc; }, $db);
			
			$objetivos_req = array();
			$metas_req = array();
			foreach($request->objetivo_metas as $value){
				if(array_key_exists('cd_meta_osc', $value)){
					array_push($metas_req, $value['cd_meta_osc']);
					array_push($objetivos_req, $dict_db[$value['cd_meta_osc']]);
				}
			}
			
			$metas_insert = array_diff($metas_req, $objetivos_db);
			$metas_delete = array_diff($objetivos_db, $metas_req);
			
			$objetivos_req = array_unique($objetivos_req);
			
			if(count($objetivos_req) <= 3){
				foreach($metas_insert as $value){
					$params = [$id_osc, $value, 'Representante de OSC', false];
					$result = $this->dao->insertObjetivoOsc($params);
					
					$tx_dado_anterior = '"cd_meta_osc": "' . null . '",';
					$tx_dado_posterior = '"cd_meta_osc": "' . $value . '",';
					$this->logController->saveLog('osc.tb_objetivo_osc', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
				}
				
				foreach($metas_delete as $value){
					$params = [$id_osc, $value];
					$result = $this->dao->deleteObjetivoOsc($params);
					
					$tx_dado_anterior = '"cd_meta_osc": "' . $value . '",';
					$tx_dado_posterior = '"cd_meta_osc": "' . null . '",';
					$this->logController->saveLog('osc.tb_objetivo_osc', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
				}
			}else{
				$result = ['msg' => 'Ocorreu um erro ao gravar objetivos e metas da OSC. Não é permitido adicionar mais do que 3 opções.'];
				$this->configResponse($result, 400);
				$result = false;
			}
		}
		
		return $result;
	}
	
    private function setApelido(Request $request, $id_osc)
    {
        $id_usuario = $request->user()->id;
		
    	$osc_db = DB::select('SELECT * FROM osc.tb_osc WHERE id_osc = ?::INTEGER', [$id_osc]);
		
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
		$flag_insert = false;
		
    	foreach($osc_db as $key_db => $value_db){
			$tx_apelido_osc = $request->input('tx_apelido_osc');
			$ft_apelido_osc = $value_db->ft_apelido_osc;
			if($value_db->tx_apelido_osc != $tx_apelido_osc){
				$flag_insert = true;
				
				if($tx_apelido_osc == '') $tx_apelido_osc = null;
				$ft_apelido_osc = $this->ft_representante;
				
				$tx_dado_anterior = $tx_dado_anterior . '"tx_apelido_osc": "' . $value_db->tx_apelido_osc . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"tx_apelido_osc": "' . $tx_apelido_osc . '",';
			}
    	}
		
		if($flag_insert){
    		$params = [$id_osc, $tx_apelido_osc, $ft_apelido_osc];
    		$result = $this->dao->updateApelido($params);
    		
    		$this->logController->saveLog('osc.tb_osc', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
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
			}else{
				$this->insertContatos($request, $id_osc);
			}
		}
	}
	
    public function updateContatos(Request $request, $id_osc, $contatos_db)
    {
        $id_usuario = $request->user()->id;
		
        $tx_dado_anterior = '';
        $tx_dado_posterior = '';
		$flag_insert = false;
		
		foreach($contatos_db as $key_db => $value_db){
			$tx_telefone = $request->input('tx_telefone');
			$ft_telefone = $value_db->ft_telefone;
			if($value_db->tx_telefone != $tx_telefone){
				$flag_insert = true;
				
				if($tx_telefone == '') $tx_telefone = null;
				$ft_telefone = $this->ft_representante;
				
				$tx_dado_anterior = $tx_dado_anterior . '"tx_telefone": "' . $value_db->tx_telefone . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"tx_telefone": "' . $tx_telefone . '",';
			}
			
			$tx_email = $request->input('tx_email');
			$ft_email = $value_db->ft_email;
			if($value_db->tx_email != $tx_email){
				$flag_insert = true;
				
				if($tx_email == '') $tx_email = null;
				$ft_email = $this->ft_representante;
				
				$tx_dado_anterior = $tx_dado_anterior . '"tx_email": "' . $value_db->tx_email . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"tx_email": "' . $tx_email . '",';
			}
			
			$tx_site = $request->input('tx_site');
			$ft_site = $value_db->ft_site;
			if($value_db->tx_site != $tx_site){
				$flag_insert = true;
				
				if($tx_site == '') $tx_site = null;
				$ft_site = $this->ft_representante;
				
				$tx_dado_anterior = $tx_dado_anterior . '"tx_site": "' . $value_db->tx_site . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"tx_site": "' . $tx_site . '",';
			}
		}
		
		if($flag_insert){
			$params = [$id_osc, $tx_telefone, $ft_telefone, $tx_email, $ft_email, $tx_site, $ft_site];
			$result = $this->dao->updateContatos($params);
			
			$this->logController->saveLog('osc.tb_contato', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		}
    }
	
	private function insertContatos(Request $request, $id_osc)
	{
        $id_usuario = $request->user()->id;
		
        $tx_dado_anterior = '';
        $tx_dado_posterior = '';
        
		$tx_telefone = $request->input('tx_telefone');
		if($tx_telefone == '') $tx_telefone = null;
        $ft_telefone = $this->ft_representante;
        
        $tx_dado_anterior = $tx_dado_anterior . '"tx_telefone": "",';
        $tx_dado_posterior = $tx_dado_posterior . '"tx_telefone": "' . $tx_telefone . '",';
        
    	$tx_email = $request->input('tx_email');
		if($tx_email == '') $tx_email = null;
        $ft_email = $this->ft_representante;
        
        $tx_dado_anterior = $tx_dado_anterior . '"tx_email": "",';
        $tx_dado_posterior = $tx_dado_posterior . '"tx_email": "' . $tx_email . '",';
        
    	$tx_site = $request->input('tx_site');
		if($tx_site == '') $tx_site = null;
        $ft_site = $this->ft_representante;
        
        $tx_dado_anterior = $tx_dado_anterior . '"tx_site": "",';
        $tx_dado_posterior = $tx_dado_posterior . '"tx_site": "' . $tx_site . '",';
		
		$params = [$id_osc, $tx_telefone, $ft_telefone, $tx_email, $ft_email, $tx_site, $ft_site];
		$result = $this->dao->insertContatos($params);
		
		$this->logController->saveLog('osc.tb_contato', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
	}
	
    public function setAreaAtuacao(Request $request, $id_osc)
    {
		$query = "SELECT * FROM osc.tb_area_atuacao WHERE id_osc = ?::INTEGER;";
		$area_atuacao_db = DB::select($query, [$id_osc]);
		
		$id_usuario = $request->user()->id;
		
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
						
						$params = ["id_usuario" => $id_usuario, "cd_area_atuacao" => $cd_area_atuacao, "cd_subarea_atuacao" => $cd_subarea_atuacao, "tx_nome_outra" => $tx_nome_outra];
						
						$flag_insert = true;
						$flag_update = false;
						foreach ($area_atuacao_db as $key_area_db => $value_area_db) {
							if($value_area_db->cd_area_atuacao == $cd_area_atuacao){
								if($value_area_db->cd_subarea_atuacao == $cd_subarea_atuacao){
									$flag_insert = false;
									if($value_area_db->tx_nome_outra != $tx_nome_outra && in_array($params['cd_subarea_atuacao'], $array_cd_subarea_atuacao_outra)){
										$flag_update = true;
										
										$params['id_area_atuacao'] = $value_area_db->id_area_atuacao;									
									}
									
									if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
								}
							}
						}
						
						if($flag_insert){
							if(!in_array($params, $array_insert)){
								array_push($array_insert, $params);
							}
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
				}else{
					$tx_nome_outra = $value_area_req['tx_nome_area_atuacao_outra'];
					
					$params = ["id_usuario" => $id_usuario, "cd_area_atuacao" => $cd_area_atuacao, "cd_subarea_atuacao" => null, "tx_nome_outra" => $tx_nome_outra];
					
					$flag_insert = true;
					$flag_update = false;
					foreach ($area_atuacao_db as $key_area_db => $value_area_db) {
						if($value_area_db->cd_area_atuacao == $cd_area_atuacao && $value_area_db->cd_subarea_atuacao == null && $value_area_db->tx_nome_outra == $tx_nome_outra){
							$flag_insert = false;
							if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
							
							$params['id_area_atuacao'] = $value_area_db->id_area_atuacao;
						}
					}
					
					if($flag_insert){
						if(count($array_insert) >= 2){
							unset($array_insert[0]);
						}
						array_push($array_insert, $params);
						if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
					}
					
					if($flag_update){
						array_push($array_update, $params);
						if(!in_array($cd_area_atuacao, $array_macro)) array_push($array_macro, $cd_area_atuacao);
					}
					
					foreach ($array_delete as $key_area_del => $value_area_del) {
						if($value_area_del->cd_area_atuacao == $cd_area_atuacao && $value_area_del->cd_subarea_atuacao == $cd_subarea_atuacao && $value_area_del->tx_nome_outra == $tx_nome_outra){
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
				$this->deleteAreaAtuacao($value, $id_osc, $id_usuario);
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
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$id_usuario = $params['id_usuario'];
    	
    	$id_area_atuacao = $params['id_area_atuacao'];
    	$cd_area_atuacao = $params['cd_area_atuacao'];
    	$cd_subarea_atuacao = $params['cd_subarea_atuacao'];
		$tx_nome_outra = $params['tx_nome_outra'];
    	$bo_oficial = false;
    	
    	$json = DB::select('SELECT * FROM osc.tb_area_atuacao WHERE id_osc = ?::INTEGER', [$id_osc]);
    	
    	foreach($json as $key => $value){
    		$tx_dado_anterior = $tx_dado_anterior . '"cd_area_atuacao": "' . $value->cd_area_atuacao . '",';
	    	$tx_dado_posterior = $tx_dado_posterior . '"cd_area_atuacao": "' . $cd_area_atuacao . '",';
	    		
	    	$tx_dado_anterior = $tx_dado_anterior . '"cd_subarea_atuacao": "' . $value->cd_subarea_atuacao . '",';
	    	$tx_dado_posterior = $tx_dado_posterior . '"cd_subarea_atuacao": "' . $cd_subarea_atuacao . '",';
	    		
	    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_outra": "' . $value->tx_nome_outra . '",';
	    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_outra": "' . $tx_nome_outra . '",';
    	}
		
    	$params = [$id_osc, $cd_area_atuacao, $cd_subarea_atuacao, $tx_nome_outra, $this->ft_representante, $bo_oficial];
    	$result = $this->dao->updateAreaAtuacao($params);
    	
    	$this->logController->saveLog('osc.tb_area_atuacao', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
    	return $result;
    }
    
    private function insertAreaAtuacao($params, $id_osc)
    {
    	$id_usuario = $params['id_usuario'];
    	
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$cd_area_atuacao = $params['cd_area_atuacao'];
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"cd_area_atuacao": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_area_atuacao": "' . $cd_area_atuacao . '",';
    	
    	$cd_subarea_atuacao = $params['cd_subarea_atuacao'];
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"cd_subarea_atuacao": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_subarea_atuacao": "' . $cd_subarea_atuacao . '",';
    	
		$tx_nome_outra = $params['tx_nome_outra'];
		
		$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_outra": "",';
		$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_outra": "' . $tx_nome_outra . '",';
		
    	$bo_oficial = false;
		
    	$params = [$id_osc, $cd_area_atuacao, $cd_subarea_atuacao, $tx_nome_outra, $this->ft_representante, $bo_oficial];
    	$result = $this->dao->insertAreaAtuacao($params);
    	
    	$this->logController->saveLog('osc.tb_area_atuacao', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
    	return $result;
    }
    
    private function deleteAreaAtuacao($params, $id_osc, $id_usuario)
    {    	 
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$id_area_atuacao = $params->id_area_atuacao;
    	
    	$cd_area_atuacao = $params->cd_area_atuacao;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"cd_area_atuacao": "' . $cd_area_atuacao . '",';
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_area_atuacao": "",';
    	
    	$cd_subarea_atuacao = $params->cd_subarea_atuacao;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"cd_subarea_atuacao": "' . $cd_subarea_atuacao . '",';
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_subarea_atuacao": "",';
    	
    	$tx_nome_outra = $params->tx_nome_outra;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_outra": "' . $tx_nome_outra . '",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_outra": "",';
		
    	$params = [$id_osc, $cd_area_atuacao, $cd_subarea_atuacao];
    	$result = $this->dao->deleteAreaAtuacao($params);
    	
    	$this->logController->saveLog('osc.tb_area_atuacao', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
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
		
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
		$flag_insert = false;
		
    	foreach($descricao_db as $key_db => $value_db){
			$tx_historico = $tx_historico = $request->input('tx_historico');
			$ft_historico = $value_db->ft_historico;
			if($value_db->tx_historico != $tx_historico){
				$flag_insert = true;
				$ft_historico = $this->ft_representante;
				
				$tx_dado_anterior = $tx_dado_anterior . '"tx_historico": "' . $value_db->tx_historico . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"tx_historico": "' . $tx_historico . '",';
			}
			
			$tx_missao_osc = $request->input('tx_missao_osc');
			$ft_missao_osc = $value_db->ft_missao_osc;
			if($value_db->tx_missao_osc != $tx_missao_osc){
				$flag_insert = true;
				$ft_missao_osc = $this->ft_representante;
				
				$tx_dado_anterior = $tx_dado_anterior . '"tx_missao_osc": "' . $value_db->tx_missao_osc . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"tx_missao_osc": "' . $tx_missao_osc . '",';
			}
			
			$tx_visao_osc = $request->input('tx_visao_osc');
			$ft_visao_osc = $value_db->ft_visao_osc;
			if($value_db->tx_visao_osc != $tx_visao_osc){
				$flag_insert = true;
				$ft_visao_osc = $this->ft_representante;
				
				$tx_dado_anterior = $tx_dado_anterior . '"tx_visao_osc": "' . $value_db->tx_visao_osc . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"tx_visao_osc": "' . $tx_visao_osc . '",';
			}
			
			$tx_finalidades_estatutarias = $request->input('tx_finalidades_estatutarias');
			$ft_finalidades_estatutarias = $value_db->ft_finalidades_estatutarias;
			if($value_db->tx_finalidades_estatutarias != $tx_finalidades_estatutarias){
				$flag_insert = true;
				$ft_finalidades_estatutarias = $this->ft_representante;
				
				$tx_dado_anterior = $tx_dado_anterior . '"tx_finalidades_estatutarias": "' . $value_db->tx_finalidades_estatutarias . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"tx_finalidades_estatutarias": "' . $tx_finalidades_estatutarias . '",';
			}
			
			$bo_nao_possui_link_estatuto_osc = false;
			if($request->input('bo_nao_possui_link_estatuto_osc')){
				if($request->input('bo_nao_possui_link_estatuto_osc') === true){
					$bo_nao_possui_link_estatuto_osc = true;
				}
			}

			if($bo_nao_possui_link_estatuto_osc){
				$tx_link_estatuto_osc = null;
				$ft_link_estatuto_osc = $value_db->ft_link_estatuto_osc;
				if($value_db->bo_nao_possui_link_estatuto_osc != $bo_nao_possui_link_estatuto_osc){
					$flag_insert = true;
					$ft_link_estatuto_osc = $this->ft_representante;
					
					$tx_dado_anterior = $tx_dado_anterior . '"bo_nao_possui_link_estatuto_osc": "' . $value_db->bo_nao_possui_link_estatuto_osc . '",';
					$tx_dado_posterior = $tx_dado_posterior . '"bo_nao_possui_link_estatuto_osc": "' . $bo_nao_possui_link_estatuto_osc . '",';
				}
				if($value_db->tx_link_estatuto_osc != $tx_link_estatuto_osc){
					$flag_insert = true;
					$ft_link_estatuto_osc = $this->ft_representante;
					
					$tx_dado_anterior = $tx_dado_anterior . '"tx_link_estatuto_osc": "' . $value_db->tx_link_estatuto_osc . '",';
					$tx_dado_posterior = $tx_dado_posterior . '"tx_link_estatuto_osc": "' . $tx_link_estatuto_osc . '",';
				}
			}else{
				$tx_link_estatuto_osc = $request->input('tx_link_estatuto_osc');
				$ft_link_estatuto_osc = $value_db->ft_link_estatuto_osc;
				if($value_db->tx_link_estatuto_osc != $tx_link_estatuto_osc){
					$flag_insert = true;
					$ft_link_estatuto_osc = $this->ft_representante;
					
					$tx_dado_anterior = $tx_dado_anterior . '"tx_link_estatuto_osc": "' . $value_db->tx_link_estatuto_osc . '",';
					$tx_dado_posterior = $tx_dado_posterior . '"tx_link_estatuto_osc": "' . $tx_link_estatuto_osc . '",';
				}
			}
    	}
		
		if($flag_insert){			
    		$params = [$id_osc, $tx_historico, $ft_historico, $tx_missao_osc, $ft_missao_osc, $tx_visao_osc, $ft_visao_osc, $tx_finalidades_estatutarias, $ft_finalidades_estatutarias, $tx_link_estatuto_osc, $bo_nao_possui_link_estatuto_osc, $ft_link_estatuto_osc];
    		$resultDao = $this->dao->updateDescricao($params);
    		
    		$this->logController->saveLog('osc.tb_dados_gerais', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
	    	
    		$result = ['msg' => $resultDao->mensagem];
		}
		
    	$this->configResponse($result);
    	return $this->response();
    }
    
    public function editarCertificado(Request $request, EditarCertificadoOscService $service)
    {
    	$this->executarService($service, $request);
    	return $this->getResponse();
    }
    
	public function setDirigente(Request $request, $id_osc)
	{
		$dirigente_req = $request->governanca;
		
		$id_usuario = $request->user()->id;
		
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
				$params['id_usuario'] = $id_usuario;
				$params['id_osc'] = $id_osc;
				$params['tx_cargo_dirigente'] = $tx_cargo_dirigente;
				$params['tx_nome_dirigente'] = $tx_nome_dirigente;
				
				if($id_dirigente){
					foreach ($diregente_db as $key_db => $value_db) {
						if($value_db->id_dirigente == $id_dirigente){
							unset($array_delete[$key_db]);
							
							if($value_db->tx_cargo_dirigente != $tx_cargo_dirigente || $value_db->tx_nome_dirigente != $tx_nome_dirigente){
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
			$this->deleteDirigente($value, $id_usuario);
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
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$id_usuario = $params['id_usuario'];
    	
    	$id_osc = $params['id_osc'];
    	
    	$cargo = $params['tx_cargo_dirigente'];
    	$fonte_cargo = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_cargo_dirigente": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_cargo_dirigente": "' . $cargo . '",';
    	
    	$nome = $params['tx_nome_dirigente'];
    	$fonte_nome = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_dirigente": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_dirigente": "' . $nome . '",';
    	
    	$bo_oficial = false;
		
    	$params = [$id_osc, $cargo, $fonte_cargo, $nome, $fonte_nome, $bo_oficial];
    	$result = $this->dao->insertDirigente($params);
    	
    	$this->logController->saveLog('osc.tb_governanca', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
    	return $result;
    }
    
    private function updateDirigente($params)
    {
        $id_osc = $params['id_osc'];
        
    	$dirigente_db = $params['dirigente_db'];
    	
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
		
    	$id_usuario = $params['id_usuario'];
    	$id_osc = $params['id_osc'];
    	$id_dirigente = $params['id_dirigente'];
		
    	$cargo = $params['tx_cargo_dirigente'];
    	$fonte_cargo = $dirigente_db->ft_cargo_dirigente;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_cargo_dirigente": "' . $dirigente_db->tx_cargo_dirigente . '",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_cargo_dirigente": "' . $cargo . '",';
    	
    	$nome = $params['tx_nome_dirigente'];
    	$fonte_nome = $dirigente_db->ft_nome_dirigente;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_dirigente": "' . $dirigente_db->tx_nome_dirigente . '",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_dirigente": "' . $nome . '",';
		
		if($dirigente_db->tx_nome_dirigente != $nome){
			$fonte_nome = $this->ft_representante;
		}
		
		if($dirigente_db->tx_cargo_dirigente != $cargo){
			$fonte_nome = $this->ft_representante;
		}
		
    	$params = [$id_osc, $id_dirigente, $cargo, $fonte_cargo, $nome, $fonte_nome];
    	$result = $this->dao->updateDirigente($params);
    	
    	$this->logController->saveLog('osc.tb_governanca', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
    	return $result;
    }
    
    private function deleteDirigente($params, $id_usuario)
    {
        $id_osc = $params->id_osc;
        
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    		
    	$id_dirigente = $params->id_dirigente;
    	
    	$nome = $params->tx_nome_dirigente;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_dirigente": "' . $nome . '",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_dirigente": "",';
    	
    	$cargo = $params->tx_cargo_dirigente;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_cargo_dirigente": "' . $cargo . '",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_cargo_dirigente": "",';
    	
    	$params = [$id_dirigente];
    	$result = $this->dao->deleteDirigente($params);
		
    	$this->logController->saveLog('osc.tb_governanca', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    	
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
    	$id_usuario = $request->user()->id;
    	
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
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
		    		
		    		$tx_dado_anterior = $tx_dado_anterior . '"nr_trabalhadores_voluntarios": "' . $value_db->nr_trabalhadores_voluntarios . '",';
		    		$tx_dado_posterior = $tx_dado_posterior . '"nr_trabalhadores_voluntarios": "' . $nr_trabalhadores_voluntarios . '",';
		    	}
	    	}
    	}
    	else{
    		$params = ['id_usuario' => $id_usuario, 'id_osc' => $id_osc, 'nr_trabalhadores_voluntarios' => $nr_trabalhadores_voluntarios];
    		array_push($array_insert, $params);
    	}
		
    	foreach($array_insert as $key => $value){
			$this->insertRelacoesTrabalho($value);
		}
		
    	foreach($array_update as $key => $value){
			$this->updateRelacoesTrabalho($value);
			$this->logController->saveLog('osc.tb_relacoes_trabalho', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		}
		
    	$result = ['msg' => 'Relações de trabalho atualizada.'];
    	$this->configResponse($result, 200);
    	return $this->response();
    }
    
    private function insertRelacoesTrabalho($params)
    {
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	 
    	$id_usuario = $params['id_usuario'];
    	
		$id_osc = $params['id_osc'];
		
		$nr_trabalhadores_voluntarios = $params['nr_trabalhadores_voluntarios'];
    	$ft_trabalhadores_voluntarios = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"nr_trabalhadores_voluntarios": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"nr_trabalhadores_voluntarios": "' . $nr_trabalhadores_voluntarios . '",';
		
    	$params = [$id_osc, $nr_trabalhadores_voluntarios, $ft_trabalhadores_voluntarios];
    	$result = $this->dao->insertRelacoesTrabalho($params);
    	
    	$this->logController->saveLog('osc.tb_relacoes_trabalho', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
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
		$id_usuario = $request->user()->id;
		
		$req = $request->conselho;
		
		$query = "SELECT * FROM osc.tb_participacao_social_conselho WHERE id_osc = ?::INTEGER;";
		$conselho_db = DB::select($query, [$id_osc]);
		
		$array_insert = array();
		$array_update = array();
		$array_delete = $conselho_db;
		
		$array_insert_membro_conselho = array();
		$array_delete_membro_conselho = array();
		
		$nao_possui = $request->bo_nao_possui_conselhos;
		
		if(is_null($req) === true){
			if($nao_possui){
				$params = ["id_usuario" => $id_usuario, "cd_conselho" => 105, "tx_nome_conselho" => null, "cd_tipo_participacao" => null, "cd_periodicidade_reuniao_conselho" => null, "dt_data_inicio_conselho" => null, "dt_data_fim_conselho" => null, "representante" => $representante];
				array_push($array_insert, $params);
			}
		}else{
			if($req){
			    foreach($req as $key_req => $value_req){
			        $representante = array();
			        
					$conselho = $value_req['conselho'];
					
					$id_conselho = $conselho['id_conselho'];
					
					$cd_conselho = null;
					if($conselho['cd_conselho']){
						$cd_conselho = $conselho['cd_conselho'];
					}
					
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
					
					if(isset($value_req['representante'])){
						foreach ($value_req['representante'] as $key_representante => $value_representante) {
							array_push($representante, $value_representante['tx_nome_representante_conselho']);
						}
					}
					
					$params = ["id_conselho" => $id_conselho, "id_usuario" => $id_usuario, "cd_conselho" => $cd_conselho, "tx_nome_conselho" => $tx_nome_conselho, "cd_tipo_participacao" => $cd_tipo_participacao, "cd_periodicidade_reuniao_conselho" => $cd_periodicidade_reuniao_conselho, "dt_data_inicio_conselho" => $dt_data_inicio_conselho, "dt_data_fim_conselho" => $dt_data_fim_conselho, "representante" => $representante];
					
					$flag_insert = true;
					$flag_update = false;
					foreach ($conselho_db as $key_conselho_db => $value_conselho_db) {
						if($id_conselho){
							$flag_insert = false;
							
							$conselho_outro_db = DB::select('SELECT * FROM osc.tb_participacao_social_conselho_outro WHERE id_conselho = ?::INTEGER;', [$id_conselho]);
							foreach($conselho_outro_db as $key_conselho_outro_db => $value_conselho_outro_db){
								if($value_conselho_outro_db->tx_nome_conselho != $tx_nome_conselho){
									$flag_update = true;
								}
							}
							
							if($value_conselho_db->cd_conselho != $cd_conselho || $value_conselho_db->cd_tipo_participacao != $cd_tipo_participacao || $value_conselho_db->cd_periodicidade_reuniao_conselho != $cd_periodicidade_reuniao_conselho || $value_conselho_db->dt_data_inicio_conselho != $dt_data_inicio_conselho || $value_conselho_db->dt_data_fim_conselho != $dt_data_fim_conselho){
								$flag_update = true;
							}
						}
					}
					
					if($id_conselho){
						$query = "SELECT * FROM osc.tb_representante_conselho WHERE id_participacao_social_conselho = ?::INTEGER;";
						$reresentante_db = DB::select($query, [$id_conselho]);
						
						if($reresentante_db){
							foreach ($reresentante_db as $key_reresentante_db => $value_reresentante_db) {
								$flag_delete_representante = true;
								foreach ($representante as $key_representante => $value_representante) {
									if($value_reresentante_db->tx_nome_representante_conselho == $value_representante){
										$flag_delete_representante = false;
									}else{
										array_push($array_insert_membro_conselho, [$id_osc, $id_conselho, $value_representante]);
									}
								}
								
								if($flag_delete_representante){
									array_push($array_delete_membro_conselho, $value_reresentante_db->id_representante_conselho);
								}
							}
						}else{
							foreach ($representante as $key_representante => $value_representante) {
								array_push($array_insert_membro_conselho, [$id_osc, $id_conselho, $value_representante]);
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
						if($value_conselho_del->id_conselho == $id_conselho){
							unset($array_delete[$key_conselho_del]);
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
			    $this->deleteParticipacaoSocialConselho($value->id_conselho, $id_usuario, $id_osc);
			}
		}
		
		foreach($array_delete_membro_conselho as $key => $value){
			$result = $this->deleteMembroParticipacaoSocialConselho($value, $id_usuario);
		}
		
		foreach($array_insert_membro_conselho as $key => $value){
			$result = $this->insertMembroParticipacaoSocialConselho($value);
		}
		
		if($flag_error_delete){
			$result = ['msg' => 'Participação social em conselhos atualizada.'];
			$this->configResponse($result, 200);
		}else{
			$result = ['msg' => 'Participação social em conselhos atualizada.'];
			$this->configResponse($result, 200);
		}
		
		return $this->response();
	}
	
    private function insertParticipacaoSocialConselho($params, $id_osc)
    {
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$id_usuario = $params['id_usuario'];
    	
    	$cd_conselho = $params['cd_conselho'];
    	$ft_conselho = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"cd_conselho": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_conselho": "' . $cd_conselho . '",';
    	
    	$tx_nome_conselho = $params['tx_nome_conselho'];
		$ft_nome_conselho = $this->ft_representante;
    	
    	$cd_tipo_participacao = $params['cd_tipo_participacao'];
    	$ft_tipo_participacao = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"cd_tipo_participacao": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_tipo_participacao": "' . $cd_tipo_participacao . '",';
		
    	$cd_periodicidade_reuniao_conselho = $params['cd_periodicidade_reuniao_conselho'];
    	$ft_periodicidade_reuniao = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"cd_periodicidade_reuniao_conselho": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_periodicidade_reuniao_conselho": "' . $cd_periodicidade_reuniao_conselho . '",';
		
    	$dt_inicio_conselho = $params['dt_data_inicio_conselho'];
    	$ft_dt_inicio_conselho = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"dt_data_inicio_conselho": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"dt_data_inicio_conselho": "' . $dt_inicio_conselho . '",';
		
    	$dt_fim_conselho = $params['dt_data_fim_conselho'];
    	$ft_dt_fim_conselho = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"dt_data_fim_conselho": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"dt_data_fim_conselho": "' . $dt_fim_conselho . '",';
		
    	$bo_oficial = false;
    	
    	$representante = $params['representante'];
    	
    	$params = [$id_osc, $cd_conselho, $ft_conselho, $cd_tipo_participacao, $ft_tipo_participacao, $cd_periodicidade_reuniao_conselho, $ft_periodicidade_reuniao, $dt_inicio_conselho, $ft_dt_inicio_conselho, $dt_fim_conselho, $ft_dt_fim_conselho, $bo_oficial];
    	$result = $this->dao->insertParticipacaoSocialConselho($params);
    	
    	$this->logController->saveLog('osc.tb_participacao_social_conselho', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
		if($result){			
			$id_conselho = $result->id_conselho;
			foreach ($representante as $key_representante => $value_representante) {
				$tx_nome_representante_conselho = $value_representante;
				
				$tx_dado_anterior = '"tx_nome_representante_conselho": "",';
				$tx_dado_posterior = '"tx_nome_representante_conselho": "' . $tx_nome_representante_conselho . '",';
				
				$params = [$id_osc, $id_conselho, $tx_nome_representante_conselho];
				$result = $this->insertMembroParticipacaoSocialConselho($params);
				
				$this->logController->saveLog('osc.tb_representante_conselho', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
			}
			
			if($tx_nome_conselho != null){
				$tx_dado_anterior = '"tx_nome_conselho": "",';
				$tx_dado_posterior = '"tx_nome_conselho": "' . $tx_nome_conselho . '",';
				
				$params = [$tx_nome_conselho, $ft_nome_conselho, $id_conselho];
				$this->dao->setParticipacaoSocialConselhoOutro($params);
				
				$this->logController->saveLog('osc.tb_participacao_social_conselho_outro', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
			}
		}
    }
    
	private function insertMembroParticipacaoSocialConselho($params)
	{
		if($params[1] != null){
			$ft_nome_representante_conselho = $this->ft_representante;
			$bo_oficial = false;
			array_push($params, $ft_nome_representante_conselho, $bo_oficial);
			
			$result = $this->dao->insertMembroParticipacaoSocialConselho($params);
		}
	}
	
    private function updateParticipacaoSocialConselho($params, $id_osc)
    {
		$id_conselho = $params['id_conselho'];
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conselho WHERE id_osc = ?::INTEGER AND id_conselho = ?::INTEGER;', [$id_osc, $id_conselho]);
		
    	$id_usuario = $params['id_usuario'];
    	
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$flag_update = false;
    	
    	foreach($json as $key => $value){
    		$bo_oficial = $value->bo_oficial;
    		if(!$bo_oficial){
    			$id_conselho = $value->id_conselho;
    			
    			$cd_conselho = $params['cd_conselho'];
    			if($value->cd_conselho != $cd_conselho){
    				$ft_conselho = $this->ft_representante;
    				$flag_update = true;
    			}
    			else $ft_conselho = $value->ft_conselho;
				
    			$tx_dado_anterior = $tx_dado_anterior . '"cd_conselho": "' . $value->cd_conselho . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"cd_conselho": "' . $cd_conselho . '",';
    			
    			$cd_tipo_participacao = $params['cd_tipo_participacao'];
    			if($value->cd_tipo_participacao != $cd_tipo_participacao){
    				$ft_tipo_participacao = $this->ft_representante;
    				$flag_update = true;
    			}
    			else $ft_tipo_participacao = $value->ft_tipo_participacao;
    			
    			$tx_dado_anterior = $tx_dado_anterior . '"cd_tipo_participacao": "' . $value->cd_tipo_participacao . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"cd_tipo_participacao": "' . $cd_tipo_participacao . '",';
    			
    			$tx_nome_conselho = $params['tx_nome_conselho'];
    			$ft_nome_conselho = $this->ft_representante;
				
    			$cd_periodicidade_reuniao_conselho = $params['cd_periodicidade_reuniao_conselho'];
    			if($value->cd_periodicidade_reuniao_conselho != $cd_periodicidade_reuniao_conselho){
    				$ft_periodicidade_reuniao = $this->ft_representante;
    				$flag_update = true;
    			}
    			else $ft_periodicidade_reuniao = $value->ft_periodicidade_reuniao;
    			
    			$tx_dado_anterior = $tx_dado_anterior . '"cd_periodicidade_reuniao_conselho": "' . $value->cd_periodicidade_reuniao_conselho . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"cd_periodicidade_reuniao_conselho": "' . $cd_periodicidade_reuniao_conselho . '",';
				
    			$dt_inicio_conselho = $params['dt_data_inicio_conselho'];
    			if($value->dt_data_inicio_conselho != $dt_inicio_conselho){
    				$ft_dt_inicio_conselho = $this->ft_representante;
    				$flag_update = true;
    			}
    			else $ft_dt_inicio_conselho = $value->ft_data_inicio_conselho;
    			
    			$tx_dado_anterior = $tx_dado_anterior . '"dt_data_inicio_conselho": "' . $value->dt_data_inicio_conselho . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"dt_data_inicio_conselho": "' . $dt_inicio_conselho . '",';
				
    			$dt_fim_conselho = $params['dt_data_fim_conselho'];
    			if($value->dt_data_fim_conselho != $dt_fim_conselho){
    				$ft_dt_fim_conselho = $this->ft_representante;
    				$flag_update = true;
    			}
    			else $ft_dt_fim_conselho = $value->ft_data_fim_conselho;
    			
    			$tx_dado_anterior = $tx_dado_anterior . '"dt_data_fim_conselho": "' . $value->dt_data_fim_conselho . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"dt_data_fim_conselho": "' . $dt_fim_conselho . '",';
				
    			if($flag_update){
    				$params = [$cd_conselho, $cd_tipo_participacao, $ft_tipo_participacao, $cd_periodicidade_reuniao_conselho, $ft_periodicidade_reuniao, $dt_inicio_conselho, $ft_dt_inicio_conselho, $dt_fim_conselho, $ft_dt_fim_conselho, $id_osc, $id_conselho];
	    			$resultDao = $this->dao->updateParticipacaoSocialConselho($params);
	    			
	    			$this->logController->saveLog('osc.tb_participacao_social_conselho', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
	    			
	    			$result = ['msg' => $resultDao['mensagem']];
	    			$this->configResponse($result);
    			}
    			
    			$json_outro = DB::select('SELECT * FROM osc.tb_participacao_social_conselho_outro WHERE id_conselho = ?::INTEGER;', [$id_conselho]);
    			
    			if(count($json_outro) > 0){
    				if($tx_nome_conselho != null){
    					foreach($json_outro as $key_outro => $value_outro){
    						if($id_conselho == $value_outro->id_conselho && $cd_conselho == 104){
    							if($value_outro->tx_nome_conselho != $tx_nome_conselho){ 
    								$tx_dado_anterior = '';
    								$tx_dado_posterior = '';
    								
    								$id_conselho_outro = $value_outro->id_conselho_outro;
    								$ft_nome_conselho = $this->ft_representante;
    								
    								$params = [$tx_nome_conselho, $ft_nome_conselho, $id_conselho];
    								$this->dao->updateParticipacaoSocialConselhoOutro($params);
    								
    								$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_conselho": "' . $value_outro->tx_nome_conselho . '",';
    								$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_conselho": "' . $tx_nome_conselho . '",';
    								$this->logController->saveLog('osc.tb_participacao_social_conselho_outro', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    							}
    						}else{
    						    $this->deleteParticipacaoSocialConselhoOutro($id_conselho, $id_usuario, $id_osc);
    						}
    					}
    				}else{
    				    $this->deleteParticipacaoSocialConselhoOutro($id_conselho, $id_usuario, $id_osc);
    				}
    			}else{
    				if($tx_nome_conselho != null){
    					$tx_dado_anterior = '';
    					$tx_dado_posterior = '';
    					
    					$params = [$tx_nome_conselho, $ft_nome_conselho, $id_conselho];
    					$this->dao->setParticipacaoSocialConselhoOutro($params);
    					
    					$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_conselho": "",';
    					$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_conselho": "' . $tx_nome_conselho . '",';    					
    					$this->logController->saveLog('osc.tb_participacao_social_conselho_outro', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    				}
    			}
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado.'];
    			$this->configResponse($result);
    		}
    	}
    	return $this->response();
    }
    
    private function deleteParticipacaoSocialConselho($id_conselho, $id_usuario, $id_osc)
    {
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conselho_outro WHERE id_conselho = ?::INTEGER;', [$id_conselho]);
    	
    	foreach($json as $key => $value){
    		if($id_conselho == $value->id_conselho){   			
    		    $this->deleteParticipacaoSocialConselhoOutro($id_conselho, $id_usuario, $id_osc);
    		}
    	}
		
    	$json_membro = DB::select('SELECT * FROM osc.tb_representante_conselho WHERE id_participacao_social_conselho = ?::INTEGER;', [$id_conselho]);
    	foreach($json_membro as $key => $value){
    		if($id_conselho == $value->id_participacao_social_conselho){
    			$tx_nome_representante_conselho = $value->tx_nome_representante_conselho;
    			
    			$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_representante_conselho": "' . $tx_nome_representante_conselho . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_representante_conselho": "",';
    			
    			$this->dao->deleteMembroParticipacaoSocialConselhoByIdConselho([$id_conselho]);
    			
    			$this->logController->saveLog('osc.tb_representante_conselho', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    		}
    	}
    	
    	$json_conselho = DB::select('SELECT * FROM osc.tb_participacao_social_conselho WHERE id_conselho = ?::INTEGER;', [$id_conselho]);
    	
    	foreach($json_conselho as $key => $value){
    		if($id_conselho == $value->id_conselho){
    			$cd_tipo_participacao = $value->cd_tipo_participacao;
    			
    			$tx_dado_anterior = $tx_dado_anterior . '"cd_tipo_participacao": "' . $cd_tipo_participacao . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"cd_tipo_participacao": "",';
    			 
    			$cd_periodicidade_reuniao_conselho = $value->cd_periodicidade_reuniao_conselho;
    			
    			$tx_dado_anterior = $tx_dado_anterior . '"cd_periodicidade_reuniao_conselho": "' . $cd_periodicidade_reuniao_conselho . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"cd_periodicidade_reuniao_conselho": "",';
    			
    			$dt_inicio_conselho = $value->dt_data_inicio_conselho;
    			
    			$tx_dado_anterior = $tx_dado_anterior . '"dt_data_inicio_conselho": "' . $dt_inicio_conselho . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"dt_data_inicio_conselho": "",';
    			
    			$dt_fim_conselho = $value->dt_data_fim_conselho;
    			
    			$tx_dado_anterior = $tx_dado_anterior . '"dt_data_fim_conselho": "' . $dt_fim_conselho . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"dt_data_fim_conselho": "",';
    			
				$result = $this->dao->deleteParticipacaoSocialConselho([$id_conselho]);
    			
    			$this->logController->saveLog('osc.tb_participacao_social_conselho', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    		}
    	}
		
		return $result;
    }
    
	private function deleteMembroParticipacaoSocialConselho($id_representante_conselho, $id_usuario)
	{
		$tx_dado_anterior = '';
		$tx_dado_posterior = '';
		
		$json_membro = DB::select('SELECT * FROM osc.tb_representante_conselho WHERE id_representante_conselho = ?::INTEGER;', [$id_representante_conselho]);
		
		foreach($json_membro as $key => $value){
			if($id_representante_conselho == $value->id_representante_conselho){
				$result = $this->dao->deleteMembroParticipacaoSocialConselho([$value->id_representante_conselho]);
				
				$tx_dado_anterior = $tx_dado_anterior . '"id_representante_conselho":' . $value->id_representante_conselho . ',"tx_nome_representante_conselho": "' . $value->tx_nome_representante_conselho . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"id_representante_conselho": "",' . '"tx_nome_representante_conselho": "",';
				$this->logController->saveLog('osc.tb_representante_conselho', $id_representante_conselho, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
			}
		}
	}
	
	public function deleteParticipacaoSocialConselhoOutro($id_conselho, $id_usuario, $id_osc){
		$json_conselho = DB::select('SELECT * FROM osc.tb_participacao_social_conselho WHERE id_conselho = ?::INTEGER', [$id_conselho]);
		$json = DB::select('SELECT * FROM osc.tb_participacao_social_conselho_outro WHERE id_conselho = ?::INTEGER', [$id_conselho]);
		
		$tx_dado_anterior = '';
		$tx_dado_posterior = '';
		
		foreach($json_conselho as $key_conselho => $value_conselho){
			$id_osc = $json_conselho[$key_conselho]->id_conselho;
			if($id_osc == $id_conselho){
				$bo_oficial = $json_conselho[$key_conselho]->bo_oficial;
				if(!$bo_oficial){
					foreach($json as $key => $value){
						$id_conselho_outro = $value->id_conselho_outro;
						
						$tx_nome_conselho = $value->tx_nome_conselho;
						
						$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_conselho": "' . $tx_nome_conselho . '",';
						$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_conselho": "",';
						
						$params = [$id_conselho];
						$resultDao = $this->dao->deleteParticipacaoSocialConselhoOutro($params);
						
						$this->logController->saveLog('osc.tb_participacao_social_conselho_outro', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
						
						$result = ['msg' => 'Participacao Social Conselho Outro excluido'];
					}
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
		
		$id_usuario = $request->user()->id;
		
		$query = "SELECT * FROM osc.tb_participacao_social_conferencia WHERE id_osc = ?::INTEGER;";
		$db = DB::select($query, [$id_osc]);
		
		$array_insert = array();
		$array_update = array();
		$array_delete = $db;
		
		$nao_possui = $request->bo_nao_possui_conferencias;
		
		$result = ['msg' => 'Participação social em conferência atualizada'];
		
		if(count($req) == 0){
			if($nao_possui){
				$params = ["id_usuario" => $id_usuario, "id_osc" => $id_osc, "cd_conferencia" => 133, "tx_nome_conferencia" => null, "dt_ano_realizacao" => null, "cd_forma_participacao_conferencia" => null];
				array_push($array_insert, $params);
			}
		}else{
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
						
						$params = ["id_usuario" => $id_usuario, "id_osc" => $id_osc, "cd_conferencia" => $cd_conferencia, "tx_nome_conferencia" => $tx_nome_conferencia, "dt_ano_realizacao" => $dt_ano_realizacao, "cd_forma_participacao_conferencia" => $cd_forma_participacao_conferencia];
						
						foreach ($db as $key_db => $value_db) {
							$id_conferencia = $value_req['id_conferencia'];
							if($value_db->id_conferencia == $id_conferencia){
								$flag_insert = false;
								
								$params['bo_oficial'] = $value_db->bo_oficial;
								
								$json_outra = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia = ?::INTEGER;', [$id_conferencia]);
									
								foreach($json_outra as $key_outra => $value_outra){
									
									if($value_db->cd_conferencia != $cd_conferencia || $value_db->dt_ano_realizacao != $dt_ano_realizacao || $value_db->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia || $value_outra->tx_nome_conferencia != $tx_nome_conferencia){
										$params['id_conferencia'] = $id_conferencia;
										
										if($value_db->cd_conferencia != $cd_conferencia){
											$params['ft_conferencia'] = $this->ft_representante;
										}else{
											$params['ft_conferencia'] = $value_db->ft_conferencia;
										}
										
										if($value_db->dt_ano_realizacao != $dt_ano_realizacao){
											$params['ft_ano_realizacao'] = $this->ft_representante;
										}else{
											$params['ft_ano_realizacao'] = $value_db->ft_ano_realizacao;
										}
										
										if($value_db->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia){
											$params['ft_forma_participacao_conferencia'] = $this->ft_representante;
										}else{
											$params['ft_forma_participacao_conferencia'] = $value_db->ft_forma_participacao_conferencia;
										}
										
										array_push($array_update, $params);
									}
								}
								
								if($value_db->cd_conferencia != $cd_conferencia || $value_db->dt_ano_realizacao != $dt_ano_realizacao || $value_db->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia || $tx_nome_conferencia != null){
									$params['id_conferencia'] = $id_conferencia;
									
									if($value_db->cd_conferencia != $cd_conferencia){
										$params['ft_conferencia'] = $this->ft_representante;
									}else{
										$params['ft_conferencia'] = $value_db->ft_conferencia;
									}
									
									if($value_db->dt_ano_realizacao != $dt_ano_realizacao){
										$params['ft_ano_realizacao'] = $this->ft_representante;
									}else{
										$params['ft_ano_realizacao'] = $value_db->ft_ano_realizacao;
									}
									
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
							if($value->id_conferencia == $id_conferencia){
								unset($array_delete[$key]);
							}
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
				$flag_operation_delete = $this->deleteParticipacaoSocialConferencia($value, $id_usuario);
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
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$id_usuario = $params['id_usuario'];
    	
    	$id_osc = $params['id_osc'];
		
    	$cd_conferencia = $params['cd_conferencia'];
    	$ft_conferencia = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"cd_conferencia": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_conferencia": "' . $cd_conferencia . '",';
    	
    	$tx_nome_conferencia = $params['tx_nome_conferencia'];
    	$ft_nome_conferencia = $this->ft_representante;
		
    	$dt_ano_realizacao = $params['dt_ano_realizacao'];
    	$ft_ano_realizacao = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"dt_ano_realizacao": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"dt_ano_realizacao": "' . $dt_ano_realizacao . '",';
		
    	$cd_forma_participacao_conferencia = $params['cd_forma_participacao_conferencia'];
    	$ft_forma_participacao_conferencia = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"cd_forma_participacao_conferencia": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_forma_participacao_conferencia": "' . $cd_forma_participacao_conferencia . '",';
		
    	$bo_oficial = false;
		
    	$params_insert = [$cd_conferencia, $ft_conferencia, $id_osc, $dt_ano_realizacao, $ft_ano_realizacao, $cd_forma_participacao_conferencia, $ft_forma_participacao_conferencia, $bo_oficial];
    	$result = $this->dao->insertParticipacaoSocialConferencia($params_insert);
    	
    	$this->logController->saveLog('osc.tb_participacao_social_conferencia', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    	
    	if($result){
    		$id_conferencia = $result->id_conferencia;
    
    		if($tx_nome_conferencia != null){
    			$params['id_conferencia'] = $id_conferencia;
    			$params['ft_nome_conferencia'] = $ft_nome_conferencia;
    			$this->setParticipacaoSocialConferenciaOutra($params);
    		}
    	}
    }
    
    private function setParticipacaoSocialConferenciaOutra($params)
    {
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$id_usuario = $params['id_usuario'];
    	$id_osc = $params['id_osc'];
    	$id_conferencia = $params['id_conferencia'];
    	
    	$tx_nome_conferencia = $params['tx_nome_conferencia'];
    	$ft_nome_conferencia = $params['ft_nome_conferencia'];
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_conferencia": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_conferencia": "' . $tx_nome_conferencia . '",';
    	
    	$params = [$tx_nome_conferencia, $ft_nome_conferencia, $id_conferencia];
    	$this->dao->setParticipacaoSocialConferenciaOutra($params);
    		 
    	$this->logController->saveLog('osc.tb_participacao_social_conferencia_outra', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    }
    
    private function updateParticipacaoSocialConferencia($params)
    {
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$flag_update = false;
    	
    	$id_usuario = $params['id_usuario'];
		$id_osc = $params['id_osc'];
    	$id_conferencia = $params['id_conferencia'];
    	
    	$tx_nome_conferencia = $params['tx_nome_conferencia'];
    	$ft_nome_conferencia = $this->ft_representante;
    	
    	$bo_oficial = $params['bo_oficial'];
    	
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia WHERE id_conferencia = ?::INTEGER;', [$id_conferencia]);
    	
		$result = ['msg' => 'Participação social em conferência atualizada.'];
		
    	if($bo_oficial == false){
    		foreach($json as $key => $value){
    			
    			$cd_conferencia = $params['cd_conferencia'];
    			if($value->cd_conferencia != $cd_conferencia){
    				$ft_conferencia = $this->ft_representante;
    				$flag_update = true;
    			}
    			else $ft_conferencia = $value->ft_conferencia;
    		
    			$tx_dado_anterior = $tx_dado_anterior . '"cd_conferencia": "' . $value->cd_conferencia . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"cd_conferencia": "' . $cd_conferencia . '",';
    			
    			$dt_ano_realizacao = $params['dt_ano_realizacao'];
    			if($value->dt_ano_realizacao != $dt_ano_realizacao){
    				$ft_ano_realizacao = $this->ft_representante;
    				$flag_update = true;
    			}
    			else $ft_ano_realizacao = $value->ft_ano_realizacao;
    		
    			$tx_dado_anterior = $tx_dado_anterior . '"dt_ano_realizacao": "' . $value->dt_ano_realizacao . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"dt_ano_realizacao": "' . $dt_ano_realizacao . '",';
    			
    			$cd_forma_participacao_conferencia = $params['cd_forma_participacao_conferencia'];
    			if($value->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia){
    				$ft_forma_participacao_conferencia = $this->ft_representante;
    				$flag_update = true;
    			}
    			else $ft_forma_participacao_conferencia = $value->ft_forma_participacao_conferencia;
    		
    			$tx_dado_anterior = $tx_dado_anterior . '"cd_forma_participacao_conferencia": "' . $value->cd_forma_participacao_conferencia . '",';
    			$tx_dado_posterior = $tx_dado_posterior . '"cd_forma_participacao_conferencia": "' . $cd_forma_participacao_conferencia . '",';
    		
    			if($flag_update){
	    			$params = [$id_osc, $id_conferencia, $cd_conferencia, $ft_conferencia, $dt_ano_realizacao, $ft_ano_realizacao, $cd_forma_participacao_conferencia, $ft_forma_participacao_conferencia];
	    			$resultDao = $this->dao->updateParticipacaoSocialConferencia($params);
	    			
	    			$this->logController->saveLog('osc.tb_participacao_social_conferencia', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
	    			
	    			$result = ['msg' => $resultDao->mensagem];
    			}
    		}
    		
    		$json_outra = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia = ?::INTEGER;', [$id_conferencia]);
    		
    		if(count($json_outra)>0){
    			if($tx_nome_conferencia != null){
    				foreach($json_outra as $key_outra => $value_outra){
    					$tx_dado_anterior = '';
    					$tx_dado_posterior = '';
    					
    					if($id_conferencia == $value_outra->id_conferencia){
    						if($value_outra->tx_nome_conferencia != $tx_nome_conferencia){ 
    							$id_conferencia_outra = $value_outra->id_conferencia_outra;
    							
    							$ft_nome_conferencia = $this->ft_representante;
    							
    							$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_conferencia": "' . $value_outra->tx_nome_conferencia . '",';
    							$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_conferencia": "' . $tx_nome_conferencia . '",';
    							
    							$params = [$tx_nome_conferencia, $ft_nome_conferencia, $id_conferencia];
    							$this->dao->updateParticipacaoSocialConferenciaOutra($params);
    							
    							$this->logController->saveLog('osc.tb_participacao_social_conferencia_outra', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    						}
    					}
    				}
    			}else{
    				$this->deleteParticipacaoSocialConferenciaOutra($id_conferencia, $id_osc, $id_usuario);
    			}
    		}else{
    			if($tx_nome_conferencia != null){
    				$params['ft_nome_conferencia'] = $ft_nome_conferencia;
    				$this->setParticipacaoSocialConferenciaOutra($params);
    			}
    		}
    	}else{
    		$result = ['msg' => 'Dado Oficial, não pode ser modificado.'];
    	}
    	
    	$this->configResponse($result);
    	return $this->response();
    }
    
    private function deleteParticipacaoSocialConferencia($params, $id_usuario)
    {
        $id_osc = $params->id_osc;
        
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
		$id_osc = $params->id_osc;
		$id_conferencia = $params->id_conferencia;
		
		$json_outra = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia = ?::INTEGER;', [$id_conferencia]);
		
		foreach($json_outra as $key => $value){
			if($id_conferencia == $value->id_conferencia){
				$this->deleteParticipacaoSocialConferenciaOutra($id_conferencia, $id_osc, $id_usuario);
			}
		}
		
		$json = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia WHERE id_conferencia = ?::INTEGER;', [$id_conferencia]);
		
		foreach($json as $key => $value){
			if($id_conferencia == $value->id_conferencia){
				
				$cd_conferencia = $value->cd_conferencia;
				
				$tx_dado_anterior = $tx_dado_anterior . '"cd_conferencia": "' . $cd_conferencia . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"cd_conferencia": "",';
				
				$dt_ano_realizacao = $value->dt_ano_realizacao;
				
				$tx_dado_anterior = $tx_dado_anterior . '"dt_ano_realizacao": "' . $dt_ano_realizacao . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"dt_ano_realizacao": "",';
				
				$cd_forma_participacao_conferencia = $value->cd_forma_participacao_conferencia;
				
				$tx_dado_anterior = $tx_dado_anterior . '"cd_forma_participacao_conferencia": "' . $cd_forma_participacao_conferencia . '",';
				$tx_dado_posterior = $tx_dado_posterior . '"cd_forma_participacao_conferencia": "",';
				
				$params = [$id_conferencia];
    			$resultDao = $this->dao->deleteParticipacaoSocialConferencia($params);
		
    			$this->logController->saveLog('osc.tb_participacao_social_conferencia', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
			}
		}

    	return $resultDao;
    }
    
    public function deleteParticipacaoSocialConferenciaOutra($id_conferencia, $id_osc, $id_usuario)
    {   
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$json_conferencia = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia WHERE id_conferencia = ?::int',[$id_conferencia]);
    	
    	$json_outra = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia = ?::INTEGER;', [$id_conferencia]);
    	
    	foreach($json_conferencia as $key_conferencia => $value){
    		if($id_osc == $json_conferencia[$key_conferencia]->id_osc){
    			$bo_oficial = $json_conferencia[$key_conferencia]->bo_oficial;
    			if(!$bo_oficial){	
    				foreach($json_outra as $key_outra => $value_outra){
    					$id_conferencia_outra = $value_outra->id_conferencia_outra;
    					$tx_nome_conferencia = $value_outra->tx_nome_conferencia;
    						
    					$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_conferencia": "' . $tx_nome_conferencia . '",';
    					$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_conferencia": "",';
    					
    					$params = [$id_conferencia];
    					$resultDao = $this->dao->deleteParticipacaoSocialConferenciaOutra($params);
    					
    					$this->logController->saveLog('osc.tb_participacao_social_conferencia_outra', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    					
    					$result = ['msg' => 'Participacao Social Conferencia Outra excluida.'];
    				}
    			}else{
    				$result = ['msg' => 'Dado Oficial, não pode ser excluido.'];
    			}
    		}else{
    			$result = ['msg' => 'ID de OSC inválida.'];
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
    	
    	$id_usuario = $request->user()->id;
    	
    	$query = "SELECT * FROM osc.tb_participacao_social_outra WHERE id_osc = ?::INTEGER;";
    	$db = DB::select($query, [$id_osc]);
    	
    	$array_insert = array();
    	$array_delete = $db;
    	
    	$result = ['msg' => 'Participação social outra da OSC atualizada.'];
    	
    	$nao_possui = $request->bo_nao_possui_outros_part;
    	
    	if($req){
	    	foreach($req as $key_req => $value_req){
	    		
	    		if(is_null($value_req) === true){
	    			if($nao_possui){
		    			$params = ["id_usuario" => $id_usuario, "id_osc" => $id_osc, "tx_nome_participacao_social_outra" => null, "bo_nao_possui" => true];
		    			array_push($array_insert, $params);
		    		}
	    		}else{
		    		$tx_nome_participacao_social_outra = null;
		    		if(isset($value_req['tx_nome_participacao_social_outra'])){
		    			$tx_nome_participacao_social_outra = $value_req['tx_nome_participacao_social_outra'];
		    		}
		    		
		    		$params = ["id_usuario" => $id_usuario, "id_osc" => $id_osc, "tx_nome_participacao_social_outra" => $tx_nome_participacao_social_outra, "bo_nao_possui" => false];
		    		
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
    	}
    	
    	$flag_insert = true;
    	foreach($array_insert as $key => $value){
    		$flag_insert = $this->insertParticipacaoSocialOutra($value);
    	}
    	
    	$flag_delete = true;
    	foreach($array_delete as $key => $value){
    		$flag_delete = $this->deleteParticipacaoSocialOutra($value, $id_usuario);
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
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$id_usuario = $params['id_usuario'];
    	
    	$id_osc = $params['id_osc'];
    	
    	$tx_nome_participacao_social_outra = $params['tx_nome_participacao_social_outra'];
    	$ft_participacao_social_outra = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_participacao_social_outra": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_participacao_social_outra": "' . $tx_nome_participacao_social_outra . '",';
    	
    	$bo_oficial = false;
    	
    	$bo_nao_possui = $params['bo_nao_possui'];
		
    	$params = [$id_osc, $tx_nome_participacao_social_outra, $ft_participacao_social_outra, $bo_oficial, $bo_nao_possui];
    	$result = $this->dao->insertParticipacaoSocialOutra($params);
    	
    	$this->logController->saveLog('osc.tb_participacao_social_outra', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    	
    	return $result;
    }
    
    private function deleteParticipacaoSocialOutra($params, $id_usuario)
    {
        $id_osc = $params->id_osc;
        
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$id_participacao_social_outra = $params->id_participacao_social_outra;
    	
    	$tx_nome_participacao_social_outra = $params->tx_nome_participacao_social_outra;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_participacao_social_outra": "' . $tx_nome_participacao_social_outra . '",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_participacao_social_outra": "",';
		
    	$params = [$id_participacao_social_outra];
    	$result = $this->dao->deleteParticipacaoSocialOutra($params);
    	
    	$this->logController->saveLog('osc.tb_participacao_social_outra', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
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
		
		$id_usuario = $request->user()->id;
		
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
				$params['id_usuario'] = $id_usuario;
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
			$this->deleteConselhoFiscal($value, $id_usuario);
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
    
    private function deleteConselhoFiscal($params, $id_usuario)
    {
        $id_osc = $params->id_osc;
        
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$id_conselho_fiscal = $params->id_conselheiro;
    	
    	$tx_nome_conselheiro = $params->tx_nome_conselheiro;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_conselheiro": "' . $tx_nome_conselheiro . '",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_conselheiro": "",';
		
    	$params = [$id_conselho_fiscal];
    	$result = $this->dao->deleteConselhoFiscal($params);
    	
    	$this->logController->saveLog('osc.tb_conselho_fiscal', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
    	return $result;
    }
    
    private function updateConselhoFiscal($params)
    {
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	
    	$conselho_fiscal_db = $params['conselho_fiscal_db'];
    	
    	$id_usuario = $params['id_usuario'];
    	
    	$id_osc = $params['id_osc'];
    	$id_conselheiro = $params['id_conselheiro'];
    	$tx_nome_conselheiro = $params['tx_nome_conselheiro'];
    	$ft_nome_conselheiro = $conselho_fiscal_db->ft_nome_conselheiro;
    	
    	if($conselho_fiscal_db->tx_nome_conselheiro != $tx_nome_conselheiro){
    		$ft_nome_conselheiro = $this->ft_representante;
    	}
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_conselheiro": "' . $conselho_fiscal_db->tx_nome_conselheiro . '",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_conselheiro": "' . $tx_nome_conselheiro . '",';
		
    	$params = [$id_osc, $id_conselheiro, $tx_nome_conselheiro, $ft_nome_conselheiro];
    	$result = $this->dao->updateConselhoFiscal($params);
    	
    	$this->logController->saveLog('osc.tb_conselho_fiscal', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
    	return $result;
    }
    
    private function insertConselhoFiscal($params)
    {
    	$tx_dado_anterior = '';
    	$tx_dado_posterior = '';
    	 
    	$id_usuario = $params['id_usuario'];
    	
    	$id_osc = $params['id_osc'];
    	
    	$nome = $params['tx_nome_conselheiro'];
    	$ft_nome = $this->ft_representante;
    	
    	$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_conselheiro": "",';
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_conselheiro": "' . $nome . '",';
    	
    	$bo_oficial = false;
		
    	$params = [$id_osc, $nome, $ft_nome, $bo_oficial];
    	$result = $this->dao->insertConselhoFiscal($params);
    	
    	$this->logController->saveLog('osc.tb_conselho_fiscal', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
		
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
    	$tx_dado_posterior = '';
    	$id_osc = $request->input('id_osc');
    	$flag_insert = false;
    	
		$tx_nome = null;
		if($request->input('tx_nome_projeto')){
			$tx_nome = $request->input('tx_nome_projeto');
			$flag_insert = true;
		}
    	$ft_nome = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_projeto": "' . $tx_nome . '",';
		
		$cd_status = null;
		if($request->input('cd_status_projeto')){
			$cd_status = $request->input('cd_status_projeto');
			$flag_insert = true;
		}
    	$ft_status = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_status_projeto": "' . $cd_status . '",';
		
		$dt_data_inicio_projeto = null;
		if($request->input('dt_data_inicio_projeto')){
			$dt_data_inicio_projeto = $request->input('dt_data_inicio_projeto');
			$date = date_create($dt_data_inicio_projeto);
			$dt_data_inicio_projeto = date_format($date, "Y-m-d");
			$flag_insert = true;
		}
    	$ft_data_inicio = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"dt_data_inicio_projeto": "' . $dt_data_inicio_projeto . '",';
		
		$dt_data_fim_projeto = null;
		if($request->input('dt_data_fim_projeto')){
			$dt_data_fim_projeto = $request->input('dt_data_fim_projeto');
			$date = date_create($dt_data_fim_projeto);
			$dt_data_fim_projeto = date_format($date, "Y-m-d");
			$flag_insert = true;
		}
    	$ft_data_fim = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"dt_data_fim_projeto": "' . $dt_data_fim_projeto . '",';
		
		$nr_valor_total = null;
		if($request->input('nr_valor_total_projeto')){
			$nr_valor_total = $request->input('nr_valor_total_projeto');
			$nr_valor_total = $this->formatacaoUtil->converMoneyToDouble($nr_valor_total);
			$flag_insert = true;
		}
    	$ft_valor_total = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"nr_valor_total_projeto": "' . $nr_valor_total . '",';
		
		$tx_link = null;
		if($request->input('tx_link_projeto')){
			$tx_link = $request->input('tx_link_projeto');
			$flag_insert = true;
		}
    	$ft_link = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_link_projeto": "' . $tx_link . '",';
		
		$cd_abrangencia = null;
		if($request->input('cd_abrangencia_projeto')){
			$cd_abrangencia = $request->input('cd_abrangencia_projeto');
			$flag_insert = true;
		}
    	$ft_abrangencia = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_abrangencia_projeto": "' . $cd_abrangencia . '",';
		
		$tx_descricao = null;
		if($request->input('tx_descricao_projeto')){
			$tx_descricao = $request->input('tx_descricao_projeto');
			$flag_insert = true;
		}
    	$ft_descricao = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_descricao_projeto": "' . $tx_descricao . '",';
		
		$nr_total_beneficiarios = null;
		if($request->input('nr_total_beneficiarios')){
			$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
			$flag_insert = true;
		}
    	$ft_total_beneficiarios = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"nr_total_beneficiarios": "' . $nr_total_beneficiarios . '",';
		
		$nr_valor_captado_projeto = null;
		if($request->input('nr_valor_captado_projeto')){
			$nr_valor_captado_projeto = $request->input('nr_valor_captado_projeto');
			$nr_valor_captado_projeto = $this->formatacaoUtil->converMoneyToDouble($nr_valor_captado_projeto);
			$flag_insert = true;
		}
    	$ft_valor_captado_projeto = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"nr_valor_captado_projeto": "' . $nr_valor_captado_projeto . '",';
		
		$cd_zona_atuacao_projeto = null;
		if($request->input('cd_zona_atuacao_projeto')){
			$cd_zona_atuacao_projeto = $request->input('cd_zona_atuacao_projeto');
			$flag_insert = true;
		}
    	$ft_zona_atuacao_projeto = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"cd_zona_atuacao_projeto": "' . $cd_zona_atuacao_projeto . '",';
		
		$tx_metodologia_monitoramento = null;
		if($request->input('tx_metodologia_monitoramento')){
			$tx_metodologia_monitoramento = $request->input('tx_metodologia_monitoramento');
			$flag_insert = true;
		}
    	$ft_metodologia_monitoramento = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_metodologia_monitoramento": "' . $tx_metodologia_monitoramento . '",';
		
		$tx_identificador_projeto_externo = null;
		if($request->input('tx_identificador_projeto_externo')){
			$tx_identificador_projeto_externo = $request->input('tx_identificador_projeto_externo');
			$flag_insert = true;
		}
    	$ft_identificador_projeto_externo = $this->ft_representante;
    	$tx_dado_posterior = $tx_dado_posterior . '"tx_identificador_projeto_externo": "' . $tx_identificador_projeto_externo . '",';
		
		$bo_oficial = false;
		
		$params = [$id_osc, $tx_nome, $ft_nome, $cd_status, $ft_status, $dt_data_inicio_projeto, $ft_data_inicio,
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
		if($request->osc_parceira){
			$osc_parceira = true;
			$flag_insert = true;
		}
		
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
		
		$tipo_parceria = false;
		if($request->tipo_parceria){
			$tipo_parceria = true;
			$flag_insert = true;
		}
		
		if($flag_insert){
			$result = $this->dao->setProjeto($params);
			
			$this->logController->saveLog('osc.tb_projeto', $id_osc, $request->user()->id, null, $tx_dado_posterior);
			
    		$id_projeto = $result->inserir_projeto;
    		
    		if($publico_beneficiado){
    		    $this->setPublicoBeneficiado($request, $id_projeto, $id_osc);
    		}
    		
    		//if($area_atuacao){
    		//	$this->setAreaAtuacaoProjeto($request, $id_projeto, $id_osc);
			//}
			
	    	//if($area_atuacao_outra){
	    	//	$this->setAreaAtuacaoOutraProjeto($request, $id_projeto);
			//}
			
    		if($localizacao){
    		    $this->setLocalizacaoProjeto($request, $id_projeto, $id_osc);
    		}
    		
    		if($objetivo_meta){
    		    $this->setObjetivoProjeto($request, $id_projeto, $id_osc);
    		}
    		
	    	if($osc_parceira){
	    	    $this->setParceiraProjeto($request, $id_projeto, $id_osc);
			}
			
			if($financiador_projeto){
			    $this->setFinanciadorProjeto($request, $id_projeto, $id_osc);
			}
			
			if($fonte_recursos){
			    $this->setFonteRecursosProjeto($request, $id_projeto, $id_osc);
			}
			
			if($tipo_parceria){
			    $this->setTipoParceriaProjeto($request, $id_projeto, $id_osc);
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
		$tx_dado_anterior = '';
		$tx_dado_posterior = '';
		
		$id_usuario = $request->user()->id;
		
		$result = null;
		
    	$id_projeto = $request->input('id_projeto');
    	$json = DB::select('SELECT * FROM osc.tb_projeto WHERE id_projeto = ?::INTEGER', [$id_projeto]);
    	
    	foreach($json as $key => $value){
    		$tx_nome = $value->tx_nome_projeto;
    		$ft_nome = $value->ft_nome_projeto;
    		if($request->input('tx_nome_projeto') && (in_array($value->ft_nome_projeto, $this->fontesEditaveis))){
    			$tx_nome = $request->input('tx_nome_projeto');
    			
    			if($value->tx_nome_projeto != $tx_nome){
    				$ft_nome = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"tx_nome_projeto": "' . $value->tx_nome_projeto . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_projeto": "' . $tx_nome . '",';
    			}
    		}
    		
    		$cd_status = $value->cd_status_projeto;
    		$ft_status = $value->ft_status_projeto;
    		if($request->input('cd_status_projeto') && (in_array($value->ft_status_projeto, $this->fontesEditaveis))){
    			$cd_status = $request->input('cd_status_projeto');
    			
    			if($value->cd_status_projeto != $cd_status){
    				$ft_status = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"cd_status_projeto": "' . $value->cd_status_projeto . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"cd_status_projeto": "' . $cd_status . '",';
    			}
    		}
    		
    		$dt_data_inicio = $value->dt_data_inicio_projeto;
    		$ft_data_inicio = $value->ft_data_inicio_projeto;
    		if($request->input('dt_data_inicio_projeto') && (in_array($value->ft_data_inicio_projeto, $this->fontesEditaveis))){
    			$dt_data_inicio = $request->input('dt_data_inicio_projeto');
    			
    			if($value->dt_data_inicio_projeto != $dt_data_inicio){
    				$ft_data_inicio = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"dt_data_inicio_projeto": "' . $value->dt_data_inicio_projeto . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"dt_data_inicio_projeto": "' . $dt_data_inicio . '",';
    			}
    		}
    		
    		$dt_data_fim = $value->dt_data_fim_projeto;
    		$ft_data_fim = $value->ft_data_fim_projeto;
    		if($request->input('dt_data_fim_projeto') && (in_array($value->ft_data_fim_projeto, $this->fontesEditaveis))){
    			$dt_data_fim = $request->input('dt_data_fim_projeto');
    			
    			if($value->dt_data_fim_projeto != $dt_data_fim){
    				$ft_data_fim = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"dt_data_fim_projeto": "' . $value->dt_data_fim_projeto . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"dt_data_fim_projeto": "' . $dt_data_fim . '",';
    			}
    		}
    		
    		$nr_valor_total = $value->nr_valor_total_projeto;
    		$ft_valor_total = $value->ft_valor_total_projeto;
    		if($request->input('nr_valor_total_projeto') && (in_array($value->ft_valor_total_projeto, $this->fontesEditaveis))){
    			$nr_valor_total = $request->input('nr_valor_total_projeto');
    			
    			if($value->nr_valor_total_projeto != $nr_valor_total){
    				$ft_valor_total = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"nr_valor_total_projeto": "' . $value->nr_valor_total_projeto . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"nr_valor_total_projeto": "' . $nr_valor_total . '",';
    			}
    		}
    		
    		$ft_link = $value->tx_link_projeto;
    		$tx_link = $value->ft_link_projeto;
    		if($request->input('tx_link_projeto') && (in_array($value->ft_link_projeto, $this->fontesEditaveis))){
    			$ft_link = $request->input('tx_link_projeto');
    			
    			if($value->tx_link_projeto != $ft_link){
    				$tx_link = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"tx_link_projeto": "' . $value->tx_link_projeto . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"tx_link_projeto": "' . $ft_link . '",';
    			}
    		}
    		
    		$cd_abrangencia = $value->cd_abrangencia_projeto;
    		$ft_abrangencia = $value->ft_abrangencia_projeto;
    		if($request->input('cd_abrangencia_projeto') && (in_array($value->ft_abrangencia_projeto, $this->fontesEditaveis))){
    			$cd_abrangencia = $request->input('cd_abrangencia_projeto');
    			
    			if($value->cd_abrangencia_projeto != $cd_abrangencia){
    				$ft_abrangencia = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"cd_abrangencia_projeto": "' . $value->cd_abrangencia_projeto . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"cd_abrangencia_projeto": "' . $cd_abrangencia . '",';
    			}
    		}
    		
    		$tx_descricao = $value->tx_descricao_projeto;
    		$ft_descricao = $value->ft_descricao_projeto;
    		if($request->input('tx_descricao_projeto') && (in_array($value->ft_descricao_projeto, $this->fontesEditaveis))){
    			$tx_descricao = $request->input('tx_descricao_projeto');
    			
    			if($value->tx_descricao_projeto != $tx_descricao){
    				$ft_descricao = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"tx_descricao_projeto": "' . $value->tx_descricao_projeto . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"tx_descricao_projeto": "' . $tx_descricao . '",';
    			}
    		}
    		
    		$nr_total_beneficiarios = $value->nr_total_beneficiarios;
    		$ft_total_beneficiarios = $value->ft_total_beneficiarios;
    		if($request->input('nr_total_beneficiarios') && (in_array($value->ft_total_beneficiarios, $this->fontesEditaveis))){
    			$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
    			
    			if($value->nr_total_beneficiarios != $nr_total_beneficiarios){
    				$ft_total_beneficiarios = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"nr_total_beneficiarios": "' . $value->nr_total_beneficiarios . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"nr_total_beneficiarios": "' . $nr_total_beneficiarios . '",';
    			}
    		}
    		
    		$nr_valor_captado_projeto = $value->nr_valor_captado_projeto;
    		$ft_valor_captado_projeto = $value->ft_valor_captado_projeto;
    		if($request->input('nr_valor_captado_projeto') && (in_array($value->ft_valor_captado_projeto, $this->fontesEditaveis))){
    			$nr_valor_captado_projeto = $request->input('nr_valor_captado_projeto');
    			
    			if($value->nr_valor_captado_projeto != $nr_valor_captado_projeto){
    				$ft_valor_captado_projeto = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"nr_valor_captado_projeto": "' . $value->nr_valor_captado_projeto . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"nr_valor_captado_projeto": "' . $nr_valor_captado_projeto . '",';
    			}
    		}
    		
    		$cd_zona_atuacao_projeto = $value->cd_zona_atuacao_projeto;
    		$ft_zona_atuacao_projeto = $value->ft_zona_atuacao_projeto;
    		if($request->input('cd_zona_atuacao_projeto') && (in_array($value->ft_zona_atuacao_projeto, $this->fontesEditaveis))){
    			$cd_zona_atuacao_projeto = $request->input('cd_zona_atuacao_projeto');
    			
    			if($value->cd_zona_atuacao_projeto != $cd_zona_atuacao_projeto){
    				$ft_zona_atuacao_projeto = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"cd_zona_atuacao_projeto": "' . $value->cd_zona_atuacao_projeto . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"cd_zona_atuacao_projeto": "' . $cd_zona_atuacao_projeto . '",';
    			}
    		}
    		
    		$tx_metodologia_monitoramento = $value->tx_metodologia_monitoramento;
    		$ft_metodologia_monitoramento = $value->ft_metodologia_monitoramento;
    		if($request->input('tx_metodologia_monitoramento') && (in_array($value->ft_metodologia_monitoramento, $this->fontesEditaveis))){
    			$tx_metodologia_monitoramento = $request->input('tx_metodologia_monitoramento');
    			
    			if($value->tx_metodologia_monitoramento != $tx_metodologia_monitoramento){
    				$ft_metodologia_monitoramento = $this->ft_representante;
    				
    				$tx_dado_anterior = $tx_dado_anterior . '"tx_metodologia_monitoramento": "' . $value->tx_metodologia_monitoramento . '",';
    				$tx_dado_posterior = $tx_dado_posterior . '"tx_metodologia_monitoramento": "' . $tx_metodologia_monitoramento . '",';
    			}
    		}
			
    		$tx_identificador_projeto_externo = $value->tx_identificador_projeto_externo;
    		$ft_identificador_projeto_externo = $value->ft_identificador_projeto_externo;
   			
   			$this->logController->saveLog('osc.tb_projeto', $id_osc, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
   			
   			$this->updatePublicoBeneficiado($request, $id_projeto);
   			//$this->updateAreaAtuacaoProjeto($request, $id_projeto);
   			//$this->updateAreaAtuacaoOutraProjeto($request, $id_projeto);
   			$this->updateLocalizacaoProjeto($request, $id_projeto);
   			$this->updateObjetivoProjeto($request, $id_projeto);
   			$this->updateParceiraProjeto($request, $id_projeto);
			$this->updateFinanciadorProjeto($request, $id_projeto);
			$this->updateFonteRecursosProjeto($request, $id_projeto);
			$this->updateTipoParceriaProjeto($request, $id_projeto);
			
   			$params = [$id_osc, $id_projeto, $tx_nome, $ft_nome, $cd_status, $ft_status, $dt_data_inicio, $ft_data_inicio,
   					$dt_data_fim, $ft_data_fim, $nr_valor_total, $ft_valor_total, $tx_link, $ft_link, $cd_abrangencia,
   					$ft_abrangencia, $tx_descricao, $ft_descricao, $nr_total_beneficiarios, $ft_total_beneficiarios,
   					$nr_valor_captado_projeto, $ft_valor_captado_projeto, $cd_zona_atuacao_projeto, $ft_zona_atuacao_projeto,
   					$tx_metodologia_monitoramento, $ft_metodologia_monitoramento, $tx_identificador_projeto_externo, $ft_identificador_projeto_externo];
   			$resultDao = $this->dao->updateProjeto($params);
   			$result = ['msg' => $resultDao->mensagem];
    	}
		
    	$this->configResponse($result);
    	return $this->response();
    }
    
    public function deleteProjeto(Request $request, $id_projeto, $id_osc)
    {
        $json = DB::select('SELECT * FROM  osc.tb_projeto WHERE id_projeto = ?::int AND id_osc = ?::int', [$id_projeto, $id_osc]);
    	
    	if(count($json) > 0){
	    	foreach($json as $key => $value){
	    		$bo_oficial = $json[$key]->bo_oficial;
	    		if(!$bo_oficial){
	    		    $this->logController->saveLog('osc.tb_projeto', $id_osc, $request->user()->id, json_encode($value), null);
	    			
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
	
    public function setPublicoBeneficiado(Request $request, $id_projeto, $id_osc)
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
			    	
			    	$tx_dado_posterior = '"tx_nome_publico_beneficiado": "' . $nome_publico_beneficiado. '",';
			    	$this->logController->saveLog('osc.tb_publico_beneficiado', $id_osc, $request->user()->id, null, $tx_dado_posterior);
			    	
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
    	$req = $request->publico_beneficiado;
    	
    	$query = 'SELECT * FROM osc.tb_publico_beneficiado_projeto a INNER JOIN osc.tb_publico_beneficiado b ON a.id_publico_beneficiado = b.id_publico_beneficiado WHERE a.id_projeto = ?::INTEGER;';
    	$db = DB::select($query, [$id_projeto]);
    	
    	$array_insert = array();
    	$array_delete = $db;
    	
    	if($req){
    		foreach($req as $key_req => $value_req){
    			$tx_nome_publico_beneficiado = $value_req['tx_nome_publico_beneficiado'];
    			
    			$params = [$id_projeto, $tx_nome_publico_beneficiado, $this->ft_representante, $this->ft_representante, false];
    			
    			$flag_insert = true;
    			foreach($db as $key_db => $value_db) {
    				if($value_db->tx_nome_publico_beneficiado == $tx_nome_publico_beneficiado){
    					$flag_insert = false;
    				}
    			}
    			
    			if($flag_insert){
    				array_push($array_insert, $params);
    			}
    			
    			foreach($array_delete as $key_del => $value_del) {
    				if($value_del->tx_nome_publico_beneficiado == $tx_nome_publico_beneficiado){
    					unset($array_delete[$key_del]);
    				}
    			}
    		}
    	}
    	
    	foreach($array_insert as $key => $value){
    		$this->dao->setPublicoBeneficiado($value);
    	}
    	
    	foreach($array_delete as $key => $value){
    		if(in_array($value->ft_publico_beneficiado_projeto, $this->fontesEditaveis)){
    			$params = [$value->id_publico_beneficiado];
    			$this->dao->deletePublicoBeneficiado($params);
    		}
    	}
    	
    	$result = ['msg' => 'Público beneficiado de projeto atualizado.'];
    	$this->configResponse($result, 200);
    	
    	return $this->response();
    }
	
    private function deletePublicoBeneficiado($id_projeto)
    {
    	$params = [$id_projeto];
    	
    	$resultDao = $this->dao->deletePublicoBeneficiado($params);
    	$result = ['msg' => 'Público beneficiado de projeto excluído.'];
		
    	$this->configResponse($result);
    	return $this->response();
    }
	
    public function setAreaAtuacaoProjeto(Request $request, $id_projeto, $id_osc)
    {
    	$req = $request->area_atuacao;
    	
    	if($req){
	    	foreach ($req as $key => $value){
	    		$cd_subarea_atuacao = $value['cd_area_atuacao_projeto'];
	    		$ft_area_atuacao_projeto = $this->ft_representante;
	    		$bo_oficial = false;
	    		
	    		$tx_dado_posterior = '"tx_nome_publico_beneficiado": "' . $tx_identificador_projeto_externo . '",';
	    		$this->logController->saveLog('osc.tb_publico_beneficiado_projeto', $id_osc, $request->user()->id, null, $tx_dado_posterior);
	    		
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
		
    	foreach($array_delete as $key => $value){
    		if(in_array($value->ft_area_atuacao, $this->fontesEditaveis)){
    			$this->deleteAreaAtuacaoProjeto($value->id_area_atuacao_projeto);
    		}
    	}
		
    	$result = ['msg' => 'Área de atuação de projeto atualizada.'];
    	$this->configResponse($result, 200);
		
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
		    	
		    	$tx_dado_posterior = '"tx_nome_area_atuacao_outra_projeto": "' . $tx_nome_area_atuacao_outra_projeto. '",';
		    	$this->logController->saveLog('osc.tb_area_atuacao_declarada', $id_osc, $request->user()->id, null, $tx_dado_posterior);
		    	
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
	
    public function setLocalizacaoProjeto(Request $request, $id_projeto, $id_osc)
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
				
		    	$tx_dado_posterior = '"id_regiao_localizacao_projeto": "' . $id_regiao_localizacao_projeto. '",';
		    	$tx_dado_posterior = $tx_dado_posterior . '"tx_nome_regiao_localizacao_projeto": "' . $tx_nome_regiao_localizacao_projeto. '",';
		    	$this->logController->saveLog('osc.tb_localizacao_projeto', $id_osc, $request->user()->id, null, $tx_dado_posterior);
		    	
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
		    		if(isset($value_req['id_regiao_localizacao_projeto'])){
		    			$id_regiao_localizacao_projeto = $value_req['id_regiao_localizacao_projeto'];
		    		}
		    		$ft_regiao_localizacao_projeto = $this->ft_representante;
					
		    		if(isset($value_req['tx_nome_regiao_localizacao_projeto'])){
		    			$tx_nome_regiao_localizacao_projeto = $value_req['tx_nome_regiao_localizacao_projeto'];
		    		}
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
		
    	foreach($array_delete as $key => $value){
    		if(in_array($value->ft_nome_regiao_localizacao_projeto, $this->fontesEditaveis)){
    			$this->deleteLocalizacaoProjeto($value->id_localizacao_projeto);
    		}
    	}
		
    	$result = ['msg' => 'Localização do projeto atualizado.'];
    	$this->configResponse($result, 200);
		
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
	
    public function setObjetivoProjeto(Request $request, $id_projeto, $id_osc)
    {
		$req = $request->objetivo_meta;
		
		if($req){
			foreach ($req as $key => $value){
				if(isset($value['cd_meta_projeto'])){
					$cd_meta_projeto = $value['cd_meta_projeto'];
			    	$ft_objetivo_projeto = $this->ft_representante;
			    	$bo_oficial = false;
					
			    	if($cd_meta_projeto){
			    		$tx_dado_posterior = '"cd_meta_projeto": "' . $cd_meta_projeto. '",';
			    		$this->logController->saveLog('osc.tb_objetivo_projeto', $id_osc, $request->user()->id, null, $tx_dado_posterior);
			    		
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
		
    	foreach($array_delete as $key => $value){
    		if(in_array($value->ft_objetivo_projeto, $this->fontesEditaveis)){
    			$this->deleteObjetivoProjeto($value->id_objetivo_projeto);
    		}
    	}
		
    	$result = ['msg' => 'Objetivos de projeto atualizado.'];
    	$this->configResponse($result, 200);
		
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
	
    public function setParceiraProjeto(Request $request, $id_projeto, $id_osc)
    {
    	$req = $request->osc_parceira;
		
    	foreach ($req as $key => $value){
		    $id_osc = $value['id_osc'];
		    $ft_osc_parceira_projeto = $this->ft_representante;
		    $bo_oficial = false;
		    
		    $tx_dado_posterior = '"id_osc": "' . $id_osc . '",';
		    $this->logController->saveLog('osc.tb_osc_parceira_projeto', $id_osc, $request->user()->id, null, $tx_dado_posterior);
		    
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
		
    	foreach($array_delete as $key => $value){
    		if(in_array($value->ft_osc_parceira_projeto, $this->fontesEditaveis)){
    			$this->dao->deleteParceiraProjeto($value->id_osc, $value->id_projeto);
    		}
    	}
		
    	$result = ['msg' => 'OSC parceira de projeto atualizados.'];
    	$this->configResponse($result, 200);
		
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
	
    public function setFinanciadorProjeto(Request $request, $id_projeto, $id_osc)
	{
		$req = $request->input('financiador_projeto');
		
		if($req){
			foreach($req as $key => $value){
				$tx_nome_financiador = null;
				if(isset($value['tx_nome_financiador'])) $tx_nome_financiador = $value['tx_nome_financiador'];
				$ft_nome_financiador = $this->ft_representante;
				
				$bo_oficial = false;
				
				$tx_dado_posterior = '"tx_nome_financiador": "' . $tx_nome_financiador. '",';
				$this->logController->saveLog('osc.tb_financiador_projeto', $id_osc, $request->user()->id, null, $tx_dado_posterior);
				
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
		
		foreach($array_delete as $key => $value){
			if(in_array($value->ft_nome_financiador, $this->fontesEditaveis)){
				$this->deleteFinanciadorProjeto($value->id_financiador_projeto);
			}
		}
		
		foreach($array_insert as $key => $value){
			$this->dao->insertFinanciadorProjeto($value);
		}
		
		$result = ['msg' => 'Financiador do projeto atualizado.'];
		$this->configResponse($result, 200);
		
		return $this->response();
	}
	
	private function deleteFinanciadorProjeto($id_localizacao)
	{
		$params = [$id_localizacao];
		$resultDao = $this->dao->deleteFinanciadoresProjeto($params);
		$result = ['msg' => 'Financiador do projeto excluído.'];
		
		$this->configResponse($result);
		return $this->response();
	}
	
	public function setFonteRecursosProjeto(Request $request, $id_projeto, $id_osc)
    {
    	$req = $request->fonte_recursos;
    	
    	if($req){
	    	foreach ($req as $key => $value){
	    		$cd_origem_fonte_recursos_projeto = $value['cd_origem_fonte_recursos_projeto'];
	    		$ft_fonte_recursos_projeto = $this->ft_representante;
	    		$bo_oficial = false;
	    		
	    		$tx_dado_posterior = '"cd_origem_fonte_recursos_projeto": "' . $cd_origem_fonte_recursos_projeto. '",';
	    		$this->logController->saveLog('osc.tb_fonte_recursos_projeto', $id_osc, $request->user()->id, null, $tx_dado_posterior);
	    		
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
		
    	foreach($array_insert as $key => $value){
    		$this->dao->insertFonteRecursosProjeto($value);
    	}
		
    	foreach($array_delete as $key => $value){
    		if(in_array($value->ft_fonte_recursos_projeto, $this->fontesEditaveis)){
    			$this->deleteFonteRecursosProjeto($value->id_fonte_recursos_projeto, $request->user()->id);
    		}
    	}
		
    	$result = ['msg' => 'Fonte de recursos de projeto atualizada.'];
    	$this->configResponse($result, 200);
		
    	return $this->response();
    }
	
    private function deleteFonteRecursosProjeto($id_fonte_recursos_projeto, $id_usuario)
    {
    	$params = [$id_fonte_recursos_projeto];
    	$json = DB::select('SELECT * FROM osc.tb_fonte_recursos_projeto WHERE id_fonte_recursos_projeto = ?::int', $params);
    	
    	$tx_dado_posterior = '';
    	foreach($json as $key => $value){
    		$tx_dado_anterior = json_encode($value);
    		
	    	$resultDao = $this->dao->deleteFonteRecursosProjeto($params);
	    	$this->logController->saveLog('osc.tb_fonte_recursos_projeto', $id_fonte_recursos_projeto, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    	}
    	
    	$result = ['msg' => 'Fonte de recursos de projeto excluída.'];
    	$this->configResponse($result);
    	return $this->response();
    }
    
    public function setTipoParceriaProjeto(Request $request, $id_projeto, $id_osc)
    {
    	$req = $request->tipo_parceria;
		
    	if($req){
	    	$query = 'SELECT id_fonte_recursos_projeto FROM osc.tb_fonte_recursos_projeto WHERE id_projeto = ?::INTEGER AND cd_origem_fonte_recursos_projeto = 1;';
	    	$db = DB::select($query, [$id_projeto]);
	    	
	    	$fonte_recurso = null;
	    	foreach($db as $value){
	    		$fonte_recurso = $value->id_fonte_recursos_projeto;
	    	}
	    	
	    	if($fonte_recurso){
	    		foreach ($req as $key => $value){
	    			$cd_tipo_parceria_projeto = $value['cd_tipo_parceria_projeto'];
	    			$ft_tipo_parceria_projeto = $this->ft_representante;
	    			
	    			$tx_dado_posterior = '"cd_tipo_parceria_projeto": "' . $cd_tipo_parceria_projeto. '",';
	    			$this->logController->saveLog('osc.tb_tipo_parceria_projeto', $id_osc, $request->user()->id, null, $tx_dado_posterior);
	    	   		
	    			$params = [$id_projeto, $fonte_recurso, $cd_tipo_parceria_projeto, $ft_tipo_parceria_projeto];
	    			
	    			$this->dao->insertTipoParceriaProjeto($params);
	    		}
	    	}else{
	    		$result = ['msg' => 'Para adicionar tipo de parceria é necessário adicionar a fonte de recursos público ao projeto.'];
	    		$this->configResponse($result, 400);
	    	}
    	}
    }
    
    public function updateTipoParceriaProjeto(Request $request, $id_projeto)
    {
    	$req = $request->tipo_parceria;
		
    	$query = 'SELECT * FROM osc.tb_tipo_parceria_projeto WHERE id_projeto = ?::INTEGER;';
    	$db = DB::select($query, [$id_projeto]);
		
    	$array_insert = array();
    	$array_delete = $db;
    	
    	if($req){
	    	$query = 'SELECT id_fonte_recursos_projeto FROM osc.tb_fonte_recursos_projeto WHERE id_projeto = ?::INTEGER AND cd_origem_fonte_recursos_projeto = 1;';
	    	$db_id_fonte_recursos = DB::select($query, [$id_projeto]);
	    	
	    	$fonte_recurso = null;
	    	foreach($db_id_fonte_recursos as $value){
	    		$fonte_recurso = $value->id_fonte_recursos_projeto;
	    	}
	    	
	    	if($fonte_recurso){
	    		foreach($req as $key_req => $value_req){
	    			$cd_tipo_parceria_projeto = $value_req['cd_tipo_parceria_projeto'];
	    	   		
	    			$params = [$id_projeto, $fonte_recurso, $cd_tipo_parceria_projeto, $this->ft_representante];
	    			
	    			$flag_insert = true;
	    			foreach ($db as $key_db => $value_db) {
	    				if($value_db->cd_tipo_parceria_projeto == $cd_tipo_parceria_projeto){
	    					$flag_insert = false;
	    				}
	    			}
	    			
	    			if($flag_insert){
	    				array_push($array_insert, $params);
	    			}
	    			
	    			foreach ($array_delete as $key_del => $value_del) {
	    				if($value_del->cd_tipo_parceria_projeto == $cd_tipo_parceria_projeto){
	    					unset($array_delete[$key_del]);
	    				}
	    			}
	    		}
	    	}else{
	    		$result = ['msg' => 'Para adicionar tipo de parceria é necessário adicionar a fonte de recursos público ao projeto.'];
	    		$this->configResponse($result, 400);
	    	}
    	}
    	
    	foreach($array_insert as $key => $value){
    		$this->dao->insertTipoParceriaProjeto($value);
    	}
    	
    	foreach($array_delete as $key => $value){
    		if(in_array($value->ft_tipo_parceria_projeto, $this->fontesEditaveis)){
    			$this->deleteTipoParceriaProjeto($value->id_tipo_parceria_projeto, $request->user()->id);
    		}
    	}
    	
    	$result = ['msg' => 'Tipo de parceria de projeto atualizada.'];
    	$this->configResponse($result, 200);
    	
    	return $this->response();
    }
    
    private function deleteTipoParceriaProjeto($id_tipo_parceria_projeto, $id_usuario)
    {
    	$params = [$id_tipo_parceria_projeto];
    	$json = DB::select('SELECT * FROM osc.tb_tipo_parceria_projeto WHERE id_tipo_parceria_projeto = ?::int', $params);
    	
    	$tx_dado_posterior = '';
    	foreach($json as $key => $value){
    		$tx_dado_anterior = json_encode($value);
    		
    		$resultDao = $this->dao->deleteTipoParceriaProjeto($params);
    		$this->logController->saveLog('osc.tb_fonte_recursos_projeto', $id_tipo_parceria_projeto, $id_usuario, $tx_dado_anterior, $tx_dado_posterior);
    	}
    	
    	$result = ['msg' => 'Tipo de parceria de projeto excluída.'];
    	$this->configResponse($result);
    	return $this->response();
    }
    
    public function editarRecursosOsc(Request $request, $id_osc, EditarFonteRecursosOscService $service)
    {
    	$extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
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
    
    public function obterListaOscsAtualizadas(Request $request, $limit = 10, ObterListaOscsAtualizadasService $service)
    {
        $extensaoConteudo = ['limit' => $limit];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterListaOscsAreaAtuacao(Request $request, $cd_area_atuacao, $limit = 5, ObterListaOscsAreaAtuacaoService $service)
    {
        $extensaoConteudo = ['cd_area_atuacao' => $cd_area_atuacao, 'limit' => $limit];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterListaOscsAreaAtuacaoMunicipio(Request $request, $cd_area_atuacao, $cd_municipio, $limit = 5, ObterListaOscsAreaAtuacaoService $service)
    {
        $extensaoConteudo = ['cd_area_atuacao' => $cd_area_atuacao, 'cd_municipio' => $cd_municipio, 'limit' => $limit];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterListaOscsAreaAtuacaoGeolocalizacao(Request $request, $cd_area_atuacao, $latitude, $longitude, $limit = 5, ObterListaOscsAreaAtuacaoService $service)
    {
        $extensaoConteudo = ['cd_area_atuacao' => $cd_area_atuacao, 'latitude' => $latitude, 'longitude' => $longitude, 'limit' => $limit];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function obterDataAtualizacao(Request $request, $id_osc, ObterDataAtualizacaoService $service)
    {
        $extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
}