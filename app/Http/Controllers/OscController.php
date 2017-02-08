<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Dao\OscDao;
use App\Dao\LogDao;
use Illuminate\Http\Request;
use DB;

class OscController extends Controller
{
	private $dao;
    private $log;
	private $ft_representante;

	public function __construct()
	{
		$this->dao = new OscDao();
		$this->ft_representante = 'Representante';
		$this->log = new LogDao();
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

    public function updateLogo(Request $request, $id)
	{
        $id_usuario = $request->user()->id;

    	$image_text = $request->getContent();

    	$params = [$id, $image_text];
    	$resultDao = $this->dao->updateLogo($params);

        $tx_nome_campo = 'im_logo';
        $id_tabela = $json[$key]->id_osc;
        $tx_dado_anterior = $json[$key]->tx_nome_fantasia_osc;
        $tx_dado_posterior = $nome_fantasia;
        $resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);

    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

	public function updateDadosGerais(Request $request, $id)
    {
        $id_usuario = $request->user()->id;

    	$json = DB::select('SELECT * FROM osc.tb_dados_gerais WHERE id_osc = ?::int',[$id]);

    	$osc_exist = false;
    	if($json){
    		$osc_exist = true;
    	}

    	foreach($json as $key => $value){
	    	$nome_fantasia = $request->input('tx_nome_fantasia_osc');
			if($json[$key]->tx_nome_fantasia_osc != $nome_fantasia){
				$ft_nome_fantasia = $this->ft_representante;

                $tx_nome_campo = 'tx_nome_fantasia_osc';
				$id_tabela = $json[$key]->id_osc;
                $tx_dado_anterior = $json[$key]->tx_nome_fantasia_osc;
                $tx_dado_posterior = $nome_fantasia;
				$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
			}
			else $ft_nome_fantasia = $request->input('ft_nome_fantasia_osc');

	    	$sigla = $request->input('tx_sigla_osc');
			if($json[$key]->tx_sigla_osc != $sigla){
                $ft_sigla = $this->ft_representante;

                $tx_nome_campo = 'tx_sigla_osc';
                $id_tabela = $json[$key]->id_osc;
                $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                $tx_dado_posterior = $sigla;
				$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
            }
			else $ft_sigla = $request->input('ft_sigla_osc');

			$this->updateApelido($request, $id);

			$cd_situacao_imovel = $request->input('cd_situacao_imovel_osc');
			if($json[$key]->cd_situacao_imovel_osc != $cd_situacao_imovel){
                $ft_situacao_imovel = $this->ft_representante;

                $tx_nome_campo = 'cd_situacao_imovel_osc';
                $id_tabela = $json[$key]->id_osc;
                $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                $tx_dado_posterior = $sigla;
				$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
            }
			else $ft_situacao_imovel = $request->input('ft_situacao_imovel_osc');

			$nome_responsavel_legal = $request->input('tx_nome_responsavel_legal');
			if($json[$key]->tx_nome_responsavel_legal != $nome_responsavel_legal){
                $ft_nome_responsavel_legal = $this->ft_representante;

                $tx_nome_campo = 'tx_nome_responsavel_legal';
                $id_tabela = $json[$key]->id_osc;
                $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                $tx_dado_posterior = $sigla;
				$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
            }
			else $ft_nome_responsavel_legal = $request->input('ft_nome_responsavel_legal');

			$ano_cadastro_cnpj = $request->input('dt_ano_cadastro_cnpj');
			if(strlen($ano_cadastro_cnpj) > 4){
				if($json[$key]->dt_ano_cadastro_cnpj != $ano_cadastro_cnpj){
                    $ft_ano_cadastro_cnpj = $this->ft_representante;

                    $tx_nome_campo = 'dt_ano_cadastro_cnpj';
                    $id_tabela = $json[$key]->id_osc;
                    $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                    $tx_dado_posterior = $sigla;
    				$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
                }
				else $ft_ano_cadastro_cnpj = $request->input('ft_ano_cadastro_cnpj');
			}
			else{
				$ano_cadastro_cnpj = '01-01-'.$ano_cadastro_cnpj;
				if(substr($json[$key]->dt_ano_cadastro_cnpj, -4) != $ano_cadastro_cnpj){
                    $ft_ano_cadastro_cnpj = $this->ft_representante;

                    $tx_nome_campo = 'dt_ano_cadastro_cnpj';
                    $id_tabela = $json[$key]->id_osc;
                    $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                    $tx_dado_posterior = $sigla;
    				$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
                }
				else $ft_ano_cadastro_cnpj = $request->input('ft_ano_cadastro_cnpj');
			}

			$dt_fundacao = $request->input('dt_fundacao_osc');
			if(strlen($dt_fundacao) > 4){
				if($json[$key]->dt_fundacao_osc != $dt_fundacao){
                    $ft_fundacao = $this->ft_representante;

                    $tx_nome_campo = 'dt_fundacao_osc';
                    $id_tabela = $json[$key]->id_osc;
                    $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                    $tx_dado_posterior = $sigla;
    				$resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
                }
				else $ft_fundacao = $request->input('ft_fundacao_osc');
			}
			else{
				$dt_fundacao = '01-01-'.$dt_fundacao;
				if(substr($json[$key]->dt_fundacao_osc, -4) != $dt_fundacao){
                    $ft_fundacao = $this->ft_representante;

                    $tx_nome_campo = 'dt_fundacao_osc';
                    $id_tabela = $json[$key]->id_osc;
                    $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                    $tx_dado_posterior = $sigla;
                    $resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
                }
				else $ft_fundacao = $request->input('ft_fundacao_osc');
			}

	    	$this->contatos($request, $id);

			$resumo = $request->input('tx_resumo_osc');
			if($json[$key]->tx_resumo_osc != $resumo){
                $ft_resumo = $this->ft_representante;

                $tx_nome_campo = 'tx_resumo_osc';
                $id_tabela = $json[$key]->id_osc;
                $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                $tx_dado_posterior = $sigla;
                $resultDaoLog = $this->log->insertLogDadosGerais($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
            }
			else $ft_resumo = $request->input('ft_resumo_osc');
    	}

    	if($osc_exist){
	    	$params = [$id, $nome_fantasia, $ft_nome_fantasia, $sigla, $ft_sigla, $cd_situacao_imovel, $ft_situacao_imovel, $nome_responsavel_legal, $ft_nome_responsavel_legal, $ano_cadastro_cnpj, $ft_ano_cadastro_cnpj, $dt_fundacao, $ft_fundacao, $resumo, $ft_resumo];
	    	$resultDao = $this->dao->updateDadosGerais($params);

	    	$result = ['msg' => $resultDao->mensagem];
    		$this->configResponse($result);
    	}else{
    		$result = ['msg' => 'Não existe OSC com este ID.'];
    		$this->configResponse($result, 400);
    	}

    	return $this->response();
    }

    public function updateApelido(Request $request, $id)
    {
        $id_usuario = $request->user()->id;

    	$json = DB::select('SELECT * FROM osc.tb_osc WHERE id_osc = ?::int',[$id]);
    	foreach($json as $key => $value){
    		$apelido = $request->input('tx_apelido_osc');
    		if($json[$key]->tx_apelido_osc != $apelido){
                $ft_apelido_osc = $this->ft_representante;

                $tx_nome_campo = 'tx_apelido_osc';
                $id_tabela = $json[$key]->id_osc;
                $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                $tx_dado_posterior = $sigla;
				$resultDaoLog = $this->log->insertLogOsc($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
            }
    		else $ft_apelido_osc = $request->input('ft_apelido_osc');
    	}

    	$params = [$id, $apelido, $ft_apelido_osc];
    	$result = $this->dao->updateApelido($params);
    }

	public function contatos(Request $request, $id)
	{
		$result = DB::select('SELECT * FROM osc.tb_contato WHERE id_osc = ?::int',[$id]);
		if($result != null)
			$this->updateContatos($request, $id);
		else
			$this->setContatos($request, $id);
	}

	public function setContatos(Request $request, $id)
	{
        $id_usuario = $request->user()->id;

		$telefone = $request->input('tx_telefone');
		if($telefone != null){
            $ft_telefone = $this->ft_representante;

            $tx_nome_campo = 'tx_telefone';
            $id_tabela = $json[$key]->id_osc;
            $tx_dado_anterior = $json[$key]->tx_sigla_osc;
            $tx_dado_posterior = $sigla;
            $resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
        }
		else $ft_telefone = $request->input('ft_telefone');

    	$email = $request->input('tx_email');
		if($email != null){
            $ft_email = $this->ft_representante;

            $tx_nome_campo = 'tx_email';
            $id_tabela = $json[$key]->id_osc;
            $tx_dado_anterior = $json[$key]->tx_sigla_osc;
            $tx_dado_posterior = $sigla;
            $resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
        }
		else $ft_email = $request->input('ft_email');

    	$site = $request->input('tx_site');
		if($site != null){
            $ft_site = $this->ft_representante;

            $tx_nome_campo = 'tx_site';
            $id_tabela = $json[$key]->id_osc;
            $tx_dado_anterior = $json[$key]->tx_sigla_osc;
            $tx_dado_posterior = $sigla;
            $resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
        }
		else $ft_site = $request->input('ft_site');

		$params = [$id, $telefone, $ft_telefone, $email, $ft_email, $site, $ft_site];
		$result = $this->dao->setContatos($params);
	}

    public function updateContatos(Request $request, $id)
    {
        $id_usuario = $request->user()->id;

		$json = DB::select('SELECT * FROM osc.tb_contato WHERE id_osc = ?::int',[$id]);
		foreach($json as $key => $value){
	    	$telefone = $request->input('tx_telefone');
			if($json[$key]->tx_telefone != $telefone){
                $ft_telefone = $this->ft_representante;

                $tx_nome_campo = 'tx_telefone';
                $id_tabela = $json[$key]->id_osc;
                $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                $tx_dado_posterior = $sigla;
                $resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
            }
			else $ft_telefone = $request->input('ft_telefone');

	    	$email = $request->input('tx_email');
			if($json[$key]->tx_email != $email){
                $ft_email = $this->ft_representante;

                $tx_nome_campo = 'tx_email';
                $id_tabela = $json[$key]->id_osc;
                $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                $tx_dado_posterior = $sigla;
                $resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
            }
			else $ft_email = $request->input('ft_email');

	    	$site = $request->input('tx_site');
			if($json[$key]->tx_site != $site){
                $ft_site = $this->ft_representante;

                $tx_nome_campo = 'tx_site';
                $id_tabela = $json[$key]->id_osc;
                $tx_dado_anterior = $json[$key]->tx_sigla_osc;
                $tx_dado_posterior = $sigla;
                $resultDaoLog = $this->log->insertLogContato($tx_nome_campo, $id_usuario, $id_tabela, $tx_dado_anterior, $tx_dado_posterior);
            }
			else $ft_site = $request->input('ft_site');
		}

		$params = [$id, $telefone, $ft_telefone, $email, $ft_email, $site, $ft_site];
		$result = $this->dao->updateContatos($params);
    }

    public function setAreaAtuacao(Request $request, $id_osc)
    {
    	$area_atuacao_req = $request->area_atuacao;

		$query = "SELECT cd_area_atuacao, cd_subarea_atuacao, bo_oficial FROM osc.tb_area_atuacao WHERE id_osc = ?::INTEGER;";
		$area_atuacao_osc = DB::select($query, [$id_osc]);

		$array_insert = array();
		$array_delete = $area_atuacao_osc;

    	foreach($area_atuacao_req as $key_area => $value_area){
			$cd_area_atuacao = $value_area['cd_area_atuacao'];

            $cd_subarea_atuacao = null;
			if($value_area['subarea_atuacao']){
    			foreach($value_area['subarea_atuacao'] as $key_subarea => $value_subarea){
    				$cd_subarea_atuacao = $value_subarea['cd_subarea_atuacao'];
					$params = ["cd_area_atuacao" => $cd_area_atuacao, "cd_subarea_atuacao"=>$cd_subarea_atuacao];

					$flag = true;
					foreach ($area_atuacao_osc as $key_area_osc => $value_area_osc) {
						if($value_area_osc->cd_area_atuacao == $cd_area_atuacao && $value_area_osc->cd_subarea_atuacao == $cd_subarea_atuacao){
							$flag = false;
						}
					}

					if($flag){
						array_push($array_insert, $params);
					}

					foreach ($array_delete as $key_area_del => $value_area_del) {
						if($value_area_del->cd_area_atuacao == $cd_area_atuacao && $value_area_del->cd_subarea_atuacao == $cd_subarea_atuacao){
							unset($array_delete[$key_area_del]);
						}
					}
    			}
			}
			else{
				$params = ["cd_area_atuacao"=>$cd_area_atuacao, "cd_subarea_atuacao"=>null];

				$flag = true;
				foreach ($area_atuacao_osc as $key_area_osc => $value_area_osc) {
					if($value_area_osc->cd_area_atuacao == $cd_area_atuacao && $value_area_osc->cd_subarea_atuacao == null){
						$flag = false;
					}
				}

				if($flag){
					array_push($array_insert, $params);
				}

				foreach ($array_delete as $key_area_del => $value_area_del) {
					if($value_area_del->cd_area_atuacao == $cd_area_atuacao && $value_area_del->cd_subarea_atuacao == $cd_subarea_atuacao){
						unset($array_delete[$key_area_del]);
					}
				}
			}
		}

		$flag_error_delete = false;
		foreach($array_delete as $key => $value){
			if($value->bo_oficial){
				$flag_error_delete = true;
				break;
			}
			else{
				$this->deleteAreaAtuacao($value, $id_osc);
			}
		}

		if($flag_error_delete){
			$result = ['msg' => 'Dado Oficial, não pode ser modificado.'];
			$this->configResponse($result, 400);
		}
		else{
			foreach($array_insert as $key => $value){
				$this->insertAreaAtuacao($value, $id_osc);
			}

			$result = ['msg' => 'Área de atuação atualizada.'];
			$this->configResponse($result, 200);
		}

		return $this->response();
    }

    private function insertAreaAtuacao($params, $id_osc)
    {
    	$cd_area_atuacao = $params['cd_area_atuacao'];
    	$cd_subarea_atuacao = $params['cd_subarea_atuacao'];
    	$bo_oficial = false;

    	$params = [$id_osc, $cd_area_atuacao, $this->ft_representante, $cd_subarea_atuacao, $bo_oficial];
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
	    	if($json[$key]->tx_historico != $historico) $ft_historico = $this->ft_representante;
	    	else $ft_historico = $request->input('ft_historico');

	    	$missao = $request->input('tx_missao_osc');
	    	if($json[$key]->tx_missao_osc != $missao) $ft_missao = $this->ft_representante;
	    	else $ft_missao = $request->input('ft_missao_osc');

	    	$visao = $request->input('tx_visao_osc');
	    	if($json[$key]->tx_visao_osc != $visao) $ft_visao = $this->ft_representante;
	    	else $ft_visao = $request->input('ft_visao_osc');

	    	$finalidades_estatutarias = $request->input('tx_finalidades_estatutarias');
	    	if($json[$key]->tx_finalidades_estatutarias != $finalidades_estatutarias) $ft_finalidades_estatutarias = $this->ft_representante;
	    	else $ft_finalidades_estatutarias = $request->input('ft_finalidades_estatutarias');

	    	$link_estatuto = $request->input('tx_link_estatuto_osc');
	    	if($json[$key]->tx_link_estatuto_osc != $link_estatuto) $ft_link_estatuto = $this->ft_representante;
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



		$flag_error_delete = false;
		foreach($array_delete as $key => $value){
			if($value->bo_oficial){
				$flag_error_delete = true;
				break;
			}
			else{
				$this->deleteCertificado($value, $id_osc);
			}
		}

		if($flag_error_delete){
			$result = ['msg' => 'Dado Oficial, não pode ser modificado.'];
			$this->configResponse($result, 400);
		}
		else{
			foreach($array_insert as $key => $value){
				$this->insertCertificado($value, $id_osc);
			}

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
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
	    		$cargo = $request->input('tx_cargo_dirigente');
	    		if($json[$key]->tx_cargo_dirigente != $cargo) $fonte_cargo = $this->ft_representante;
	    		else $fonte_cargo = $request->input('ft_cargo_dirigente');

	    		$nome = $request->input('tx_nome_dirigente');
	    		if($json[$key]->tx_nome_dirigente != $nome) $fonte_nome = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
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
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
    			$nome = $request->input('tx_nome_conselheiro');
    			if($json[$key]->tx_nome_conselheiro != $nome) $fonte_nome = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
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
	    	if($json[$key]->nr_trabalhadores_voluntarios != $nr_trabalhadores_voluntarios) $ft_trabalhadores_voluntarios = $this->ft_representante;
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
    		if($json[$key]->nr_trabalhadores != $nr_trabalhadores) $ft_trabalhadores = $this->ft_representante;
    		else $ft_trabalhadores = $request->input('ft_trabalhadores');
    	}

    	$params = [$id, $nr_trabalhadores, $ft_trabalhadores];
    	$resultDao = $this->dao->updateOutrosTrabalhadores($params);
    	$result = ['msg' => $resultDao->mensagem];
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setParticipacaoSocialConselho(Request $request)
    {
    	$id = $request->input('id_osc');
    	$cd_conselho = $request->input('cd_conselho');
    	if($cd_conselho != null) $ft_conselho = $this->ft_representante;
    	else $ft_conselho = $request->input('ft_conselho');

    	$cd_tipo_participacao = $request->input('cd_tipo_participacao');
    	if($cd_tipo_participacao != null) $ft_tipo_participacao = $this->ft_representante;
    	else $ft_tipo_participacao = $request->input('ft_tipo_participacao');

    	$tx_periodicidade_reuniao = $request->input('tx_periodicidade_reuniao');
    	if($tx_periodicidade_reuniao != null) $ft_periodicidade_reuniao = $this->ft_representante;
    	else $ft_periodicidade_reuniao = $request->input('ft_periodicidade_reuniao');

    	$dt_inicio_conselho = $request->input('dt_data_inicio_conselho');
    	if($dt_inicio_conselho != null) $ft_dt_inicio_conselho = $this->ft_representante;
    	else $ft_dt_inicio_conselho = $request->input('ft_data_inicio_conselho');

    	$dt_fim_conselho = $request->input('dt_data_fim_conselho');
    	if($dt_fim_conselho != null) $ft_dt_fim_conselho = $this->ft_representante;
    	else $ft_dt_fim_conselho = $request->input('ft_data_fim_conselho');

    	$bo_oficial = false;

    	$params = [$id, $cd_conselho, $ft_conselho, $cd_tipo_participacao, $ft_tipo_participacao, $tx_periodicidade_reuniao, $ft_periodicidade_reuniao, $dt_inicio_conselho, $ft_dt_inicio_conselho, $dt_fim_conselho, $ft_dt_fim_conselho, $bo_oficial];
    	$result = $this->dao->setParticipacaoSocialConselho($params);
    }

    public function updateParticipacaoSocialConselho(Request $request, $id)
    {
    	$id_conselho = $request->input('id_conselho');
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conselho WHERE id_conselho = ?::int',[$id_conselho]);

    	foreach($json as $key => $value){
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
    			$cd_conselho = $request->input('cd_conselho');
    			if($json[$key]->cd_conselho != $cd_conselho) $ft_conselho = $this->ft_representante;
    			else $ft_conselho = $request->input('ft_conselho');

    			$cd_tipo_participacao = $request->input('cd_tipo_participacao');
    			if($json[$key]->cd_tipo_participacao != $cd_tipo_participacao) $ft_tipo_participacao = $this->ft_representante;
    			else $ft_tipo_participacao = $request->input('ft_tipo_participacao');

    			$tx_periodicidade_reuniao = $request->input('tx_periodicidade_reuniao');
    			if($json[$key]->tx_periodicidade_reuniao != $tx_periodicidade_reuniao) $ft_periodicidade_reuniao = $this->ft_representante;
    			else $ft_periodicidade_reuniao = $request->input('ft_periodicidade_reuniao');

    			$dt_inicio_conselho = $request->input('dt_data_inicio_conselho');
    			if($json[$key]->dt_data_inicio_conselho != $dt_inicio_conselho) $ft_dt_inicio_conselho = $this->ft_representante;
    			else $ft_dt_inicio_conselho = $request->input('ft_data_inicio_conselho');

    			$dt_fim_conselho = $request->input('dt_data_fim_conselho');
    			if($json[$key]->dt_data_fim_conselho != $dt_fim_conselho) $ft_dt_fim_conselho = $this->ft_representante;
    			else $ft_dt_fim_conselho = $request->input('ft_data_fim_conselho');

    			$params = [$id, $id_conselho, $cd_conselho, $ft_conselho, $cd_tipo_participacao, $ft_tipo_participacao, $tx_periodicidade_reuniao, $ft_periodicidade_reuniao, $dt_inicio_conselho, $ft_dt_inicio_conselho, $dt_fim_conselho, $ft_dt_fim_conselho];
    			$resultDao = $this->dao->updateParticipacaoSocialConselho($params);
    			$result = ['msg' => $resultDao->mensagem];

    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function deleteParticipacaoSocialConselho($id_conselho, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conselho WHERE id_conselho = ?::int',[$id_conselho]);

    	foreach($json as $key => $value){
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_conselho];
    			$resultDao = $this->dao->deleteParticipacaoSocialConselho($params);
    			$result = ['msg' => 'Participacao Social Conselho excluida'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function setParticipacaoSocialConferencia(Request $request)
    {
    	$id = $request->input('id_osc');
    	$cd_conferencia = $request->input('cd_conferencia');
    	if($cd_conferencia != null) $ft_conferencia = $this->ft_representante;
    	else $ft_conferencia = $request->input('ft_conferencia');

    	$dt_ano_realizacao = $request->input('dt_ano_realizacao');
    	if($dt_ano_realizacao != null) $ft_ano_realizacao = $this->ft_representante;
    	else $ft_ano_realizacao = $request->input('ft_ano_realizacao');

    	$cd_forma_participacao_conferencia = $request->input('cd_forma_participacao_conferencia');
    	if($cd_forma_participacao_conferencia != null) $ft_forma_participacao_conferencia = $this->ft_representante;
    	else $ft_forma_participacao_conferencia = $request->input('ft_forma_participacao_conferencia');

    	$bo_oficial = false;

    	$params = [$id, $cd_conferencia, $ft_conferencia, $dt_ano_realizacao, $ft_ano_realizacao, $cd_forma_participacao_conferencia, $ft_forma_participacao_conferencia, $bo_oficial];
    	$result = $this->dao->setParticipacaoSocialConferencia($params);
    }

    public function updateParticipacaoSocialConferencia(Request $request, $id)
    {
    	$id_conferencia = $request->input('id_conferencia');
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia WHERE id_conferencia = ?::int',[$id_conferencia]);

    	foreach($json as $key => $value){
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
    			$cd_conferencia = $request->input('cd_conferencia');
    			if($json[$key]->cd_conferencia != $cd_conferencia) $ft_conferencia = $this->ft_representante;
    			else $ft_conferencia = $request->input('ft_conferencia');

    			$dt_ano_realizacao = $request->input('dt_ano_realizacao');
    			if($json[$key]->dt_ano_realizacao != $dt_ano_realizacao) $ft_ano_realizacao = $this->ft_representante;
    			else $ft_ano_realizacao = $request->input('ft_ano_realizacao');

    			$cd_forma_participacao_conferencia = $request->input('cd_forma_participacao_conferencia');
    			if($json[$key]->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia) $ft_forma_participacao_conferencia = $this->ft_representante;
    			else $ft_forma_participacao_conferencia = $request->input('ft_forma_participacao_conferencia');

    			$params = [$id, $id_conferencia, $cd_conferencia, $ft_conferencia, $dt_ano_realizacao, $ft_ano_realizacao, $cd_forma_participacao_conferencia, $ft_forma_participacao_conferencia];
    			$resultDao = $this->dao->updateParticipacaoSocialConferencia($params);
    			$result = ['msg' => $resultDao->mensagem];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser modificado'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
    }

    public function deleteParticipacaoSocialConferencia($id_conferencia, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia WHERE id_conferencia = ?::int',[$id_conferencia]);

    	foreach($json as $key => $value){
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
    			$params = [$id_conferencia];
    			$resultDao = $this->dao->deleteParticipacaoSocialConferencia($params);
    			$result = ['msg' => 'Participacao Social Conferencia excluida'];
    		}else{
    			$result = ['msg' => 'Dado Oficial, não pode ser excluido'];
    		}
    	}
    	$this->configResponse($result);
    	return $this->response();
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
    		if($json[$key]->id_conferencia_outra == $id_conferencia_outra){
    			$ft_conferencia_declarada_outra = $this->ft_representante;

    			$nome_conferencia_declarada = $request->input('tx_nome_conferencia_declarada');
    			if($json_declarada[$key]->tx_nome_conferencia_declarada != $nome_conferencia_declarada) $ft_conferencia_declarada = $this->ft_representante;
    			else $ft_conferencia_declarada = $request->input('ft_conferencia_declarada');

    			$dt_ano_realizacao = $request->input('dt_ano_realizacao');
    			if($json[$key]->dt_ano_realizacao != $dt_ano_realizacao) $ft_ano_realizacao = $this->ft_representante;
    			else $ft_ano_realizacao = $request->input('ft_ano_realizacao');

    			$cd_forma_participacao_conferencia = $request->input('cd_forma_participacao_conferencia');
    			if($json[$key]->cd_forma_participacao_conferencia != $cd_forma_participacao_conferencia) $ft_forma_participacao_conferencia = $this->ft_representante;
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
    		if($json[$key]->id_participacao_social_declarada == $id_participacao_social_declarada){
    			$nome_participacao_social_declarada = $request->input('tx_nome_participacao_social_declarada');
    			if($json[$key]->tx_nome_participacao_social_declarada != $nome_participacao_social_declarada) $ft_nome_participacao_social_declarada = $this->ft_representante;
    			else $ft_nome_participacao_social_declarada = $request->input('ft_nome_participacao_social_declarada');

    			$tipo_participacao_social_declarada = $request->input('tx_tipo_participacao_social_declarada');
    			if($json[$key]->tx_tipo_participacao_social_declarada != $tipo_participacao_social_declarada) $ft_tipo_participacao_social_declarada = $this->ft_representante;
    			else $ft_tipo_participacao_social_declarada = $request->input('ft_tipo_participacao_social_declarada');

    			$dt_data_ingresso_participacao_social_declarada = $request->input('dt_data_ingresso_participacao_social_declarada');
    			if($json[$key]->dt_data_ingresso_participacao_social_declarada != $dt_data_ingresso_participacao_social_declarada) $ft_data_ingresso_participacao_social_declarada = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
    			$nome = $request->input('tx_nome_participacao_social_outra');
    			if($json[$key]->tx_nome_participacao_social_outra != $nome) $ft_nome = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
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
	    	if($json[$key]->tx_link_relatorio_auditoria != $link_relatorio_auditoria) $ft_link_relatorio_auditoria = $this->ft_representante;
	    	else $ft_link_relatorio_auditoria = $request->input('ft_link_relatorio_auditoria');

	    	$link_demonstracao_contabil = $request->input('tx_link_demonstracao_contabil');
	    	if($json[$key]->tx_link_demonstracao_contabil != $link_demonstracao_contabil) $ft_link_demonstracao_contabil = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
    			$nome = $request->input('tx_nome_conselheiro');
    			if($json[$key]->tx_nome_conselheiro != $nome) $ft_nome = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
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
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
    			$tx_nome = $request->input('tx_nome_projeto');
    			if($json[$key]->tx_nome_projeto != $tx_nome) $ft_nome = $this->ft_representante;
    			else $ft_nome = $request->input('ft_nome_projeto');

    			$cd_status = $request->input('cd_status_projeto');
    			if($json[$key]->cd_status_projeto != $cd_status) $ft_status = $this->ft_representante;
    			else $ft_status = $request->input('ft_status_projeto');

    			$dt_data_inicio = $request->input('dt_data_inicio_projeto');
    			if($json[$key]->dt_data_inicio_projeto != $dt_data_inicio) $ft_data_inicio = $this->ft_representante;
    			else $ft_data_inicio = $request->input('ft_data_inicio_projeto');

    			$dt_data_fim = $request->input('dt_data_fim_projeto');
    			if($json[$key]->dt_data_fim_projeto != $dt_data_fim) $ft_data_fim = $this->ft_representante;
    			else $ft_data_fim = $request->input('ft_data_fim_projeto');

    			$nr_valor_total = $request->input('nr_valor_total_projeto');
    			if($json[$key]->nr_valor_total_projeto != $nr_valor_total) $ft_valor_total = $this->ft_representante;
    			else $ft_valor_total = $request->input('ft_valor_total_projeto');

    			$tx_link = $request->input('tx_link_projeto');
    			if($json[$key]->tx_link_projeto != $tx_link) $ft_link = $this->ft_representante;
    			else $ft_link = $request->input('ft_link_projeto');

    			$cd_abrangencia = $request->input('cd_abrangencia_projeto');
    			if($json[$key]->cd_abrangencia_projeto != $cd_abrangencia) $ft_abrangencia = $this->ft_representante;
    			else $ft_abrangencia = $request->input('ft_abrangencia_projeto');

    			$tx_descricao = $request->input('tx_descricao_projeto');
    			if($json[$key]->tx_descricao_projeto != $tx_descricao) $ft_descricao = $this->ft_representante;
    			else $ft_descricao = $request->input('ft_descricao_projeto');

    			$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
    			if($json[$key]->nr_total_beneficiarios != $nr_total_beneficiarios) $ft_total_beneficiarios = $this->ft_representante;
    			else $ft_total_beneficiarios = $request->input('ft_total_beneficiarios');

    			$nr_valor_captado_projeto = $request->input('nr_valor_captado_projeto');
    			if($json[$key]->nr_valor_captado_projeto != $nr_valor_captado_projeto) $ft_valor_captado_projeto = $this->ft_representante;
    			else $ft_valor_captado_projeto = $request->input('ft_valor_captado_projeto');

    			$cd_zona_atuacao_projeto = $request->input('cd_zona_atuacao_projeto');
    			if($json[$key]->cd_zona_atuacao_projeto != $cd_zona_atuacao_projeto) $ft_zona_atuacao_projeto = $this->ft_representante;
    			else $ft_zona_atuacao_projeto = $request->input('ft_zona_atuacao_projeto');

    			$tx_metodologia_monitoramento = $request->input('tx_metodologia_monitoramento');
    			if($json[$key]->tx_metodologia_monitoramento != $tx_metodologia_monitoramento) $ft_metodologia_monitoramento = $this->ft_representante;
    			else $ft_metodologia_monitoramento = $request->input('ft_metodologia_monitoramento');

    			$tx_identificador_projeto_externo = $request->input('tx_identificador_projeto_externo');
    			if($json[$key]->tx_identificador_projeto_externo != $tx_identificador_projeto_externo) $ft_identificador_projeto_externo = $this->ft_representante;
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
    					$tx_metodologia_monitoramento, $ft_metodologia_monitoramento, $tx_identificador_projeto_externo, $ft_identificador_projeto_externo];
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
	    	$bo_oficial = $json_oficial[$key]->bo_oficial;
	    	if(!$bo_oficial){
			    foreach($json as $key => $value){
			    	if($json[$key]->id_publico_beneficiado == $id_publico){
			    		$nome_publico_beneficiado = $request->input('tx_nome_publico_beneficiado');
			    		if($json[$key]->tx_nome_publico_beneficiado != $nome_publico_beneficiado) $ft_publico_beneficiado = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
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
    	if($cd_subarea_atuacao != null) $ft_area_atuacao_projeto = $this->ft_representante;
    	else $ft_area_atuacao_projeto = $request->input('ft_area_atuacao_projeto');

    	$bo_oficial = false;

    	$params = [$id_projeto, $cd_subarea_atuacao, $ft_area_atuacao_projeto, $bo_oficial];
    	$result = $this->dao->setAreaAtuacaoProjeto($params);

    }

    public function updateAreaAtuacaoProjeto(Request $request, $id_area)
    {
    	$json = DB::select('SELECT * FROM osc.tb_area_atuacao_projeto WHERE id_area_atuacao_projeto = ?::int',[$id_area]);

       	foreach($json as $key => $value){
       		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
       			$cd_subarea_atuacao = $request->input('cd_subarea_atuacao');
       			if($json[$key]->cd_subarea_atuacao != $cd_subarea_atuacao) $ft_area_atuacao_projeto = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
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
       		if($json[$key]->id_area_atuacao_declarada == $id_area){
       			$tx_nome_area_atuacao_declarada = $request->input('tx_nome_area_atuacao_declarada');
       			if($json[$key]->tx_nome_area_atuacao_declarada != $tx_nome_area_atuacao_declarada) $ft_nome_area_atuacao_declarada = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
    			$id_projeto = $request->input('id_projeto');
    			$id_regiao_localizacao_projeto = $request->input('id_regiao_localizacao_projeto');
    			if($json[$key]->id_regiao_localizacao_projeto != $id_regiao_localizacao_projeto) $ft_regiao_localizacao_projeto = $this->ft_representante;
    			else $ft_regiao_localizacao_projeto = $request->input('ft_regiao_localizacao_projeto');

    			$tx_nome_regiao_localizacao_projeto = $request->input('tx_nome_regiao_localizacao_projeto');
    			if($json[$key]->tx_nome_regiao_localizacao_projeto != $tx_nome_regiao_localizacao_projeto) $ft_nome_regiao_localizacao_projeto = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
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
    		$bo_oficial = $json[$key]->bo_oficial;
    		if(!$bo_oficial){
    			$id_projeto = $request->input('id_projeto');

    			$cd_meta_projeto = $request->input('cd_meta_projeto');
    			if($json[$key]->cd_meta_projeto != $cd_meta_projeto) $ft_objetivo_projeto = $this->ft_representante;
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
    		$bo_oficial = $json[$key]->bo_oficial;
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
    		$bo_oficial = $json[$key]->bo_oficial;
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

    public function setRecursosOsc(Request $request)
    {
    	$id = $request->input('id_osc');

    	$cd_fonte_recursos_osc = $request->input('cd_fonte_recursos_osc');
    	if($cd_fonte_recursos_osc != null) $ft_fonte_recursos_osc = $this->ft_representante;
    	else $ft_fonte_recursos_osc = $request->input('ft_fonte_recursos_osc');

    	$dt_ano_recursos_osc = $request->input('dt_ano_recursos_osc');
    	if($dt_ano_recursos_osc != null) $ft_ano_recursos_osc = $this->ft_representante;
    	else $ft_ano_recursos_osc = $request->input('ft_ano_recursos_osc');

    	$nr_valor_recursos_osc = $request->input('nr_valor_recursos_osc');
    	if($nr_valor_recursos_osc != null) $ft_valor_recursos_osc = $this->ft_representante;
    	else $ft_valor_recursos_osc = $request->input('ft_valor_recursos_osc');

    	$params = [$id, $cd_fonte_recursos_osc, $ft_fonte_recursos_osc, $dt_ano_recursos_osc, $ft_ano_recursos_osc, $nr_valor_recursos_osc, $ft_valor_recursos_osc];
    	$resultDao = $this->dao->setRecursosOsc($params);

    	if($resultDao->inserir_recursos_osc){
    		$result = ['msg' => 'Recursos da OSC inseridos.'];
    		$this->configResponse($result, 200);
    	}else{
    		$result = ['msg' => 'Ocorreu um erro.'];
    		$this->configResponse($result, 400);
    	}

    	return $this->response();;
    }

    public function updateRecursosOsc(Request $request, $id)
    {
    	$id_recursos_osc = $request->input('id_recursos_osc');
    	$json = DB::select('SELECT * FROM osc.tb_recursos_osc WHERE id_recursos_osc = ?::int',[$id_recursos_osc]);

    	foreach($json as $key => $value){
    		if($json[$key]->id_recursos_osc == $id_recursos_osc){
    			$cd_fonte_recursos_osc = $request->input('cd_fonte_recursos_osc');
    			if($json[$key]->cd_fonte_recursos_osc != $cd_fonte_recursos_osc) $ft_fonte_recursos_osc = $this->ft_representante;
    			else $ft_fonte_recursos_osc = $request->input('ft_fonte_recursos_osc');

    			$dt_ano_recursos_osc = $request->input('dt_ano_recursos_osc');
    			if($json[$key]->dt_ano_recursos_osc != $dt_ano_recursos_osc) $ft_ano_recursos_osc = $this->ft_representante;
    			else $ft_ano_recursos_osc = $request->input('ft_ano_recursos_osc');

    			$nr_valor_recursos_osc = str_replace(',', '.', $request->input('nr_valor_recursos_osc'));
    			if($json[$key]->nr_valor_recursos_osc != $nr_valor_recursos_osc) $ft_valor_recursos_osc = $this->ft_representante;
    			else $ft_valor_recursos_osc = $request->input('ft_valor_recursos_osc');
    		}
    	}

    	$params = [$id, $id_recursos_osc, $cd_fonte_recursos_osc, $ft_fonte_recursos_osc, $dt_ano_recursos_osc, $ft_ano_recursos_osc, $nr_valor_recursos_osc, $ft_valor_recursos_osc];
    	$resultDao = $this->dao->updateRecursosOsc($params);

    	if($resultDao->status){
    		$result = ['msg' => $resultDao->mensagem];
    		$this->configResponse($result, 200);
    	}else{
    		$result = ['msg' => $resultDao->mensagem];
    		$this->configResponse($result, 400);
    	}

    	return $this->response();
    }

    public function deleteRecursosOsc($id_recursos, $id)
    {
    	$params = [$id_recursos];
    	$result = $this->dao->deleteRecursosOsc($params);

    	$result = ['msg' => 'Recursos da OSC atualizado.'];
    	$this->configResponse($result, 200);

    	return $this->response();
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
    		if($json[$key]->id_recursos_outro_osc == $id_recursos_osc){
    			$tx_nome_fonte_recursos_osc = $request->input('tx_nome_fonte_recursos_outro_osc');
    			if($json[$key]->tx_nome_fonte_recursos_outro_osc != $tx_nome_fonte_recursos_osc) $ft_nome_fonte_recursos_osc = $this->ft_representante;
    			else $ft_nome_fonte_recursos_osc = $request->input('ft_nome_fonte_recursos_outro_osc');

    			$dt_ano_recursos_osc = $request->input('dt_ano_recursos_outro_osc');
    			if($json[$key]->dt_ano_recursos_outro_osc != $dt_ano_recursos_osc) $ft_ano_recursos_osc = $this->ft_representante;
    			else $ft_ano_recursos_osc = $request->input('ft_ano_recursos_outro_osc');

    			$nr_valor_recursos_osc = $request->input('nr_valor_recursos_outro_osc');
    			if($json[$key]->nr_valor_recursos_outro_osc != $nr_valor_recursos_osc) $ft_valor_recursos_osc = $this->ft_representante;
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
