<?php

namespace App\Dao;

use App\Dao\DaoPostgres;
use App\Util\FormatacaoUtil;

class SearchDao extends DaoPostgres{
	private $queriesLista = array(
		"osc" => ["SELECT * FROM portal.buscar_osc_lista(?::TEXT, ?::INTEGER, ?::INTEGER, ?::INTEGER);", false],
		"municipio" => ["SELECT * FROM portal.buscar_osc_municipio_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"estado" => ["SELECT * FROM portal.buscar_osc_estado_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"regiao" => ["SELECT * FROM portal.buscar_osc_regiao_lista(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false]
	);
	
	private $queriesAutocomplete = array(
		"cnpj" => ["SELECT * FROM portal.buscar_osc_cnpj(?::TEXT, ?::INTEGER, ?::INTEGER);", false],
		"osc" => ["SELECT * FROM portal.buscar_osc_autocomplete(?::TEXT, ?::INTEGER, ?::INTEGER, ?::INTEGER);", false],
		"municipio" => ["SELECT * FROM portal.buscar_osc_municipio_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"estado" => ["SELECT * FROM portal.buscar_osc_estado_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"regiao" => ["SELECT * FROM portal.buscar_osc_regiao_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"atividade_economica" => ["SELECT * FROM portal.obter_atividade_economica(?::TEXT, ?::INTEGER, ?::INTEGER);", false]
	);
	
	private $queriesGeo = array(
		"osc" => ["SELECT * FROM portal.buscar_osc_geo(?::TEXT, ?::INTEGER, ?::INTEGER, ?::INTEGER);", false],
		"municipio" => ["SELECT * FROM portal.buscar_osc_municipio_geo(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"estado" => ["SELECT * FROM portal.buscar_osc_estado_geo(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false],
		"regiao" => ["SELECT * FROM portal.buscar_osc_regiao_geo(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false]
	);
	
	private function configResultGeo($result){
		$json = [[]];
		
		for ($i = 0; $i<count($result); $i++) {
			$json[$result[$i]->id_osc][0] = $result[$i]->geo_lat;
			$json[$result[$i]->id_osc][1] = $result[$i]->geo_lng;
		}
		
		return $json;
	}
	
	private function configResultLista($result){
		$json = [[]];
		
		for ($i = 0; $i<count($result); $i++) {
			$json[$result[$i]->id_osc][0] = $result[$i]->tx_nome_osc;
			$json[$result[$i]->id_osc][1] = $result[$i]->cd_identificador_osc;
			$json[$result[$i]->id_osc][2] = $result[$i]->tx_natureza_juridica_osc;
			$json[$result[$i]->id_osc][3] = $result[$i]->tx_endereco_osc;
			$json[$result[$i]->id_osc][4] = $result[$i]->im_logo;
		}
		
		return $json;
	}

	public function searchList($type_result, $param = null){
		$queries = array();
		
		$query_ext = '';
		if($type_result == 'lista'){
			$query_var = 'vw_busca_resultado.id_osc, vw_busca_resultado.tx_nome_osc, vw_busca_resultado.cd_identificador_osc, vw_busca_resultado.tx_natureza_juridica_osc, vw_busca_resultado.tx_endereco_osc, vw_busca_resultado.tx_nome_atividade_economica, vw_busca_resultado.im_logo ';
			$query_ext = 'ORDER BY vw_busca_resultado.tx_nome_osc ';
		}
		else if($type_result == 'autocomplete'){
			$query_var = 'LOWER(vw_busca_resultado.tx_nome_osc) AS tx_nome_osc ';
			$query_ext = 'ORDER BY tx_nome_osc ';
		}
		else if($type_result == 'geo'){
			$query_var = 'vw_busca_resultado.id_osc, vw_busca_resultado.geo_lat, vw_busca_resultado.geo_lng ';
		}
		
		$query = 'SELECT ' . $query_var . 'FROM osc.vw_busca_resultado ' . $query_ext;
		
		if($param[1] > 0){
			$query_limit = 'LIMIT ' . $param[0] . ' OFFSET ' . $param[1] . ';';
		}
		else if($param[0] > 0){
			$query_limit = 'LIMIT ' . $param[0] . ';';
		}
		else{
			$query_limit = ';';
		}
		
		$query .= $query_limit;
		$result = $this->executarQuery($query, false);
		
		if($type_result == 'lista'){
			$result = $this->configResultLista($result);
		}
		if($type_result == 'geo'){
			$result = $this->configResultGeo($result);
		}
		
		return $result;
	}

	public function search($type_search, $type_result, $param = null){
		$queries = array();
		
		if($type_result == 'lista'){
			$queries = $this->queriesLista;
		}
		else if($type_result == 'autocomplete'){
			$queries = $this->queriesAutocomplete;
		}
		else if($type_result == 'geo'){
			$queries = $this->queriesGeo;
		}
		
		if(array_key_exists($type_search, $queries)){
			$query_info = $queries[$type_search];
			$query = $query_info[0];
			$unique = $query_info[1];
			
			$result = $this->executarQuery($query, $unique, $param);
		}
		else{
			$result = null;
		}
		
		if($type_result == 'lista'){
			$result = $this->configResultLista($result);
		}
		if($type_result == 'geo'){
			$result = $this->configResultGeo($result);
		}
		
		return $result;
	}
	
	private function Getfloat($str){
		if(strstr($str, ",")) {
			$str = str_replace(".", "", $str);
			$str = str_replace(",", ".", $str);
		}
		
		if(preg_match("#([0-9\.]+)#", $str, $match)){
			return floatval($match[0]);
		}else{
			return floatval($str);
		}
	}

	public function searchAdvancedList($type_result, $param = null, $busca){
		$count_busca = 0;
		foreach($busca as $value){
			$count_busca++;
		}
		
		if($count_busca > 0){
			if($type_result == 'lista'){
				$query_var = 'vw_busca_resultado.id_osc, vw_busca_resultado.tx_nome_osc, vw_busca_resultado.cd_identificador_osc, vw_busca_resultado.tx_natureza_juridica_osc, vw_busca_resultado.tx_endereco_osc, vw_busca_resultado.tx_nome_atividade_economica, vw_busca_resultado.im_logo ';
			}else if($type_result == 'geo'){
				$query_var = 'vw_busca_resultado.id_osc, vw_busca_resultado.geo_lat, vw_busca_resultado.geo_lng ';
			}
			
			$query = 'SELECT ' . $query_var . 'FROM osc.vw_busca_resultado WHERE vw_busca_resultado.id_osc IN (';
			
			$query .= "SELECT id_osc FROM osc.vw_busca_osc WHERE ";
			
			$count_params_busca = 0;
			
			if(isset($busca->dadosGerais)){
				$count_params_busca = $count_params_busca + 1;
				$dados_gerais = $busca->dadosGerais;
				
				$count_dados_gerais = 0;
				foreach($dados_gerais as $value) $count_dados_gerais++;
				
				$count_params_dados = 0;
				foreach($dados_gerais as $key => $value){
					$value = str_replace("'", "''", $value);
					
					$count_params_dados++;
					
					if($key == "tx_razao_social_osc"){
						$value = str_replace(' ', '+', $value);
						$var_sql = "(document @@ to_tsquery('portuguese_unaccent', '' || '".$value."' || '') AND (similarity(vw_busca_osc.tx_razao_social_osc::TEXT, '' || '".$value."' || '') > 0.05) OR (CHAR_LENGTH('' || '".$value."' || '') > 4 AND (vw_busca_osc.tx_razao_social_osc::TEXT ILIKE '''%' || TRANSLATE('".$value."', '+', ' ') || '%''')))";
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .= $var_sql." AND ";
					}
					
					if($key == "tx_nome_fantasia_osc"){
						$value = str_replace(' ', '+', $value);
						$var_sql = "(document @@ to_tsquery('portuguese_unaccent', '' || '".$value."' || '') AND (similarity(vw_busca_osc.tx_nome_fantasia_osc::TEXT, '' || '".$value."' || '') > 0.05) OR (CHAR_LENGTH('' || '".$value."' || '') > 4 AND (vw_busca_osc.tx_nome_fantasia_osc::TEXT ILIKE '''%' || TRANSLATE('".$value."', '+', ' ') || '%''')))";
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .= $var_sql." AND ";
					}
					
					if($key == "cd_regiao" || $key == "cd_uf"){
						$var_sql = $key . " = " . $value;
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .= $var_sql." AND ";
					}
					
					if($key == "cd_municipio"){
						$var_sql = $key . " = " . $value;
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .= $var_sql." AND ";
					}
					
					if($key == 'tx_nome_regiao' || $key == 'tx_nome_uf'){
						$var_sql = $key . " = '" . $value . "'";
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .= $var_sql." AND ";
					}
					
					if($key == 'tx_nome_municipio'){
						$var_sql = $key . " || ' - ' || tx_sigla_uf = '" . $value . "'";
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .= $var_sql." AND ";
					}
					
					if($key == "cd_identificador_osc"){
						$var_sql = "(similarity(vw_busca_osc.cd_identificador_osc::TEXT, LTRIM('' || " . $value . " || '', '0')) >= 0.25 AND vw_busca_osc.cd_identificador_osc::TEXT ILIKE LTRIM('' || ".$value." || '', '0') || '%')";
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .= $var_sql." AND ";
					}
					
					if($key == "cd_situacao_imovel_osc"){
						$var_sql = $key." = ".$value;
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .= $var_sql." AND ";
					}
					
					if($key == "anoFundacaoMIN"){
						if(isset($dados_gerais['anoFundacaoMAX'])){
							$var_sql = "dt_fundacao_osc BETWEEN '" . $value . "-01-01' AND '" . $dados_gerais['anoFundacaoMAX'] . "-12-31'";
							if($count_params_dados == $count_dados_gerais-1 && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .= $var_sql . " AND ";
						}else{
							$var_sql = "dt_fundacao_osc BETWEEN '" . $value . "-01-01' AND '2100-12-31'";
							if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .= $var_sql . " AND ";
						}
					}else{
						if($key == "anoFundacaoMAX"){
							if(!isset($dados_gerais['anoFundacaoMIN'])){
								$var_sql = "dt_fundacao_osc BETWEEN '1600-01-01' AND '" . $value . "-12-31'";
								if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .= $var_sql . " AND ";
							}
						}
					}
					
					if(isset($dados_gerais['naturezaJuridica_outra'])){
						if($key == "naturezaJuridica_outra"){
							if($value) $var_sql = "(tx_nome_natureza_juridica_osc IS null)";
							
							if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .= $var_sql." AND ";
						}
					}
					if(isset($dados_gerais['naturezaJuridica_associacaoPrivada']) || isset($dados_gerais['naturezaJuridica_fundacaoPrivada']) || isset($dados_gerais['naturezaJuridica_organizacaoReligiosa']) || isset($dados_gerais['naturezaJuridica_organizacaoSocial'])){
						if($key == "naturezaJuridica_associacaoPrivada"){
							if($value) $var_sql = "tx_nome_natureza_juridica_osc = 'Associação Privada'";
							
							if(isset($dados_gerais['naturezaJuridica_fundacaoPrivada']) || isset($dados_gerais['naturezaJuridica_organizacaoReligiosa']) || isset($dados_gerais['naturezaJuridica_organizacaoSocial']) || isset($dados_gerais['naturezaJuridica_outra'])){
								$query .= $var_sql." OR ";
							}else{
								if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .= $var_sql." AND ";
							}
						}
						
						if($key == "naturezaJuridica_fundacaoPrivada"){
							if($value) $var_sql = "tx_nome_natureza_juridica_osc = 'Fundação Privada'";
							
							if(isset($dados_gerais['naturezaJuridica_organizacaoReligiosa']) || isset($dados_gerais['naturezaJuridica_organizacaoSocial']) || isset($dados_gerais['naturezaJuridica_outra'])){
								$query .= $var_sql." OR ";
							}else{
								if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .= $var_sql." AND ";
							}
						}
						
						if($key == "naturezaJuridica_organizacaoReligiosa"){
							if($value) $var_sql = "tx_nome_natureza_juridica_osc = 'Organização Religiosa'";
							
							if(isset($dados_gerais['naturezaJuridica_organizacaoSocial']) || isset($dados_gerais['naturezaJuridica_outra'])){
								$query .= $var_sql." OR ";
							}else{
								if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .= $var_sql." AND ";
							}
						}
						
						if($key == "naturezaJuridica_organizacaoSocial"){
							if($value) $var_sql = "tx_nome_natureza_juridica_osc = 'Organização Social'";
							
							if(isset($dados_gerais['naturezaJuridica_outra'])){
								$query .= $var_sql." OR ";
							}else{
								if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .= $var_sql . " AND ";
							}
						}
					}
				}
			}

			if(isset($busca->dadosGerais)){
				$flagObjetivos = false;
				
				$countParamsBusca = $count_params_busca + 1;
				$dadosGerais = $busca->dadosGerais;

				if(substr($query, -7) != " WHERE " && substr($query, -5) != " AND "){
					$sqlObjetivos = " AND id_osc IN (SELECT id_osc FROM portal.vw_osc_objetivo_osc WHERE ";
				}else{
					$sqlObjetivos = " id_osc IN (SELECT id_osc FROM portal.vw_osc_objetivo_osc WHERE ";
				}
				
				$countDadosGerais = 0;
				foreach($dadosGerais as $value) $countDadosGerais++;
				
				$countParamsDadosGerais = 0;
				foreach($dadosGerais as $key => $value){
					$countParamsDadosGerais++;
					
					if($key == "cd_objetivo_osc"){
						$flagObjetivos = true;
						
						if($value == "qualquer"){
							$var_sql = $key . " IS NOT null";
						}else{
							$var_sql = $key . " = " . $value;
						}
						
						if($countParamsDadosGerais == $countDadosGerais && $countParamsBusca == $count_busca){
							$sqlObjetivos .=  $var_sql . ")";
						}else{
							$sqlObjetivos .=  $var_sql . " AND ";
						}
					}
					
					if($key == "cd_meta_osc"){
						$sqlObjetivos = rtrim($sqlObjetivos, ')');

						$flagObjetivos = true;
						
						if($value == "qualquer"){
							$var_sql = $key . " IS NOT null";
						}else{
							$var_sql = $key . " = " . $value;
						}
						
						if($countParamsDadosGerais == $countDadosGerais && $countParamsBusca == $count_busca){
							$sqlObjetivos .=  $var_sql . ")";
						}else{
							$sqlObjetivos .=  $var_sql . " AND ";
						}
					}
				}

				if($flagObjetivos){
					$query .= $sqlObjetivos;
				}

				$query = rtrim($query, ' AND ') . ') AND ';
			}

			if(isset($busca->areasSubareasAtuacao)){
				$queryAreasSubareasAtuacao = '';
				
				foreach($busca->areasSubareasAtuacao as $key => $value){
					$boolean = (new FormatacaoUtil())->formatarBoolean($value);

					if($boolean){
						$explode = explode('-', $key);

						$tipoArea = $explode[0];
						$codigo = $explode[1];

						if($tipoArea === 'cd_subarea_atuacao' || $tipoArea === 'cd_area_atuacao'){
							$queryAreasSubareasAtuacao .= $tipoArea . ' = ' . $codigo . ' OR ';
						}
					}
				}

				$queryAreasSubareasAtuacao = rtrim($queryAreasSubareasAtuacao, ' OR ');

				if($queryAreasSubareasAtuacao){
					$query .= 'id_osc IN (SELECT id_osc FROM osc.tb_area_atuacao WHERE ' . $queryAreasSubareasAtuacao . ' AND ';
				}
			}
			
			if(isset($busca->atividadeEconomica)){
				foreach($busca->atividadeEconomica as $key => $value){
					if($key == 'cd_classe_atividade_economica' || $key == 'cd_classe_atividade_economica_osc'){
						$query .= 'id_osc IN (SELECT id_osc FROM osc.tb_dados_gerais WHERE cd_classe_atividade_economica_osc = \'' . $value . '\')';
					}
				}
			}
			
			if(isset($busca->titulacoesCertificacoes)){
				$queryTitulacoesCertificacoes = '';

				foreach($busca->titulacoesCertificacoes as $key => $value){
					$boolean = (new FormatacaoUtil())->formatarBoolean($value);

					if($boolean){
						$queryTitulacoesCertificacoes .=  ' cd_certificado = ';

						$titulo = explode('_', $key)[1];

						if($titulo == 'entidadeAmbientalista'){
							$queryTitulacoesCertificacoes .= '1';
						}else if($titulo == 'cebasEducacao'){
							$queryTitulacoesCertificacoes .= '2';
						}else if($titulo == 'cebasSaude'){
							$queryTitulacoesCertificacoes .= '3';
						}else if($titulo == 'oscip'){
							$queryTitulacoesCertificacoes .= '4';
						}else if($titulo == 'utilidadePublicaFederal'){
							$queryTitulacoesCertificacoes .= '5';
						}else if($titulo == 'cebasAssistenciaSocial'){
							$queryTitulacoesCertificacoes .= '6';
						}else if($titulo == 'utilidadePublicaEstadual'){
							$queryTitulacoesCertificacoes .= '7';
						}else if($titulo == 'utilidadePublicaMunicipal'){
							$queryTitulacoesCertificacoes .= '8';
						}else if($titulo == 'naoPossui'){
							$queryTitulacoesCertificacoes .= '9';
						}

						$queryTitulacoesCertificacoes .= ' OR ';
					}
				}

				$queryTitulacoesCertificacoes = rtrim($queryTitulacoesCertificacoes, ' OR ');

				if($queryTitulacoesCertificacoes){
					$query .= 'id_osc IN (SELECT id_osc FROM osc.tb_certificado WHERE ' . $queryTitulacoesCertificacoes . ' AND ';
				}
			}
			
			if(isset($busca->relacoesTrabalhoGovernanca)){
				$objeto = (object) $busca->relacoesTrabalhoGovernanca;
				
				$queryGovernanca = '';

				if(isset($objeto->tx_nome_dirigente)){
					$queryGovernanca .= 'UNACCENT(tx_nome_dirigente) ILIKE UNACCENT(\'%' . $objeto->tx_nome_dirigente . '%\') AND ';
				}

				if(isset($objeto->tx_cargo_dirigente)){
					$queryGovernanca .= 'UNACCENT(tx_cargo_dirigente) ILIKE UNACCENT(\'%' . $objeto->tx_cargo_dirigente . '%\') AND ';
				}
				
				if(isset($objeto->tx_nome_conselheiro)){
					$queryGovernanca .= 'UNACCENT(tx_nome_conselheiro) ILIKE UNACCENT(\'%' . $objeto->tx_nome_conselheiro . '%\') AND ';
				}

				if($queryGovernanca){
					$query .= 'id_osc IN (SELECT id_osc FROM osc.tb_governanca WHERE ' . $queryGovernanca;
				}
			}
			
			if(isset($busca->relacoesTrabalhoGovernanca)){
				$objeto = (object) $busca->relacoesTrabalhoGovernanca;
				
				$queryRelacoesTrabalho = '';

				if(isset($objeto->totalTrabalhadoresMIN)){
					$queryRelacoesTrabalho .= '(COALESCE(nr_trabalhadores_vinculo, 0) + COALESCE(nr_trabalhadores_deficiencia, 0) + COALESCE(nr_trabalhadores_voluntarios, 0)) >= ' . $objeto->totalTrabalhadoresMIN . ' AND ';
				}

				if(isset($objeto->totalTrabalhadoresMAX)){
					$queryRelacoesTrabalho .= '(COALESCE(nr_trabalhadores_vinculo, 0) + COALESCE(nr_trabalhadores_deficiencia, 0) + COALESCE(nr_trabalhadores_voluntarios, 0)) <= ' . $objeto->totalTrabalhadoresMAX . ' AND ';
				}

				if(isset($objeto->totalEmpregadosMIN)){
					$queryRelacoesTrabalho .= 'nr_trabalhadores_vinculo >= ' . $objeto->totalEmpregadosMIN . ' AND ';
				}

				if(isset($objeto->totalEmpregadosMAX)){
					$queryRelacoesTrabalho .= 'nr_trabalhadores_vinculo <= ' . $objeto->totalEmpregadosMAX . ' AND ';
				}

				if(isset($objeto->trabalhadoresDeficienciaMIN)){
					$queryRelacoesTrabalho .= 'nr_trabalhadores_deficiencia >= ' . $objeto->trabalhadoresDeficienciaMIN . ' AND ';
				}

				if(isset($objeto->trabalhadoresDeficienciaMAX)){
					$queryRelacoesTrabalho .= 'nr_trabalhadores_deficiencia <= ' . $objeto->trabalhadoresDeficienciaMAX . ' AND ';
				}

				if(isset($objeto->trabalhadoresVoluntariosMIN)){
					$queryRelacoesTrabalho .= 'nr_trabalhadores_voluntarios >= ' . $objeto->trabalhadoresVoluntariosMIN . ' AND ';
				}

				if(isset($objeto->trabalhadoresVoluntariosMAX)){
					$queryRelacoesTrabalho .= 'nr_trabalhadores_voluntarios <= ' . $objeto->trabalhadoresVoluntariosMAX . ' AND ';
				}

				if($queryRelacoesTrabalho){
					$query .= 'id_osc IN (SELECT id_osc FROM osc.tb_relacoes_trabalho WHERE ' . $queryRelacoesTrabalho;
				}
			}
			
			if(isset($busca->espacosParticipacaoSocial)){
				$count_params_busca = $count_params_busca + 1;
				$participacao_social = $busca->espacosParticipacaoSocial;
				
				$count_participacao = 0;
				foreach($participacao_social as $value) $count_participacao++;
				
				$count_params_participacao = 0;
				foreach($participacao_social as $key => $value){
					$count_params_participacao++;
					
					if(isset($participacao_social['cd_conselho']) || isset($participacao_social['dt_data_inicio_conselho']) || isset($participacao_social['cd_tipo_participacao']) || isset($participacao_social['dt_data_fim_conselho'])){
						$var_sql =  "id_osc IN (SELECT id_osc FROM portal.vw_osc_participacao_social_conselho WHERE ";
						if($key == "cd_conselho"){
							$query .=  $var_sql . "cd_conselho = " . $participacao_social['cd_conselho'];
							if(isset($participacao_social['dt_data_inicio_conselho']) || isset($participacao_social['dt_data_fim_conselho']) || isset($participacao_social['tx_nome_representante_conselho']) || isset($participacao_social['cd_tipo_participacao'])){
								$query .= " AND ";
							}else{
								if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
								else $query .= ") AND ";
							}
						}
						
						if($key == "dt_data_inicio_conselho"){
							if(isset($participacao_social['cd_conselho'])){
								$query .= "dt_data_inicio_conselho = TO_CHAR(TO_DATE('" . $participacao_social['dt_data_inicio_conselho'] . "', 'DD-MM-YYYY'), 'DD-MM-YYYY')";
							}else{
								$query .= $var_sql."dt_data_inicio_conselho = TO_CHAR(TO_DATE('" . $participacao_social['dt_data_inicio_conselho'] . "', 'DD-MM-YYYY'), 'DD-MM-YYYY')";
							}
							
							if(isset($participacao_social['dt_data_fim_conselho']) || isset($participacao_social['tx_nome_representante_conselho']) || isset($participacao_social['cd_tipo_participacao'])){
								$query .= " AND ";
							}else{
								if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
								else $query .= ") AND ";
							}
						}
						
						if($key == "cd_tipo_participacao"){
							if(isset($participacao_social['cd_conselho']) || isset($participacao_social['dt_data_inicio_conselho'])){
								$query .= "cd_tipo_participacao = " . $participacao_social['cd_tipo_participacao'];
							}else{
								$query .= $var_sql . "cd_tipo_participacao = " . $participacao_social['cd_tipo_participacao'];
							}
							
							if(isset($participacao_social['dt_data_fim_conselho']) || isset($participacao_social['tx_nome_representante_conselho'])){
								$query .= " AND ";
							}else{
								if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
								else $query .= ") AND ";
							}
						}
						
						if($key == "dt_data_fim_conselho"){
							if(isset($participacao_social['cd_conselho']) || isset($participacao_social['dt_data_inicio_conselho']) || isset($participacao_social['cd_tipo_participacao'])){
								$query .= "dt_data_fim_conselho = TO_CHAR(TO_DATE('" . $participacao_social['dt_data_fim_conselho'] . "', 'DD-MM-YYYY'), 'DD-MM-YYYY')";
							}else{
								$query .= $var_sql . "dt_data_fim_conselho = TO_CHAR(TO_DATE('" . $participacao_social['dt_data_fim_conselho'] . "', 'DD-MM-YYYY'), 'DD-MM-YYYY')";
							}
							
							if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
							else $query .= ") AND ";
						}
					}
					
					if($key == "tx_nome_representante_conselho"){
						$query .= "id_osc IN (SELECT id_osc FROM portal.vw_osc_representante_conselho WHERE unaccent(tx_nome_representante_conselho) ILIKE unaccent('%" . $participacao_social['tx_nome_representante_conselho'] . "%'))";
						
						if(isset($participacao_social['dt_data_fim_conselho']) || isset($participacao_social['cd_tipo_participacao'])){
							$query .= " AND ";
						}else{
							if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
							else $query .= ") AND ";
						}
					}
					
					if(isset($participacao_social['cd_conferencia']) || isset($participacao_social['cd_forma_participacao_conferencia']) || isset($participacao_social['anoRealizacaoConferenciaMIN']) || isset($participacao_social['anoRealizacaoConferenciaMAX'])){
						$var_sql =  "id_osc IN (SELECT id_osc FROM portal.vw_osc_participacao_social_conferencia WHERE ";
						if($key == "cd_conferencia"){
							$query .=  $var_sql . "cd_conferencia = " . $participacao_social['cd_conferencia'];
							if(isset($participacao_social['cd_forma_participacao_conferencia']) || isset($participacao_social['anoRealizacaoConferenciaMIN']) || isset($participacao_social['anoRealizacaoConferenciaMAX'])){
								$query .= " AND ";
							}else{
								if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
								else $query .= ") AND ";
							}
						}
						
						if($key == "cd_forma_participacao_conferencia"){
							if(isset($participacao_social['cd_conferencia'])){
								$query .= "cd_forma_participacao_conferencia = " . $participacao_social['cd_forma_participacao_conferencia'];
							}else{
								$query .= $var_sql . "cd_forma_participacao_conferencia = " . $participacao_social['cd_forma_participacao_conferencia'];
							}
							
							if(isset($participacao_social['anoRealizacaoConferenciaMIN']) || isset($participacao_social['anoRealizacaoConferenciaMAX'])){
								$query .= " AND ";
							}else{
								if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
								else $query .= ") AND ";
							}
						}
						
						if($key == "anoRealizacaoConferenciaMIN"){
							if(isset($participacao_social['cd_conferencia']) || isset($participacao_social['cd_forma_participacao_conferencia'])){
								if(isset($participacao_social['anoRealizacaoConferenciaMAX'])){
									$query .= "TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-" . $participacao_social['anoRealizacaoConferenciaMIN'] . "' AND '31-12-" . $participacao_social['anoRealizacaoConferenciaMAX'] . "'";
									if($count_params_participacao == $count_participacao-1 && $count_params_busca == $count_busca) $query .= ")";
									else $query .= ") AND ";
								}else{
									$query .= "TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-" . $participacao_social['anoRealizacaoConferenciaMIN'] . "' AND '31-12-2100'";
									if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
									else $query .= ") AND ";
								}
							}else{
								if(isset($participacao_social['anoRealizacaoConferenciaMAX'])){
									$query .= $var_sql . "TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-" . $participacao_social['anoRealizacaoConferenciaMIN'] . "' AND '31-12-" . $participacao_social['anoRealizacaoConferenciaMAX'] . "'";
									if($count_params_participacao == $count_participacao-1 && $count_params_busca == $count_busca) $query .= ")";
									else $query .= ") AND ";
								}else{
									$query .= $var_sql . "TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-" . $participacao_social['anoRealizacaoConferenciaMIN'] . "' AND '31-12-2100'";
									if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
									else $query .= ") AND ";
								}
							}
						}else{
							if(isset($participacao_social['cd_conferencia']) || isset($participacao_social['cd_forma_participacao_conferencia'])){
								if($key == "anoRealizacaoConferenciaMAX"){
									if(!isset($participacao_social['anoRealizacaoConferenciaMIN'])){
										$query .= "TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-1600' AND '31-12-" . $participacao_social['anoRealizacaoConferenciaMAX'] . "'";
										if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
										else $query .= ") AND ";
									}
								}
							}else{
								if($key == "anoRealizacaoConferenciaMAX"){
									if(!isset($participacao_social['anoRealizacaoConferenciaMIN'])){
										$query .= $var_sql . "TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-1600' AND '31-12-" . $participacao_social['anoRealizacaoConferenciaMAX'] . "'";
										if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= ")";
										else $query .= ") AND ";
									}
								}
							}
						}
					}
				}
			}
			
			if(isset($busca->projetos)){
				$query .=  "id_osc IN (SELECT id_osc FROM portal.vw_osc_projeto WHERE ";
				
				$count_params_busca = $count_params_busca + 1;
				$projetos = $busca->projetos;
				
				$count_projetos = 0;
				foreach($projetos as $value) $count_projetos++;
				
				$count_params_projetos = 0;
				foreach($projetos as $key => $value){
					$count_params_projetos++;
					
					if($key == "tx_nome_projeto"){
						$var_sql = "unaccent(" . $key . ") ILIKE unaccent('%" . $value . "%')";
						if(isset($projetos['cd_status_projeto']) || isset($projetos['dt_data_inicio_projeto']) || isset($projetos['dt_data_fim_projeto']) || isset($projetos['cd_abrangencia_projeto']) || isset($projetos['cd_zona_atuacao_projeto'])){
							$query .= $var_sql . " AND ";
						}else{
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}
					}
					
					if($key == "cd_status_projeto"){
						$var_sql = $key . " = " . $value;
						if(isset($projetos['dt_data_inicio_projeto']) || isset($projetos['dt_data_fim_projeto']) || isset($projetos['cd_abrangencia_projeto']) || isset($projetos['cd_zona_atuacao_projeto'])){
							$query .= $var_sql . " AND ";
						}else{
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}
					}
					
					if($key == "dt_data_inicio_projeto"){
						$var_sql = "TO_DATE(dt_data_inicio_projeto, 'DD-MM-YYYY') >= TO_DATE('" . $value . "', 'DD-MM-YYYY')";
						if(isset($projetos['dt_data_fim_projeto']) || isset($projetos['cd_abrangencia_projeto']) || isset($projetos['cd_zona_atuacao_projeto'])){
							$query .= $var_sql . " AND ";
						}else{
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}
					}
					
					if($key == "dt_data_fim_projeto"){
						$var_sql = "TO_DATE(dt_data_fim_projeto, 'DD-MM-YYYY') <= TO_DATE('" . $value . "', 'DD-MM-YYYY')";
						if(isset($projetos['cd_abrangencia_projeto']) || isset($projetos['cd_zona_atuacao_projeto'])){
							$query .= $var_sql . " AND ";
						}else{
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}
					}
					
					if($key == "cd_abrangencia_projeto"){
						$var_sql = $key . " = " . $value;
						if(isset($projetos['cd_zona_atuacao_projeto'])){
							$query .= $var_sql . " AND ";
						}else{
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql . " AND ";
						}
					}
					
					if($key == "cd_zona_atuacao_projeto"){
						$var_sql = $key . " = " . $value;
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
						else $query .=  $var_sql . " AND ";
					}
					
					if($key == "cd_origem_fonte_recursos_projeto"){
						$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_fonte_recursos_projeto WHERE " . $key . " = " . $value . ")";
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
						else $query .=  $var_sql . " AND ";
					}
					
					if($key == "tx_nome_financiador"){
						$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_financiador_projeto WHERE unaccent(" . $key . ") ILIKE unaccent('%" . $value . "%'))";
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
						else $query .=  $var_sql . " AND ";
					}
					
					if($key == "tx_nome_regiao_localizacao_projeto"){
						$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_localizacao_projeto WHERE unaccent(" . $key . ") ILIKE unaccent('%" . $value . "%'))";
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
						else $query .=  $var_sql . " AND ";
					}
					
					if($key == "tx_nome_publico_beneficiado"){
						$var_pub = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_publico_beneficiado_projeto WHERE ";
						$var_sql = $var_pub . "unaccent(" . $key . ") ILIKE unaccent('%" . $value . "%')";
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
						else $query .=  $var_sql . ") AND ";
					}
					
					if($key == "tx_nome_osc_parceira_projeto"){
						$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_parceira_projeto WHERE unaccent(" . $key . ") ILIKE unaccent('%" . $value . "%'))";
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
						else $query .=  $var_sql . " AND ";
					}
					
					if($key == "totalBeneficiariosMIN"){
						if(isset($projetos['totalBeneficiariosMAX'])){
							$var_sql = "nr_total_beneficiarios BETWEEN " . $projetos['totalBeneficiariosMIN'] . " AND " . $projetos['totalBeneficiariosMAX'] . "";
							
							if($count_params_projetos == $count_projetos-1 && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}else{
							$var_sql = "nr_total_beneficiarios BETWEEN " . $projetos['totalBeneficiariosMIN'] . " AND 100000";
							
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}
					}else{
						if($key == "totalBeneficiariosMAX"){
							if(!isset($projetos['totalBeneficiariosMIN'])){
								$var_sql = "nr_total_beneficiarios BETWEEN 0 AND " . $projetos['totalBeneficiariosMAX'] . "";
								
								if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
								else $query .=  $var_sql . " AND ";
							}
						}
					}
					
					if($key == "cd_objetivo_projeto"){
						if(isset($projetos['cd_meta_projeto'])){
							if($value == "qualquer"){
								$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_objetivo_projeto WHERE " . $key . " IS NOT null ";
							}else{
								$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_objetivo_projeto WHERE " . $key . " = " . $value . " AND cd_meta_projeto = " . $projetos['cd_meta_projeto'] . ")";
							}
							
							if($count_params_projetos == $count_projetos-1 && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}else{
							if($value == "qualquer"){
								$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_objetivo_projeto WHERE " . $key . " IS NOT null ";
							}else{
								$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_objetivo_projeto WHERE " . $key . " = " . $value . ")";
							}
							
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}
					}else{
						if($key == "cd_meta_projeto"){
							if(!isset($projetos['cd_objetivo_projeto'])){
								if($value == "qualquer"){
									$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_objetivo_projeto WHERE " . $key . " IS NOT null ";
								}else{
									$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_objetivo_projeto WHERE " . $key . " = " . $value . ")";
								}
								
								if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
								else $query .=  $var_sql . " AND ";
							}
						}
					}
					
					if($key == "valorTotalMIN"){
						if(isset($projetos['valorTotalMAX'])){
							$var_sql = "cast(nr_valor_total_projeto as double precision) BETWEEN " . $this->Getfloat($projetos['valorTotalMIN']) . " AND " . $this->Getfloat($projetos['valorTotalMAX']) . "";
							if($count_params_projetos == $count_projetos-1 && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}else{
							$var_sql = "cast(nr_valor_total_projeto as double precision) BETWEEN " . $this->Getfloat($projetos['valorTotalMIN']) . " AND 1000000";
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql . " AND ";
						}
					}else{
						if($key == "valorTotalMAX"){
							if(!isset($projetos['valorTotalMIN'])){
								$var_sql = "cast(nr_valor_total_projeto as double precision) BETWEEN 0 AND " . $this->Getfloat($projetos['valorTotalMAX']) . "";
								if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
								else $query .=  $var_sql . " AND ";
							}
						}
					}
					
					if($key == "valorRecebidoMIN"){
						if(isset($projetos['valorRecebidoMAX'])){
							$var_sql = "cast(nr_valor_captado_projeto as double precision) BETWEEN " . $this->Getfloat($projetos['valorRecebidoMIN']) . " AND " . $this->Getfloat($projetos['valorRecebidoMAX']) . "";
							if($count_params_projetos == $count_projetos-1 && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "cast(nr_valor_captado_projeto as double precision) BETWEEN " . $this->Getfloat($projetos['valorRecebidoMIN']) . " AND 1000000";
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "valorRecebidoMAX"){
							if(!isset($projetos['valorRecebidoMIN'])){
								$var_sql = "cast(nr_valor_captado_projeto as double precision) BETWEEN 0 AND " . $this->Getfloat($projetos['valorRecebidoMAX']) . "";
								if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
								else $query .=  $var_sql . " AND ";
							}
						}
					}
				}
				
				$query = rtrim($query, ' AND ') . ') AND ';
			}
			
			if(isset($busca->fontesRecursos)){
				$count_params_busca = $count_params_busca + 1;
				$fontes_recursos = $busca->fontesRecursos;
				
				$count_fontes_recursos = 0;
				foreach($fontes_recursos as $value) $count_fontes_recursos++;
				
				$sqlFonteRecursosInicio = "(SELECT cd_fonte_recursos_osc FROM syst.dc_fonte_recursos_osc WHERE tx_nome_fonte_recursos_osc = '";
				$sqlFonteRecursosFim = "')";
				
				$count_params_recursos = 0;
				foreach($fontes_recursos as $key => $value){
					$count_params_recursos++;
					$var_rec = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE ";
					
					if($key == "anoFonteRecursoMIN"){
						if(isset($fontes_recursos['anoFonteRecursoMAX'])){
							$var_sql = $var_rec . "cast(dt_ano_recursos_osc as integer) BETWEEN " . $fontes_recursos['anoFonteRecursoMIN'] . " AND " . $fontes_recursos['anoFonteRecursoMAX'];
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}else{
							$var_sql = $var_rec . "cast(dt_ano_recursos_osc as integer) BETWEEN " . $fontes_recursos['anoFonteRecursoMIN'] . " AND 2100";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
							else $query .=  $var_sql . " AND ";
						}
					}else{
						if($key == "anoFonteRecursoMAX"){
							if(!isset($fontes_recursos['anoFonteRecursoMIN'])){
								$var_sql = $var_rec . "cast(dt_ano_recursos_osc as integer) BETWEEN 1600 AND " . $fontes_recursos['anoFonteRecursoMAX'];
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) $query .=  $var_sql . ")";
								else $query .=  $var_sql . " AND ";
							}
						}
					}
					
					if($key == "rendimentosFinanceirosReservasContasCorrentesPropriasMIN"){
						$nomeTipoRecursos = "Rendimentos financeiros de reservas ou contas correntes  próprias";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['rendimentosFinanceirosReservasContasCorrentesPropriasMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['rendimentosFinanceirosReservasContasCorrentesPropriasMIN'])." AND ".$this->Getfloat($fontes_recursos['rendimentosFinanceirosReservasContasCorrentesPropriasMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['rendimentosFinanceirosReservasContasCorrentesPropriasMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Rendimentos financeiros de reservas ou contas correntes  próprias";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "rendimentosFinanceirosReservasContasCorrentesPropriasMAX"){
							if(!isset($fontes_recursos['rendimentosFinanceirosReservasContasCorrentesPropriasMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['rendimentosFinanceirosReservasContasCorrentesPropriasMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "rendimentosFundosPatrimoniaisMIN"){
						$nomeTipoRecursos = "Rendimentos de fundos patrimoniais";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['rendimentosFundosPatrimoniaisMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['rendimentosFundosPatrimoniaisMIN'])." AND ".$this->Getfloat($fontes_recursos['rendimentosFundosPatrimoniaisMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['endimentosFundosPatrimoniaisMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Rendimentos de fundos patrimoniais";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "rendimentosFundosPatrimoniaisMAX"){
							if(!isset($fontes_recursos['rendimentosFundosPatrimoniaisMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['rendimentosFundosPatrimoniaisMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "mensalidadesContribuicoesAssociadosMIN"){
						$nomeTipoRecursos = "Mensalidades ou contribuições de associados";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['mensalidadesContribuicoesAssociadosMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['mensalidadesContribuicoesAssociadosMIN'])." AND ".$this->Getfloat($fontes_recursos['mensalidadesContribuicoesAssociadosMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['mensalidadesContribuicoesAssociadosMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Mensalidades ou contribuições de associados";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "mensalidadesContribuicoesAssociadosMAX"){
							if(!isset($fontes_recursos['mensalidadesContribuicoesAssociadosMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['mensalidadesContribuicoesAssociadosMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "vendaBensDireitosMIN"){
						$nomeTipoRecursos = "Venda de bens e direitos";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['vendaBensDireitosMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['vendaBensDireitosMIN'])." AND ".$this->Getfloat($fontes_recursos['vendaBensDireitosMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['vendaBensDireitosMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Venda de bens e direitos";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "vendaBensDireitosMAX"){
							if(!isset($fontes_recursos['vendaBensDireitosMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['vendaBensDireitosMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "premiosRecebidosMIN"){
						$nomeTipoRecursos = "Prêmios recebidos";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['premiosRecebidosMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['premiosRecebidosMIN'])." AND ".$this->Getfloat($fontes_recursos['premiosRecebidosMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['premiosRecebidosMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Prêmios recebidos";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "premiosRecebidosMAX"){
							if(!isset($fontes_recursos['premiosRecebidosMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['premiosRecebidosMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "vendaProdutosMIN"){
						$nomeTipoRecursos = "Venda de produtos";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['vendaProdutosMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['vendaProdutosMIN'])." AND ".$this->Getfloat($fontes_recursos['vendaProdutosMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['vendaProdutosMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Venda de produtos";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "vendaProdutosMAX"){
							if(!isset($fontes_recursos['vendaProdutosMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['vendaProdutosMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "prestacaoServicosMIN"){
						$nomeTipoRecursos = "Prestação de serviços";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['prestacaoServicosMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['prestacaoServicosMIN'])." AND ".$this->Getfloat($fontes_recursos['prestacaoServicosMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['prestacaoServicosMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Prestação de serviços";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "prestacaoServicosMAX"){
							if(!isset($fontes_recursos['prestacaoServicosMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['prestacaoServicosMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "empresasPublicasSociedadesEconomiaMistaMIN"){
						$nomeTipoRecursos = "Empresas públicas ou sociedades de economia mista";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['empresasPublicasSociedadesEconomiaMistaMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['empresasPublicasSociedadesEconomiaMistaMIN'])." AND ".$this->Getfloat($fontes_recursos['empresasPublicasSociedadesEconomiaMistaMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['empresasPublicasSociedadesEconomiaMistaMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Empresas públicas ou sociedades de economia mista";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "empresasPublicasSociedadesEconomiaMistaMAX"){
							if(!isset($fontes_recursos['empresasPublicasSociedadesEconomiaMistaMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['empresasPublicasSociedadesEconomiaMistaMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "acordoOrganismosMultilateraisMIN"){
						$nomeTipoRecursos = "Acordo com organismos multilaterais";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['acordoOrganismosMultilateraisMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['acordoOrganismosMultilateraisMIN'])." AND ".$this->Getfloat($fontes_recursos['acordoOrganismosMultilateraisMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['acordoOrganismosMultilateraisMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Acordo com organismos multilaterais";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "acordoOrganismosMultilateraisMAX"){
							if(!isset($fontes_recursos['acordoOrganismosMultilateraisMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['acordoOrganismosMultilateraisMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "parceriaGovernoFederalMIN"){
						$nomeTipoRecursos = "Parceria com o governo federal";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['parceriaGovernoFederalMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaGovernoFederalMIN'])." AND ".$this->Getfloat($fontes_recursos['parceriaGovernoFederalMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaGovernoFederalMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Parceria com o governo federal";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "parceriaGovernoFederalMAX"){
							if(!isset($fontes_recursos['parceriaGovernoFederalMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['parceriaGovernoFederalMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "parceriaGovernoEstadualMIN"){
						$nomeTipoRecursos = "Parceria com o governo estadual";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['parceriaGovernoEstadualMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaGovernoEstadualMIN'])." AND ".$this->Getfloat($fontes_recursos['parceriaGovernoEstadualMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaGovernoEstadualMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Parceria com o governo estadual";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "parceriaGovernoEstadualMAX"){
							if(!isset($fontes_recursos['parceriaGovernoEstadualMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['parceriaGovernoEstadualMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "parceriaGovernoMunicipalMIN"){
						$nomeTipoRecursos = "Parceria com o governo municipal";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['parceriaGovernoMunicipalMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaGovernoMunicipalMIN'])." AND ".$this->Getfloat($fontes_recursos['parceriaGovernoMunicipalMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaGovernoMunicipalMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Parceria com o governo municipal";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "parceriaGovernoMunicipalMAX"){
							if(!isset($fontes_recursos['parceriaGovernoMunicipalMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['parceriaGovernoMunicipalMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "acordoGovernosEstrangeirosMIN"){
						$nomeTipoRecursos = "Acordo com governos estrangeiros";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['acordoGovernosEstrangeirosMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['acordoGovernosEstrangeirosMIN'])." AND ".$this->Getfloat($fontes_recursos['acordoGovernosEstrangeirosMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['acordoGovernosEstrangeirosMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Acordo com governos estrangeiros";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "acordoGovernosEstrangeirosMAX"){
							if(!isset($fontes_recursos['acordoGovernosEstrangeirosMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['acordoGovernosEstrangeirosMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "parceriaOscBrasileirasMIN"){
						$nomeTipoRecursos = "Parceria com OSCs brasileiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['parceriaOscBrasileirasMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaOscBrasileirasMIN'])." AND ".$this->Getfloat($fontes_recursos['parceriaOscBrasileirasMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaOscBrasileirasMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Parceria com OSCs brasileiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "parceriaOscBrasileirasMAX"){
							if(!isset($fontes_recursos['parceriaOscBrasileirasMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['parceriaOscBrasileirasMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "parceriaOscEstrangeirasMIN"){
						$nomeTipoRecursos = "Parceria com OSCs estrangeiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['parceriaOscEstrangeirasMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaOscEstrangeirasMIN'])." AND ".$this->Getfloat($fontes_recursos['parceriaOscEstrangeirasMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaOscEstrangeirasMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Parceria com OSCs estrangeiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "parceriaOscEstrangeirasMAX"){
							if(!isset($fontes_recursos['parceriaOscEstrangeirasMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['parceriaOscEstrangeirasMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "parceriaOrganizacoesReligiosasBrasileirasMIN"){
						$nomeTipoRecursos = "Parcerias com organizações religiosas brasileiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['parceriaOrganizacoesReligiosasBrasileirasMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaOrganizacoesReligiosasBrasileirasMIN'])." AND ".$this->Getfloat($fontes_recursos['parceriaOrganizacoesReligiosasBrasileirasMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaOrganizacoesReligiosasBrasileirasMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Parcerias com organizações religiosas brasileiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "parceriaOrganizacoesReligiosasBrasileirasMAX"){
							if(!isset($fontes_recursos['parceriaOrganizacoesReligiosasBrasileirasMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['parceriaOrganizacoesReligiosasBrasileirasMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "parceriaOrganizacoesReligiosasEstrangeirasMIN"){
						$nomeTipoRecursos = "Parcerias com organizações religiosas estrangeiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['parceriaOrganizacoesReligiosasEstrangeirasMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaOrganizacoesReligiosasEstrangeirasMIN'])." AND ".$this->Getfloat($fontes_recursos['parceriaOrganizacoesReligiosasEstrangeirasMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['parceriaOrganizacoesReligiosasEstrangeirasMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Parcerias com organizações religiosas estrangeiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "parceriaOrganizacoesReligiosasEstrangeirasMAX"){
							if(!isset($fontes_recursos['parceriaOrganizacoesReligiosasEstrangeirasMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['parceriaOrganizacoesReligiosasEstrangeirasMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "empresasPrivadasBrasileirasMIN"){
						$nomeTipoRecursos = "Empresas privadas brasileiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['empresasPrivadasBrasileirasMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['empresasPrivadasBrasileirasMIN'])." AND ".$this->Getfloat($fontes_recursos['empresasPrivadasBrasileirasMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['empresasPrivadasBrasileirasMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Empresas privadas brasileiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "empresasPrivadasBrasileirasMAX"){
							if(!isset($fontes_recursos['empresasPrivadasBrasileirasMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['empresasPrivadasBrasileirasMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "EmpresasEstrangeirasMIN"){
						$nomeTipoRecursos = "Empresas estrangeiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['EmpresasEstrangeirasMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['EmpresasEstrangeirasMIN'])." AND ".$this->Getfloat($fontes_recursos['EmpresasEstrangeirasMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['EmpresasEstrangeirasMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Empresas estrangeiras";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "EmpresasEstrangeirasMAX"){
							if(!isset($fontes_recursos['EmpresasEstrangeirasMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['EmpresasEstrangeirasMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "doacoesPessoaJuridicaMIN"){
						$nomeTipoRecursos = "Doações de pessoa jurídica";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['doacoesPessoaJuridicaMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['doacoesPessoaJuridicaMIN'])." AND ".$this->Getfloat($fontes_recursos['doacoesPessoaJuridicaMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['doacoesPessoaJuridicaMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Doações de pessoa jurídica";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "doacoesPessoaJuridicaMAX"){
							if(!isset($fontes_recursos['doacoesPessoaJuridicaMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['doacoesPessoaJuridicaMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "doacoesPessoaFisicaMIN"){
						$nomeTipoRecursos = "Doações de pessoa física";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['doacoesPessoaFisicaMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['doacoesPessoaFisicaMIN'])." AND ".$this->Getfloat($fontes_recursos['doacoesPessoaFisicaMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['doacoesPessoaFisicaMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Doações de pessoa física";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "doacoesPessoaFisicaMAX"){
							if(!isset($fontes_recursos['doacoesPessoaFisicaMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['doacoesPessoaFisicaMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "doacoesRecebidasFormaProdutosServicosComNFMIN"){
						$nomeTipoRecursos = "Doações recebidas na forma de produtos e serviços (com Nota Fiscal)";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['doacoesRecebidasFormaProdutosServicosComNFMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['doacoesRecebidasFormaProdutosServicosComNFMIN'])." AND ".$this->Getfloat($fontes_recursos['doacoesRecebidasFormaProdutosServicosComNFMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['doacoesRecebidasFormaProdutosServicosComNFMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Doações recebidas na forma de produtos e serviços (com Nota Fiscal)";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "doacoesRecebidasFormaProdutosServicosComNFMAX"){
							if(!isset($fontes_recursos['doacoesRecebidasFormaProdutosServicosComNFMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['doacoesRecebidasFormaProdutosServicosComNFMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "voluntariadoMIN"){
						$nomeTipoRecursos = "Voluntariado";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['voluntariadoMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['voluntariadoMIN'])." AND ".$this->Getfloat($fontes_recursos['voluntariadoMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['voluntariadoMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Voluntariado";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "voluntariadoMAX"){
							if(!isset($fontes_recursos['voluntariadoMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['voluntariadoMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "isencoesMIN"){
						$nomeTipoRecursos = "Isenções";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['isencoesMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['isencoesMIN'])." AND ".$this->Getfloat($fontes_recursos['isencoesMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['isencoesMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Isenções";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "isencoesMAX"){
							if(!isset($fontes_recursos['isencoesMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['isencoesMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "imunidadesMIN"){
						$nomeTipoRecursos = "Imunidades";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['imunidadesMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['imunidadesMIN'])." AND ".$this->Getfloat($fontes_recursos['imunidadesMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['imunidadesMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Imunidades";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "imunidadesMAX"){
							if(!isset($fontes_recursos['imunidadesMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['imunidadesMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "bensRecebidosDireitoUsoMIN"){
						$nomeTipoRecursos = "Bens recebidos em direito de uso";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['bensRecebidosDireitoUsoMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['bensRecebidosDireitoUsoMIN'])." AND ".$this->Getfloat($fontes_recursos['bensRecebidosDireitoUsoMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['bensRecebidosDireitoUsoMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Bens recebidos em direito de uso";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "bensRecebidosDireitoUsoMAX"){
							if(!isset($fontes_recursos['bensRecebidosDireitoUsoMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['bensRecebidosDireitoUsoMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if($key == "doacoesRecebidasFormaProdutosServicosSemNFMIN"){
						$nomeTipoRecursos = "Doações recebidas na forma de produtos e serviços (sem Nota Fiscal)";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if(isset($fontes_recursos['doacoesRecebidasFormaProdutosServicosSemNFMAX'])){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['doacoesRecebidasFormaProdutosServicosSemNFMIN'])." AND ".$this->Getfloat($fontes_recursos['doacoesRecebidasFormaProdutosServicosSemNFMAX']).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos['doacoesRecebidasFormaProdutosServicosSemNFMIN'])." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
								else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
						}
					}else{
						$nomeTipoRecursos = "Doações recebidas na forma de produtos e serviços (sem Nota Fiscal)";
						$sqlFonteRecursos = $sqlFonteRecursosInicio . $nomeTipoRecursos . $sqlFonteRecursosFim;
						
						if($key == "doacoesRecebidasFormaProdutosServicosSemNFMAX"){
							if(!isset($fontes_recursos['doacoesRecebidasFormaProdutosServicosSemNFMIN'])){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = " . $sqlFonteRecursos . " AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos['doacoesRecebidasFormaProdutosServicosSemNFMAX']).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos['anoFonteRecursoMIN']) || isset($fontes_recursos['anoFonteRecursoMAX'])) $query .=  $var_sql.")";
									else $query .=  $var_sql;
									else $query .=  $var_sql." AND ";
							}
						}
					}
				}
			}

			if(isset($busca->ipeadata)){
				$queryIdh = '';
				
				$ipeadata = $busca->ipeadata;
				foreach($ipeadata as $key => $value){
					if($key == "idh"){
						$queryIdh .= 'quantidade_oscs ';
						switch(strtolower($value)){
							case 'baixo':
								$queryIdh .= '< 100';
							case 'medio':
								$queryIdh .= 'BETWEEN 100 AND 500';
							case 'alto':
								$queryIdh .= '> 10000';
						}
						$queryIdh .= ' OR ';
					}
				}
				
				$queryIdh = rtrim($queryIdh, ' OR ');

				if($queryIdh){
					$query .= 'id_osc IN (SELECT b.id_osc
						FROM analysis.vw_perfil_localidade_caracteristicas AS a
						INNER JOIN osc.tb_localizacao AS b
						ON a.localidade::TEXT = b.cd_municipio::TEXT
						WHERE ' . $queryIdh . ' AND ';
				}
			}

			$query = rtrim($query, ' AND ');
			
			$countInicio = substr_count($query, '(');
			$countFim = substr_count($query, ')');
			$quantParentesesFinal = $countInicio - $countFim;
			
			for($i = 0; $i < $quantParentesesFinal; $i++){
				$query .= ')';
			}
			
			if($param[1] > 0){
				$query_limit = 'LIMIT ' . $param[0] . ' OFFSET ' . $param[1] . ';';
			}
			else if($param[0] > 0){
				$query_limit = 'LIMIT ' . $param[0] . ';';
			}
			else{
				$query_limit = ';';
			}
			
			$query .= ' ORDER BY vw_busca_resultado.id_osc '.$query_limit;
			
			$query = str_replace('WHERE tx_nome_natureza_juridica_osc', 'WHERE (tx_nome_natureza_juridica_osc', $query);
			$query = str_replace('AND tx_nome_natureza_juridica_osc', 'AND (tx_nome_natureza_juridica_osc', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc = \'Associação Privada\' AND', 'tx_nome_natureza_juridica_osc = \'Associação Privada\') AND', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc = \'Associação Privada\') ORDER', 'tx_nome_natureza_juridica_osc = \'Associação Privada\')) ORDER', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc = \'Fundação Privada\' AND', 'tx_nome_natureza_juridica_osc = \'Fundação Privada\') AND', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc = \'Fundação Privada\') ORDER', 'tx_nome_natureza_juridica_osc = \'Fundação Privada\')) ORDER', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc = \'Organização Religiosa\' AND', 'tx_nome_natureza_juridica_osc = \'Organização Religiosa\') AND', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc = \'Organização Religiosa\') ORDER', 'tx_nome_natureza_juridica_osc = \'Organização Religiosa\')) ORDER', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc = \'Organização Social\' AND', 'tx_nome_natureza_juridica_osc = \'Organização Social\') AND', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc = \'Organização Social\') ORDER', 'tx_nome_natureza_juridica_osc = \'Organização Social\')) ORDER', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc != \'Organização Social\') AND', 'tx_nome_natureza_juridica_osc != \'Organização Social\') AND', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc != \'Organização Social\') ORDER', 'tx_nome_natureza_juridica_osc != \'Organização Social\')) ORDER', $query);
			
			$countParenteresAbrir = substr_count($query, '(');
			$countParenteresFechar = substr_count($query, ')');
			$countParenteresFaltantes = $countParenteresAbrir - $countParenteresFechar;

			if($countParenteresFaltantes > 0){
				$parantesesAdicionar = '';
				for ($i = 1; $i <= $countParenteresFaltantes; $i++) {
					$parantesesAdicionar .= ')';
				}
				$parantesesUltimo = strrpos($query, ')');
				$query = substr_replace($query, $query[$parantesesUltimo] . $parantesesAdicionar, $parantesesUltimo, $countParenteresFaltantes);
			}elseif($countParenteresFaltantes < 0){
				$query = substr_replace($query, '', strrpos($query, ')'), 1);
			}
			
			$result = $this->executarQuery($query, false);
			
			if($result > 0){
				if($type_result == 'lista'){
					$result = $this->configResultLista($result);
				}else if($type_result == 'geo'){
					$result = $this->configResultGeo($result);
				}
			}else{
				$result = "Nenhuma Organização encontrada!";
			}
			
			return $result;
		}
	}
}