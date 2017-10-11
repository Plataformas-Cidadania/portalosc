<?php

namespace App\Dao;

use App\Dao\DaoPostgres;

class SearchDao extends DaoPostgres
{
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
			"regiao" => ["SELECT * FROM portal.buscar_osc_regiao_autocomplete(?::NUMERIC, ?::INTEGER, ?::INTEGER);", false]
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
    
	public function searchList($type_result, $param = null)
	{
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
    
	public function search($type_search, $type_result, $param = null)
	{
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
	
	private function Getfloat($str) {
		if(strstr($str, ",")) {
			$str = str_replace(".", "", $str);
			$str = str_replace(",", ".", $str);
		}
	    
		if(preg_match("#([0-9\.]+)#", $str, $match)) {
			return floatval($match[0]);
		}else{
			return floatval($str);
		}
	}
    
	public function searchAdvancedList($type_result, $param = null, $request)
	{
		$avancado = $request->input('avancado');
		
		if(is_array($avancado)){
		    $busca = (object) $avancado;
		}else{
		    $busca = json_decode($avancado);
		}
		
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
				foreach($dados_gerais as $value)$count_dados_gerais++;
				
				$count_params_dados = 0;
				foreach($dados_gerais as $key => $value){
					$count_params_dados++;
	                
					if($key == "tx_razao_social_osc"){
					    $value = str_replace(' ', '+', $value);
						$var_sql = "(document @@ to_tsquery('portuguese_unaccent', '' || '".$value."' || '') AND (similarity(vw_busca_osc.tx_razao_social_osc::TEXT, '' || '".$value."' || '') > 0.05) OR (CHAR_LENGTH('' || '".$value."' || '') > 4 AND (vw_busca_osc.tx_razao_social_osc::TEXT ILIKE '''%' || TRANSLATE('".$value."', '+', ' ') || '%''')))";
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .=  $var_sql." AND ";
					}
					
					if($key == "tx_nome_fantasia_osc"){
					    $value = str_replace(' ', '+', $value);
						$var_sql = "(document @@ to_tsquery('portuguese_unaccent', '' || '".$value."' || '') AND (similarity(vw_busca_osc.tx_nome_fantasia_osc::TEXT, '' || '".$value."' || '') > 0.05) OR (CHAR_LENGTH('' || '".$value."' || '') > 4 AND (vw_busca_osc.tx_nome_fantasia_osc::TEXT ILIKE '''%' || TRANSLATE('".$value."', '+', ' ') || '%''')))";
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .=  $var_sql." AND ";
					}
					
					if($key == "cd_regiao" || $key == "cd_uf"){
						$var_sql = $key . " = " . $value;
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .=  $var_sql." AND ";
					}
					
					if($key == "cd_municipio"){
					    $var_sql = $key . " = " . $value;
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .=  $var_sql." AND ";
					}
	                
					if($key == "cd_identificador_osc"){
						$var_sql = "(similarity(vw_busca_osc.cd_identificador_osc::TEXT, LTRIM('' || ".$value." || '', '0')) >= 0.25 AND vw_busca_osc.cd_identificador_osc::TEXT ILIKE LTRIM('' || ".$value." || '', '0') || '%')";
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .=  $var_sql." AND ";
					}
					
					if($key == "cd_situacao_imovel_osc"){
						$var_sql = $key." = ".$value;
						if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .=  $var_sql." AND ";
					}
					
					if($key == "anoFundacaoMIN"){
						if(isset($dados_gerais->anoFundacaoMAX)){
							$var_sql = "dt_fundacao_osc BETWEEN '".$dados_gerais->anoFundacaoMIN."-01-01' AND '".$dados_gerais->anoFundacaoMAX."-12-31'";
							if($count_params_dados == $count_dados_gerais-1 && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "dt_fundacao_osc BETWEEN '".$dados_gerais->anoFundacaoMIN."-01-01' AND '2100-12-31'";
							if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "anoFundacaoMAX"){
							if(!isset($dados_gerais->anoFundacaoMIN)){
								$var_sql = "dt_fundacao_osc BETWEEN '1600-01-01' AND '".$dados_gerais->anoFundacaoMAX."-12-31'";
								if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
					
					if(isset($dados_gerais->naturezaJuridica_outra)){
						if($key == "naturezaJuridica_outra"){
							if($value) $var_sql = "(tx_nome_natureza_juridica_osc != 'Associação Privada' AND
															tx_nome_natureza_juridica_osc != 'Fundação Privada' AND
															tx_nome_natureza_juridica_osc != 'Organização Religiosa' AND
															tx_nome_natureza_juridica_osc != 'Organização Social')";
		
							if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}
					if(isset($dados_gerais->naturezaJuridica_associacaoPrivada) || isset($dados_gerais->naturezaJuridica_fundacaoPrivada) || isset($dados_gerais->naturezaJuridica_organizacaoReligiosa) || isset($dados_gerais->naturezaJuridica_organizacaoSocial)){
					    if($key == "naturezaJuridica_associacaoPrivada"){
							if($value) $var_sql = "tx_nome_natureza_juridica_osc = 'Associação Privada'";
							 
							if(isset($dados_gerais->naturezaJuridica_fundacaoPrivada) || isset($dados_gerais->naturezaJuridica_organizacaoReligiosa) || isset($dados_gerais->naturezaJuridica_organizacaoSocial) || isset($dados_gerais->naturezaJuridica_outra)){
								$query .= $var_sql." OR ";
							}else{
								if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
						 
						if($key == "naturezaJuridica_fundacaoPrivada"){
							if($value) $var_sql = "tx_nome_natureza_juridica_osc = 'Fundação Privada'";
	
							if(isset($dados_gerais->naturezaJuridica_organizacaoReligiosa) || isset($dados_gerais->naturezaJuridica_organizacaoSocial) || isset($dados_gerais->naturezaJuridica_outra)){
								$query .= $var_sql." OR ";
							}else{
								if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
						 
						if($key == "naturezaJuridica_organizacaoReligiosa"){
							if($value) $var_sql = "tx_nome_natureza_juridica_osc = 'Organização Religiosa'";
			    	
							if(isset($dados_gerais->naturezaJuridica_organizacaoSocial) || isset($dados_gerais->naturezaJuridica_outra)){
								$query .= $var_sql." OR ";
							}else{
								if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
						 
						if($key == "naturezaJuridica_organizacaoSocial"){
							if($value) $var_sql = "tx_nome_natureza_juridica_osc = 'Organização Social'";
	
							if(isset($dados_gerais->naturezaJuridica_outra)){
								$query .= $var_sql." OR ";
							}else{
								if($count_params_dados == $count_dados_gerais && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
				}
			}
			 
			if(isset($busca->areasSubareasAtuacao)){
				$count_params_busca = $count_params_busca + 1;
				$areas_subareas_atuacao = $busca->areasSubareasAtuacao;
		
				$query .= "id_osc IN (SELECT id_osc FROM portal.vw_osc_area_atuacao WHERE ";
		
				$var_sql_cd = array();
				 
				$count_areas_atuacao = 0;
				foreach($areas_subareas_atuacao as $value)$count_areas_atuacao++;
		
				$count_params_areas = 0;
				foreach($areas_subareas_atuacao as $key => $value){
					$count_params_areas++;
					 
					if($key == "cd_area_atuacao"){
						$var_sql = $key." = ".$value;
						if($count_params_areas == $count_areas_atuacao && $count_params_busca == $count_busca) $query .=  $var_sql.")";
						else $query .=  $var_sql.") AND ";
					}
					 
					if(strstr($key, 'cd_subarea_atuacao')){
						if($value){
							$cd_subarea_atuacao = explode ("-", $key);
							array_push($var_sql_cd, $cd_subarea_atuacao);
						}
					}
				}
				 
				if(count($var_sql_cd)){
					$query .=  "id_osc IN (SELECT id_osc FROM (SELECT id_osc, array_agg(cd_subarea_atuacao) AS cd_subarea FROM portal.vw_osc_area_atuacao GROUP BY id_osc) a WHERE '{";
					foreach($var_sql_cd as $key => $value){
						$var_sql = $value[1];
						if(count($var_sql_cd)-1 != $key){
							$query .= $var_sql.",";
						}else{
							if($count_params_areas == $count_areas_atuacao && $count_params_busca == $count_busca)
								$query .=  $var_sql."}'::int[] <@ a.cd_subarea)";
								else
									$query .=  $var_sql."}'::int[] <@ a.cd_subarea) AND ";
						}
					}
				}
		
		
			}
			 
			if(isset($busca->titulacoesCertificacoes)){
				$query .=  "id_osc IN (SELECT id_osc FROM (SELECT id_osc, array_agg(cd_certificado) AS certificados FROM portal.vw_osc_certificado GROUP BY id_osc) a WHERE '{";
		
				$count_params_busca = $count_params_busca + 1;
				$titulacoes_certificacoes = $busca->titulacoesCertificacoes;
		
				$count_titulacoes = 0;
				foreach($titulacoes_certificacoes as $value)$count_titulacoes++;
		
				$count_params_titulacoes = 0;
				foreach($titulacoes_certificacoes as $key => $value){
					$count_params_titulacoes++;
					 
					if($key == "titulacao_utilidadePublicaEstadual"){
						if($value){
							$var_sql = "7";
		
							if(isset($titulacoes_certificacoes->titulacao_utilidadePublicaMunicipal) || isset($titulacoes_certificacoes->titulacao_oscip)){
								$query .= $var_sql.",";
							}else{
								if($count_params_titulacoes == $count_titulacoes && $count_params_busca == $count_busca)
									$query .=  $var_sql."}'::int[] <@ a.certificados)";
									else
										$query .=  $var_sql."}'::int[] <@ a.certificados) AND ";
							}
						}
					}
					 
					if($key == "titulacao_utilidadePublicaMunicipal"){
						if($value){
							$var_sql = "8";
		
							if(isset($titulacoes_certificacoes->titulacao_oscip)){
								$query .= $var_sql.",";
							}else{
								if($count_params_titulacoes == $count_titulacoes && $count_params_busca == $count_busca)
									$query .=  $var_sql."}'::int[] <@ a.certificados)";
									else
										$query .=  $var_sql."}'::int[] <@ a.certificados) AND ";
							}
						}
					}
					 
					if($key == "titulacao_oscip"){
						if($value){
							$var_sql = "4";
		
							if($count_params_titulacoes == $count_titulacoes && $count_params_busca == $count_busca)
								$query .=  $var_sql."}'::int[] <@ a.certificados)";
								else
									$query .=  $var_sql."}'::int[] <@ a.certificados) AND ";
						}
					}
				}
			}
			 
			if(isset($busca->relacoesTrabalhoGovernanca)){
				$count_params_busca = $count_params_busca + 1;
				$relacoes_trabalho = $busca->relacoesTrabalhoGovernanca;
				 
				$count_relacoes = 0;
				foreach($relacoes_trabalho as $value)$count_relacoes++;
				 
				$count_params_relacoes = 0;
				foreach($relacoes_trabalho as $key => $value){
					$count_params_relacoes++;
		
					if($key == "tx_nome_dirigente"){
						$query .= "id_osc IN (SELECT id_osc FROM portal.vw_osc_governanca WHERE ";
						if(isset($relacoes_trabalho->tx_cargo_dirigente)){
							$var_sql =  "unaccent(tx_nome_dirigente) ILIKE unaccent('%".$relacoes_trabalho->tx_nome_dirigente."%') AND unaccent(tx_cargo_dirigente) ILIKE unaccent('%".$relacoes_trabalho->tx_cargo_dirigente."%'))";
							if($count_params_relacoes == $count_relacoes-1 && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql =  "unaccent(tx_nome_dirigente) ILIKE unaccent('%".$relacoes_trabalho->tx_nome_dirigente."%'))";
							if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "tx_cargo_dirigente"){
							if(!isset($relacoes_trabalho->tx_nome_dirigente)){
								$query .= "id_osc IN (SELECT id_osc FROM portal.vw_osc_governanca WHERE ";
								$var_sql =  "unaccent(tx_cargo_dirigente) ILIKE unaccent('%".$relacoes_trabalho->tx_cargo_dirigente."%'))";
								if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "tx_nome_conselheiro"){
						$var_sql =  "id_osc IN (SELECT id_osc FROM portal.vw_osc_conselho_fiscal WHERE unaccent(tx_nome_conselheiro) ILIKE unaccent('%".$relacoes_trabalho->tx_nome_conselheiro."%'))";
						if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
						else $query .=  $var_sql." AND ";
					}
		
					if($key == "totalTrabalhadoresMIN"){
						if(isset($relacoes_trabalho->totalTrabalhadoresMAX)){
							$var_sql = "total_trabalhadores BETWEEN ".$relacoes_trabalho->totalTrabalhadoresMIN." AND ".$relacoes_trabalho->totalTrabalhadoresMAX;
							if($count_params_relacoes == $count_relacoes-1 && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "total_trabalhadores BETWEEN ".$relacoes_trabalho->totalTrabalhadoresMIN." AND 100000";
							if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "totalTrabalhadoresMAX"){
							if(!isset($relacoes_trabalho->totalTrabalhadoresMIN)){
								$var_sql = "total_trabalhadores BETWEEN 0 AND ".$relacoes_trabalho->totalTrabalhadoresMAX;
								if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "totalEmpregadosMIN"){
						if(isset($relacoes_trabalho->totalEmpregadosMAX)){
							$var_sql = "nr_trabalhadores_vinculo BETWEEN ".$relacoes_trabalho->totalEmpregadosMIN." AND ".$relacoes_trabalho->totalEmpregadosMAX;
							if($count_params_relacoes == $count_relacoes-1 && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "nr_trabalhadores_vinculo BETWEEN ".$relacoes_trabalho->totalEmpregadosMIN." AND 100000";
							if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "totalEmpregadosMAX"){
							if(!isset($relacoes_trabalho->totalEmpregadosMIN)){
								$var_sql = "total_trabalhadores BETWEEN 0 AND ".$relacoes_trabalho->totalEmpregadosMAX;
								if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "trabalhadoresDeficienciaMIN"){
						if(isset($relacoes_trabalho->trabalhadoresDeficienciaMAX)){
							$var_sql = "nr_trabalhadores_deficiencia BETWEEN ".$relacoes_trabalho->trabalhadoresDeficienciaMIN." AND ".$relacoes_trabalho->trabalhadoresDeficienciaMAX;
							if($count_params_relacoes == $count_relacoes-1 && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "nr_trabalhadores_deficiencia BETWEEN ".$relacoes_trabalho->trabalhadoresDeficienciaMIN." AND 100000";
							if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "trabalhadoresDeficienciaMAX"){
							if(!isset($relacoes_trabalho->trabalhadoresDeficienciaMIN)){
								$var_sql = "nr_trabalhadores_deficiencia BETWEEN 0 AND ".$relacoes_trabalho->trabalhadoresDeficienciaMAX;
								if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "trabalhadoresVoluntariosMIN"){
						if(isset($relacoes_trabalho->trabalhadoresVoluntariosMAX)){
							$var_sql = "nr_trabalhadores_voluntarios BETWEEN ".$relacoes_trabalho->trabalhadoresVoluntariosMIN." AND ".$relacoes_trabalho->trabalhadoresVoluntariosMAX;
							if($count_params_relacoes == $count_relacoes-1 && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "nr_trabalhadores_voluntarios BETWEEN ".$relacoes_trabalho->trabalhadoresVoluntariosMIN." AND 100000";
							if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "trabalhadoresVoluntariosMAX"){
							if(!isset($relacoes_trabalho->trabalhadoresVoluntariosMIN)){
								$var_sql = "nr_trabalhadores_voluntarios BETWEEN 0 AND ".$relacoes_trabalho->trabalhadoresVoluntariosMAX;
								if($count_params_relacoes == $count_relacoes && $count_params_busca == $count_busca) $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
				}
			}
			 
			if(isset($busca->espacosParticipacaoSocial)){
				$count_params_busca = $count_params_busca + 1;
				$participacao_social = $busca->espacosParticipacaoSocial;
				 
				$count_participacao = 0;
				foreach($participacao_social as $value)$count_participacao++;
				 
				$count_params_participacao = 0;
				foreach($participacao_social as $key => $value){
					$count_params_participacao++;
		
					if(isset($participacao_social->cd_conselho) || isset($participacao_social->dt_data_inicio_conselho) || isset($participacao_social->cd_tipo_participacao) || isset($participacao_social->dt_data_fim_conselho)){
						$var_sql =  "id_osc IN (SELECT id_osc FROM portal.vw_osc_participacao_social_conselho WHERE ";
						if($key == "cd_conselho"){
							$query .=  $var_sql."cd_conselho = ".$participacao_social->cd_conselho;
							if(isset($participacao_social->dt_data_inicio_conselho) || isset($participacao_social->dt_data_fim_conselho) || isset($participacao_social->tx_nome_representante_conselho) || isset($participacao_social->cd_tipo_participacao)){
								$query .= " AND ";
							}else{
								if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
								else $query .= ")) AND ";
							}
		
						}
		
						if($key == "dt_data_inicio_conselho"){
							if(isset($participacao_social->cd_conselho)){
								$query .= "dt_data_inicio_conselho = TO_CHAR(TO_DATE('".$participacao_social->dt_data_inicio_conselho."', 'DD-MM-YYYY'), 'DD-MM-YYYY')";
							}else{
								$query .= $var_sql."dt_data_inicio_conselho = TO_CHAR(TO_DATE('".$participacao_social->dt_data_inicio_conselho."', 'DD-MM-YYYY'), 'DD-MM-YYYY')";
							}
								
							if(isset($participacao_social->dt_data_fim_conselho) || isset($participacao_social->tx_nome_representante_conselho) || isset($participacao_social->cd_tipo_participacao)){
								$query .= " AND ";
							}else{
								if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
								else $query .= ")) AND ";
							}
						}
		
						if($key == "cd_tipo_participacao"){
							if(isset($participacao_social->cd_conselho) || isset($participacao_social->dt_data_inicio_conselho)){
								$query .= "cd_tipo_participacao = ".$participacao_social->cd_tipo_participacao;
							}else{
								$query .= $var_sql."cd_tipo_participacao = ".$participacao_social->cd_tipo_participacao;
							}
								
							if(isset($participacao_social->dt_data_fim_conselho) || isset($participacao_social->tx_nome_representante_conselho)){
								$query .= " AND ";
							}else{
								if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
								else $query .= ")) AND ";
							}
		
						}
		
						if($key == "dt_data_fim_conselho"){
							if(isset($participacao_social->cd_conselho) || isset($participacao_social->dt_data_inicio_conselho) || isset($participacao_social->cd_tipo_participacao)){
								$query .= "dt_data_fim_conselho = TO_CHAR(TO_DATE('".$participacao_social->dt_data_fim_conselho."', 'DD-MM-YYYY'), 'DD-MM-YYYY')";
							}else{
								$query .= $var_sql."dt_data_fim_conselho = TO_CHAR(TO_DATE('".$participacao_social->dt_data_fim_conselho."', 'DD-MM-YYYY'), 'DD-MM-YYYY')";
							}
								
							if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
							else $query .= ")) AND ";
						}
					}
					 
					if($key == "tx_nome_representante_conselho"){
						$query .= "id_osc IN (SELECT id_osc FROM portal.vw_osc_representante_conselho WHERE unaccent(tx_nome_representante_conselho) ILIKE unaccent('%".$participacao_social->tx_nome_representante_conselho."%'))";
						 
						if(isset($participacao_social->dt_data_fim_conselho) || isset($participacao_social->cd_tipo_participacao)){
							$query .= " AND ";
						}else{
							if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
							else $query .= ")) AND ";
						}
					}
					 
					if(isset($participacao_social->cd_conferencia) || isset($participacao_social->cd_forma_participacao_conferencia) || isset($participacao_social->anoRealizacaoConferenciaMIN) || isset($participacao_social->anoRealizacaoConferenciaMAX)){
						$var_sql =  "id_osc IN (SELECT id_osc FROM portal.vw_osc_participacao_social_conferencia WHERE ";
						if($key == "cd_conferencia"){
							$query .=  $var_sql."cd_conferencia = ".$participacao_social->cd_conferencia;
							if(isset($participacao_social->cd_forma_participacao_conferencia) || isset($participacao_social->anoRealizacaoConferenciaMIN) || isset($participacao_social->anoRealizacaoConferenciaMAX)){
								$query .= " AND ";
							}else{
								if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
								else $query .= ")) AND ";
							}
						}
		
						if($key == "cd_forma_participacao_conferencia"){
							if(isset($participacao_social->cd_conferencia)){
								$query .= "cd_forma_participacao_conferencia = ".$participacao_social->cd_forma_participacao_conferencia;
							}else{
								$query .= $var_sql."cd_forma_participacao_conferencia = ".$participacao_social->cd_forma_participacao_conferencia;
							}
							 
							if(isset($participacao_social->anoRealizacaoConferenciaMIN) || isset($participacao_social->anoRealizacaoConferenciaMAX)){
								$query .= " AND ";
							}else{
								if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
								else $query .= ")) AND ";
							}
						}
		
						if($key == "anoRealizacaoConferenciaMIN"){
							if(isset($participacao_social->cd_conferencia) || isset($participacao_social->cd_forma_participacao_conferencia)){
								if(isset($participacao_social->anoRealizacaoConferenciaMAX)){
									$query .= "TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-".$participacao_social->anoRealizacaoConferenciaMIN."' AND '31-12-".$participacao_social->anoRealizacaoConferenciaMAX."'";
									if($count_params_participacao == $count_participacao-1 && $count_params_busca == $count_busca) $query .= "))";
									else $query .= ")) AND ";
								}else{
									$query .= "TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-".$participacao_social->anoRealizacaoConferenciaMIN."' AND '31-12-2100'";
									if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
									else $query .= ")) AND ";
								}
							}else{
								if(isset($participacao_social->anoRealizacaoConferenciaMAX)){
									$query .= $var_sql."TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-".$participacao_social->anoRealizacaoConferenciaMIN."' AND '31-12-".$participacao_social->anoRealizacaoConferenciaMAX."'";
									if($count_params_participacao == $count_participacao-1 && $count_params_busca == $count_busca) $query .= "))";
									else $query .= ")) AND ";
								}else{
									$query .= $var_sql."TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-".$participacao_social->anoRealizacaoConferenciaMIN."' AND '31-12-2100'";
									if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
									else $query .= ")) AND ";
								}
							}
						}else{
							if(isset($participacao_social->cd_conferencia) || isset($participacao_social->cd_forma_participacao_conferencia)){
								if($key == "anoRealizacaoConferenciaMAX"){
									if(!isset($participacao_social->anoRealizacaoConferenciaMIN)){
										$query .= "TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-1600' AND '31-12-".$participacao_social->anoRealizacaoConferenciaMAX."'";
										if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
										else $query .= ")) AND ";
									}
								}
							}else{
								if($key == "anoRealizacaoConferenciaMAX"){
									if(!isset($participacao_social->anoRealizacaoConferenciaMIN)){
										$query .= $var_sql."TO_CHAR(TO_DATE(dt_ano_realizacao, 'DD-MM-YYYY'), 'DD-MM-YYYY') BETWEEN '01-01-1600' AND '31-12-".$participacao_social->anoRealizacaoConferenciaMAX."'";
										if($count_params_participacao == $count_participacao && $count_params_busca == $count_busca) $query .= "))";
										else $query .= ")) AND ";
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
				foreach($projetos as $value)$count_projetos++;
				 
				$count_params_projetos = 0;
				foreach($projetos as $key => $value){
					$count_params_projetos++;
					 
					if($key == "tx_nome_projeto"){
						$var_sql = "unaccent(".$key.") ILIKE unaccent('%".$value."%')";
						if(isset($projetos->cd_status_projeto) || isset($projetos->dt_data_inicio_projeto) || isset($projetos->dt_data_fim_projeto) || isset($projetos->cd_abrangencia_projeto) || isset($projetos->cd_zona_atuacao_projeto)){
							$query .= $var_sql." AND ";
						}else{
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}
					}
					 
					if($key == "cd_status_projeto"){
						$var_sql = $key." = ".$value;
						if(isset($projetos->dt_data_inicio_projeto) || isset($projetos->dt_data_fim_projeto) || isset($projetos->cd_abrangencia_projeto) || isset($projetos->cd_zona_atuacao_projeto)){
							$query .= $var_sql." AND ";
						}else{
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}
					}
					 
					if($key == "dt_data_inicio_projeto"){
						$var_sql = "dt_data_inicio_projeto = TO_CHAR(TO_DATE('".$projetos->dt_data_inicio_projeto."', 'DD-MM-YYYY'), 'DD-MM-YYYY')";
						if(isset($projetos->dt_data_fim_projeto) || isset($projetos->cd_abrangencia_projeto) || isset($projetos->cd_zona_atuacao_projeto)){
							$query .= $var_sql." AND ";
						}else{
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}
					}
					 
					if($key == "dt_data_fim_projeto"){
						$var_sql = "dt_data_fim_projeto = TO_CHAR(TO_DATE('".$projetos->dt_data_fim_projeto."', 'DD-MM-YYYY'), 'DD-MM-YYYY')";
						if(isset($projetos->cd_abrangencia_projeto) || isset($projetos->cd_zona_atuacao_projeto)){
							$query .= $var_sql." AND ";
						}else{
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}
					}
					 
					if($key == "cd_abrangencia_projeto"){
						$var_sql = $key." = ".$value;
						if(isset($projetos->cd_zona_atuacao_projeto)){
							$query .= $var_sql." AND ";
						}else{
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}
					}
					 
					if($key == "cd_zona_atuacao_projeto"){
						$var_sql = $key." = ".$value;
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
						else $query .=  $var_sql." AND ";
		
					}
					 
					if($key == "cd_origem_fonte_recursos_projeto"){
						$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_fonte_recursos_projeto WHERE ".$key." = ".$value.")";
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
						else $query .=  $var_sql." AND ";
					}
					 
					if($key == "tx_nome_financiador"){
						$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_financiador_projeto WHERE unaccent(".$key.") ILIKE unaccent('%".$value."%'))";
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
						else $query .=  $var_sql." AND ";
					}
					 
					if($key == "tx_nome_regiao_localizacao_projeto"){
						$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_localizacao_projeto WHERE unaccent(".$key.") ILIKE unaccent('%".$value."%'))";
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
						else $query .=  $var_sql." AND ";
					}
					 
					if($key == "tx_nome_publico_beneficiado"){
						$var_pub = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_publico_beneficiado_projeto WHERE ";
						$var_sql = $var_pub."unaccent(".$key.") ILIKE unaccent('%".$value."%')";
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
						else $query .=  $var_sql.") AND ";
					}
					 
					if($key == "tx_nome_osc_parceira_projeto"){
						$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_parceira_projeto WHERE unaccent(".$key.") ILIKE unaccent('%".$value."%'))";
						if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
						else $query .=  $var_sql." AND ";
					}
					 
					if($key == "totalBeneficiariosMIN"){
						if(isset($projetos->totalBeneficiariosMAX)){
							$var_sql = "nr_total_beneficiarios BETWEEN ".$projetos->totalBeneficiariosMIN." AND ".$projetos->totalBeneficiariosMAX."";
		
							if($count_params_projetos == $count_projetos-1 && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "nr_total_beneficiarios BETWEEN ".$projetos->totalBeneficiariosMIN." AND 100000";
		
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "totalBeneficiariosMAX"){
							if(!isset($projetos->totalBeneficiariosMIN)){
								$var_sql = "nr_total_beneficiarios BETWEEN 0 AND ".$projetos->totalBeneficiariosMAX."";
								 
								if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
								else $query .=  $var_sql." AND ";
							}
						}
					}
						
					if($key == "cd_objetivo_projeto"){
						if(isset($projetos->cd_meta_projeto)){
							$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_objetivo_projeto WHERE ".$key." = ".$value." AND cd_meta_projeto = ".$projetos->cd_meta_projeto.")";
							if($count_params_projetos == $count_projetos-1 && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_objetivo_projeto WHERE ".$key." = ".$value.")";
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "cd_meta_projeto"){
							if(!isset($projetos->cd_objetivo_projeto)){
								$var_sql = "id_projeto IN (SELECT id_projeto FROM portal.vw_osc_objetivo_projeto WHERE ".$key." = ".$value.")";
								if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
								else $query .=  $var_sql." AND ";
							}
						}
					}
					 
					if($key == "valorTotalMIN"){
						if(isset($projetos->valorTotalMAX)){
							$var_sql = "cast(nr_valor_total_projeto as double precision) BETWEEN ".$this->Getfloat($projetos->valorTotalMIN)." AND ".$this->Getfloat($projetos->valorTotalMAX)."";
							if($count_params_projetos == $count_projetos-1 && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "cast(nr_valor_total_projeto as double precision) BETWEEN ".$this->Getfloat($projetos->valorTotalMIN)." AND 1000000";
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "valorTotalMAX"){
							if(!isset($projetos->valorTotalMIN)){
								$var_sql = "cast(nr_valor_total_projeto as double precision) BETWEEN 0 AND ".$this->Getfloat($projetos->valorTotalMAX)."";
								if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
								else $query .=  $var_sql." AND ";
							}
						}
					}
					 
					if($key == "valorRecebidoMIN"){
						if(isset($projetos->valorRecebidoMAX)){
							$var_sql = "cast(nr_valor_captado_projeto as double precision) BETWEEN ".$this->Getfloat($projetos->valorRecebidoMIN)." AND ".$this->Getfloat($projetos->valorRecebidoMAX)."";
							if($count_params_projetos == $count_projetos-1 && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql.") AND ";
						}else{
							$var_sql = "cast(nr_valor_captado_projeto as double precision) BETWEEN ".$this->Getfloat($projetos->valorRecebidoMIN)." AND 1000000";
							if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql.") AND ";
						}
					}else{
						if($key == "valorRecebidoMAX"){
							if(!isset($projetos->valorRecebidoMIN)){
								$var_sql = "cast(nr_valor_captado_projeto as double precision) BETWEEN 0 AND ".$this->Getfloat($projetos->valorRecebidoMAX)."";
								if($count_params_projetos == $count_projetos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
								else $query .=  $var_sql.") AND ";
							}
						}
					}
				}
			}
		
			if(isset($busca->fontesRecursos)){
				$count_params_busca = $count_params_busca + 1;
				$fontes_recursos = $busca->fontesRecursos;
				 
				$count_fontes_recursos = 0;
				foreach($fontes_recursos as $value)$count_fontes_recursos++;
				 
				$count_params_recursos = 0;
				foreach($fontes_recursos as $key => $value){
					$count_params_recursos++;
					$var_rec = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE ";
		
					if($key == "anoFonteRecursoMIN"){
						if(isset($fontes_recursos->anoFonteRecursoMAX)){
							$var_sql = $var_rec."cast(dt_ano_recursos_osc as integer) BETWEEN ".$fontes_recursos->anoFonteRecursoMIN." AND ".$fontes_recursos->anoFonteRecursoMAX;
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = $var_rec."cast(dt_ano_recursos_osc as integer) BETWEEN ".$fontes_recursos->anoFonteRecursoMIN." AND 2100";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "anoFonteRecursoMAX"){
							if(!isset($fontes_recursos->anoFonteRecursoMIN)){
								$var_sql = $var_rec."cast(dt_ano_recursos_osc as integer) BETWEEN 1600 AND ".$fontes_recursos->anoFonteRecursoMAX;
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) $query .=  $var_sql.")";
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "rendimentosFinanceirosReservasContasCorrentesPropriasMIN"){
						if(isset($fontes_recursos->rendimentosFinanceirosReservasContasCorrentesPropriasMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 196 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->rendimentosFinanceirosReservasContasCorrentesPropriasMIN)." AND ".$this->Getfloat($fontes_recursos->rendimentosFinanceirosReservasContasCorrentesPropriasMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 196 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->rendimentosFinanceirosReservasContasCorrentesPropriasMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "rendimentosFinanceirosReservasContasCorrentesPropriasMAX"){
							if(!isset($fontes_recursos->rendimentosFinanceirosReservasContasCorrentesPropriasMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 196 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->rendimentosFinanceirosReservasContasCorrentesPropriasMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "rendimentosFundosPatrimoniaisMIN"){
						if(isset($fontes_recursos->rendimentosFundosPatrimoniaisMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 195 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->rendimentosFundosPatrimoniaisMIN)." AND ".$this->Getfloat($fontes_recursos->rendimentosFundosPatrimoniaisMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca)
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 195 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->rendimentosFundosPatrimoniaisMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca)
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "rendimentosFundosPatrimoniaisMAX"){
							if(!isset($fontes_recursos->rendimentosFundosPatrimoniaisMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 195 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->rendimentosFundosPatrimoniaisMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "mensalidadesContribuicoesAssociadosMIN"){
						if(isset($fontes_recursos->mensalidadesContribuicoesAssociadosMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 197 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->mensalidadesContribuicoesAssociadosMIN)." AND ".$this->Getfloat($fontes_recursos->mensalidadesContribuicoesAssociadosMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 197 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->mensalidadesContribuicoesAssociadosMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "mensalidadesContribuicoesAssociadosMAX"){
							if(!isset($fontes_recursos->mensalidadesContribuicoesAssociadosMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 197 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->mensalidadesContribuicoesAssociadosMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "vendaBensDireitosMIN"){
						if(isset($fontes_recursos->vendaBensDireitosMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 201 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->vendaBensDireitosMIN)." AND ".$this->Getfloat($fontes_recursos->vendaBensDireitosMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 201 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->vendaBensDireitosMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "vendaBensDireitosMAX"){
							if(!isset($fontes_recursos->vendaBensDireitosMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 201 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->vendaBensDireitosMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "premiosRecebidosMIN"){
						if(isset($fontes_recursos->premiosRecebidosMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 198 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->premiosRecebidosMIN)." AND ".$this->Getfloat($fontes_recursos->premiosRecebidosMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 198 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->premiosRecebidosMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "premiosRecebidosMAX"){
							if(!isset($fontes_recursos->premiosRecebidosMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 198 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->premiosRecebidosMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "vendaProdutosMIN"){
						if(isset($fontes_recursos->vendaProdutosMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 199 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->vendaProdutosMIN)." AND ".$this->Getfloat($fontes_recursos->vendaProdutosMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 199 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->vendaProdutosMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "vendaProdutosMAX"){
							if(!isset($fontes_recursos->vendaProdutosMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 199 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->vendaProdutosMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "prestacaoServicosMIN"){
						if(isset($fontes_recursos->prestacaoServicosMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 200 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->prestacaoServicosMIN)." AND ".$this->Getfloat($fontes_recursos->prestacaoServicosMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 200 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->prestacaoServicosMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "prestacaoServicosMAX"){
							if(!isset($fontes_recursos->prestacaoServicosMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 200 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->prestacaoServicosMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "empresasPublicasSociedadesEconomiaMistaMIN"){
						if(isset($fontes_recursos->empresasPublicasSociedadesEconomiaMistaMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 185 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->empresasPublicasSociedadesEconomiaMistaMIN)." AND ".$this->Getfloat($fontes_recursos->empresasPublicasSociedadesEconomiaMistaMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 185 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->empresasPublicasSociedadesEconomiaMistaMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "empresasPublicasSociedadesEconomiaMistaMAX"){
							if(!isset($fontes_recursos->empresasPublicasSociedadesEconomiaMistaMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 185 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->empresasPublicasSociedadesEconomiaMistaMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "acordoOrganismosMultilateraisMIN"){
						if(isset($fontes_recursos->acordoOrganismosMultilateraisMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 183 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->acordoOrganismosMultilateraisMIN)." AND ".$this->Getfloat($fontes_recursos->acordoOrganismosMultilateraisMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 183 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->acordoOrganismosMultilateraisMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "acordoOrganismosMultilateraisMAX"){
							if(!isset($fontes_recursos->acordoOrganismosMultilateraisMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 183 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->acordoOrganismosMultilateraisMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "parceriaGovernoFederalMIN"){
						if(isset($fontes_recursos->parceriaGovernoFederalMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 180 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaGovernoFederalMIN)." AND ".$this->Getfloat($fontes_recursos->parceriaGovernoFederalMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 180 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaGovernoFederalMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "parceriaGovernoFederalMAX"){
							if(!isset($fontes_recursos->parceriaGovernoFederalMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 180 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->parceriaGovernoFederalMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "parceriaGovernoEstadualMIN"){
						if(isset($fontes_recursos->parceriaGovernoEstadualMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 181 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaGovernoEstadualMIN)." AND ".$this->Getfloat($fontes_recursos->parceriaGovernoEstadualMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 181 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaGovernoEstadualMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "parceriaGovernoEstadualMAX"){
							if(!isset($fontes_recursos->parceriaGovernoEstadualMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 181 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->parceriaGovernoEstadualMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "parceriaGovernoMunicipalMIN"){
						if(isset($fontes_recursos->parceriaGovernoMunicipalMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 182 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaGovernoMunicipalMIN)." AND ".$this->Getfloat($fontes_recursos->parceriaGovernoMunicipalMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 182 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaGovernoMunicipalMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "parceriaGovernoMunicipalMAX"){
							if(!isset($fontes_recursos->parceriaGovernoMunicipalMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 182 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->parceriaGovernoMunicipalMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "acordoGovernosEstrangeirosMIN"){
						if(isset($fontes_recursos->acordoGovernosEstrangeirosMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 184 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->acordoGovernosEstrangeirosMIN)." AND ".$this->Getfloat($fontes_recursos->acordoGovernosEstrangeirosMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 184 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->acordoGovernosEstrangeirosMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "acordoGovernosEstrangeirosMAX"){
							if(!isset($fontes_recursos->acordoGovernosEstrangeirosMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 184 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->acordoGovernosEstrangeirosMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "parceriaOscBrasileirasMIN"){
						if(isset($fontes_recursos->parceriaOscBrasileirasMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 186 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaOscBrasileirasMIN)." AND ".$this->Getfloat($fontes_recursos->parceriaOscBrasileirasMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 186 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaOscBrasileirasMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "parceriaOscBrasileirasMAX"){
							if(!isset($fontes_recursos->parceriaOscBrasileirasMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 186 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->parceriaOscBrasileirasMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "parceriaOscEstrangeirasMIN"){
						if(isset($fontes_recursos->parceriaOscEstrangeirasMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 187 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaOscEstrangeirasMIN)." AND ".$this->Getfloat($fontes_recursos->parceriaOscEstrangeirasMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 187 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaOscEstrangeirasMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "parceriaOscEstrangeirasMAX"){
							if(!isset($fontes_recursos->parceriaOscEstrangeirasMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 187 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->parceriaOscEstrangeirasMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "parceriaOrganizacoesReligiosasBrasileirasMIN"){
						if(isset($fontes_recursos->parceriaOrganizacoesReligiosasBrasileirasMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 188 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaOrganizacoesReligiosasBrasileirasMIN)." AND ".$this->Getfloat($fontes_recursos->parceriaOrganizacoesReligiosasBrasileirasMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 188 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaOrganizacoesReligiosasBrasileirasMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "parceriaOrganizacoesReligiosasBrasileirasMAX"){
							if(!isset($fontes_recursos->parceriaOrganizacoesReligiosasBrasileirasMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 188 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->parceriaOrganizacoesReligiosasBrasileirasMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "parceriaOrganizacoesReligiosasEstrangeirasMIN"){
						if(isset($fontes_recursos->parceriaOrganizacoesReligiosasEstrangeirasMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 189 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaOrganizacoesReligiosasEstrangeirasMIN)." AND ".$this->Getfloat($fontes_recursos->parceriaOrganizacoesReligiosasEstrangeirasMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 189 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->parceriaOrganizacoesReligiosasEstrangeirasMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "parceriaOrganizacoesReligiosasEstrangeirasMAX"){
							if(!isset($fontes_recursos->parceriaOrganizacoesReligiosasEstrangeirasMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 189 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->parceriaOrganizacoesReligiosasEstrangeirasMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "empresasPrivadasBrasileirasMIN"){
						if(isset($fontes_recursos->empresasPrivadasBrasileirasMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 190 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->empresasPrivadasBrasileirasMIN)." AND ".$this->Getfloat($fontes_recursos->empresasPrivadasBrasileirasMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 190 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->empresasPrivadasBrasileirasMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "empresasPrivadasBrasileirasMAX"){
							if(!isset($fontes_recursos->empresasPrivadasBrasileirasMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 190 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->empresasPrivadasBrasileirasMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "EmpresasEstrangeirasMIN"){
						if(isset($fontes_recursos->EmpresasEstrangeirasMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 191 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->EmpresasEstrangeirasMIN)." AND ".$this->Getfloat($fontes_recursos->EmpresasEstrangeirasMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 191 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->EmpresasEstrangeirasMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "EmpresasEstrangeirasMAX"){
							if(!isset($fontes_recursos->EmpresasEstrangeirasMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 191 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->EmpresasEstrangeirasMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "doacoesPessoaJuridicaMIN"){
						if(isset($fontes_recursos->doacoesPessoaJuridicaMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 192 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->doacoesPessoaJuridicaMIN)." AND ".$this->Getfloat($fontes_recursos->doacoesPessoaJuridicaMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 192 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->doacoesPessoaJuridicaMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "doacoesPessoaJuridicaMAX"){
							if(!isset($fontes_recursos->doacoesPessoaJuridicaMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 192 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->doacoesPessoaJuridicaMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "doacoesPessoaFisicaMIN"){
						if(isset($fontes_recursos->doacoesPessoaFisicaMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 193 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->doacoesPessoaFisicaMIN)." AND ".$this->Getfloat($fontes_recursos->doacoesPessoaFisicaMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 193 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->doacoesPessoaFisicaMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "doacoesPessoaFisicaMAX"){
							if(!isset($fontes_recursos->doacoesPessoaFisicaMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 193 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->doacoesPessoaFisicaMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "doacoesRecebidasFormaProdutosServicosComNFMIN"){
						if(isset($fontes_recursos->doacoesRecebidasFormaProdutosServicosComNFMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 194 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->doacoesRecebidasFormaProdutosServicosComNFMIN)." AND ".$this->Getfloat($fontes_recursos->doacoesRecebidasFormaProdutosServicosComNFMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 194 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->doacoesRecebidasFormaProdutosServicosComNFMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "doacoesRecebidasFormaProdutosServicosComNFMAX"){
							if(!isset($fontes_recursos->doacoesRecebidasFormaProdutosServicosComNFMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 194 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->doacoesRecebidasFormaProdutosServicosComNFMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "voluntariadoMIN"){
						if(isset($fontes_recursos->voluntariadoMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 202 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->voluntariadoMIN)." AND ".$this->Getfloat($fontes_recursos->voluntariadoMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 202 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->voluntariadoMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "voluntariadoMAX"){
							if(!isset($fontes_recursos->voluntariadoMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 202 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->voluntariadoMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "isencoesMIN"){
						if(isset($fontes_recursos->isencoesMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 203 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->isencoesMIN)." AND ".$this->Getfloat($fontes_recursos->isencoesMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 203 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->isencoesMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "isencoesMAX"){
							if(!isset($fontes_recursos->isencoesMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 203 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->isencoesMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "imunidadesMIN"){
						if(isset($fontes_recursos->imunidadesMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 204 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->imunidadesMIN)." AND ".$this->Getfloat($fontes_recursos->imunidadesMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 204 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->imunidadesMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "imunidadesMAX"){
							if(!isset($fontes_recursos->imunidadesMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 204 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->imunidadesMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "bensRecebidosDireitoUsoMIN"){
						if(isset($fontes_recursos->bensRecebidosDireitoUsoMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 205 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->bensRecebidosDireitoUsoMIN)." AND ".$this->Getfloat($fontes_recursos->bensRecebidosDireitoUsoMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 205 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->bensRecebidosDireitoUsoMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "bensRecebidosDireitoUsoMAX"){
							if(!isset($fontes_recursos->bensRecebidosDireitoUsoMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 205 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->bensRecebidosDireitoUsoMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
		
					if($key == "doacoesRecebidasFormaProdutosServicosSemNFMIN"){
						if(isset($fontes_recursos->doacoesRecebidasFormaProdutosServicosSemNFMAX)){
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 206 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->doacoesRecebidasFormaProdutosServicosSemNFMIN)." AND ".$this->Getfloat($fontes_recursos->doacoesRecebidasFormaProdutosServicosSemNFMAX).")";
							if($count_params_recursos == $count_fontes_recursos-1 && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}else{
							$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 206 AND nr_valor_recursos_osc BETWEEN ".$this->Getfloat($fontes_recursos->doacoesRecebidasFormaProdutosServicosSemNFMIN)." AND 1000000)";
							if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
								if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
								else $query .=  $var_sql;
							else $query .=  $var_sql." AND ";
						}
					}else{
						if($key == "doacoesRecebidasFormaProdutosServicosSemNFMAX"){
							if(!isset($fontes_recursos->doacoesRecebidasFormaProdutosServicosSemNFMIN)){
								$var_sql = "id_osc IN (SELECT id_osc FROM portal.vw_osc_recursos_osc WHERE cd_fonte_recursos_osc = 206 AND nr_valor_recursos_osc BETWEEN 0 AND ".$this->Getfloat($fontes_recursos->doacoesRecebidasFormaProdutosServicosSemNFMAX).")";
								if($count_params_recursos == $count_fontes_recursos && $count_params_busca == $count_busca) 
									if(isset($fontes_recursos->anoFonteRecursoMIN) || isset($fontes_recursos->anoFonteRecursoMAX)) $query .=  $var_sql.")";
									else $query .=  $var_sql;
								else $query .=  $var_sql." AND ";
							}
						}
					}
				}
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
		    
			$query .= ') ORDER BY vw_busca_resultado.id_osc '.$query_limit;
			
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
			$query = str_replace('tx_nome_natureza_juridica_osc != \'Organização Social\') AND', 'tx_nome_natureza_juridica_osc != \'Organização Social\')) AND', $query);
			$query = str_replace('tx_nome_natureza_juridica_osc != \'Organização Social\')) ORDER', 'tx_nome_natureza_juridica_osc != \'Organização Social\'))) ORDER', $query);
			
			$result = $this->executarQuery($query, false);
	        
			if($result > 0){
				if($type_result == 'lista'){
					$result = $this->configResultLista($result);
				}else if($type_result == 'geo'){
					$result = $this->configResultGeo($result);
				}
				
				return $result;
			}else{
				return "Nenhuma Organização encontrada!";
			}
		}
	}
}
