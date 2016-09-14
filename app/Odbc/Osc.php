<?php

namespace App\Odbc;

use DB;

class Osc
{
	public function getOsc($id)
	{
		$dadosGerais = DB::select('SELECT im_imagem AS "logo",
									 bosc_nr_identificacao AS "cnpj",
									 bosc_nm_osc AS "razoSocial",
							 		 bosc_nm_fantasia_osc AS "nomeFantasia",
									 dcnj_nm_natureza_juridica AS "naturezaJuridica",
							 		 dcsc_nm_subclasse AS "atividadeEconomica",
									 ospr_dt_ano_fundacao AS "anoFundacao",
							 		 ospr_ee_site AS "site",
									 ospr_tx_descricao AS "descricao"
							  FROM portal.vm_osc_principal
							  WHERE bosc_sq_osc = ?::int', [$id]);
		
		$enderecos = DB::select('SELECT a.loca_ds_endereco AS "logradouro",
									 b.edmu_nm_municipio AS "municipio",
									 c.eduf_sg_uf AS "uf"
							  FROM data.tb_localizacao a
							  LEFT JOIN spat.ed_municipio b
							  ON a.edmu_cd_municipio = b.edmu_cd_municipio
							  LEFT JOIN spat.ed_uf c
							  ON b.eduf_cd_uf = c.eduf_cd_uf
							  WHERE a.bosc_sq_osc = ?::int
							  AND a.mdfd_cd_fonte_dados = 1', [$id]);
		
		$contatos = DB::select('SELECT cont_ee_email AS "email"
	    					  FROM data.tb_contatos
	    					  WHERE bosc_sq_osc = ?::int
	    					  AND mdfd_cd_fonte_dados = 1', [$id]);
		
		$vinculos = DB::select('SELECT rais_qt_vinculo_clt AS "clt",
									 rais_qt_vinculo_voluntario AS "voluntarios",
									 rais_qt_vinculo_deficiente AS "deficientes"
							  FROM data.tb_osc_rais
							  WHERE bosc_sq_osc = ?::int', [$id]);
		
		$dirigentes = DB::select('SELECT cargo AS "cargo",
									 nome AS "nome"
							  FROM data.tb_osc_diretor
							  WHERE bosc_sq_osc = ?::int', [$id]);
		
		$recursos = DB::select('SELECT vl_valor_parcerias_federal AS "federal",
									 vl_valor_parcerias_estadual AS "estadual",
									 vl_valor_parcerias_municipal AS "municipal"
							  FROM portal.vm_osc_principal
							  WHERE bosc_sq_osc = ?::int', [$id]);
		
		$conselhos = DB::select('SELECT cons_nm_conselho AS "nomeConselho"
							  FROM data.nm_osc_conselho AS a
							  INNER JOIN data.tb_conselhos AS b
							  ON a.cons_cd_conselho = b.cons_cd_conselho
							  WHERE bosc_sq_osc = ?::int', [$id]);
		
		$projetos = DB::select('SELECT proj_cd_projeto AS "id",
									   titulo AS "titulo",
									   status AS "status",
									   data_inicio AS "dataInicio",
									   data_fim AS "dataFinal",
	    							   valor_total AS "valorTotal",
									   fonte_recurso AS "fonteRecursos",
									   link AS "link",
									   publico_alvo AS "publicoBeneficiado",
									   abrangencia AS "abrangencia",
	    							   financiadores AS "financiadores",
									   descricao AS "descricao"
								FROM data.tb_osc_projeto
								WHERE proj_cd_projeto IN (
									SELECT proj_cd_projeto
									FROM data.tb_ternaria_projeto
									WHERE bosc_sq_osc = ?::int
								)', [$id]);
		/*
		$localizacaoProjetos = array();
		foreach ($projetos as $value){
			$idLoc = DB::select('SELECT edre_cd_regiao,
										eduf_cd_uf,
										edmu_cd_municipio
			    				  FROM data.tb_osc_projeto_loc
			    				  WHERE proj_cd_projeto = ?::int', [$value->id]);
			
			if($idLoc[0]->edre_cd_regiao != null){
				$loc = DB::select('SELECT edre_cd_regiao AS "codigo", 
										  edre_nm_regiao AS "nome"
								   FROM spat.ed_regiao
								   WHERE edre_cd_regiao = ?::int', [$idLoc[0]->edre_cd_regiao]);
			}
			elseif ($idLoc[0]->eduf_cd_uf != null) {
				$loc = DB::select('SELECT eduf_cd_uf AS "codigo",
										  eduf_nm_uf AS "nome"
								   FROM spat.ed_uf
								   WHERE eduf_cd_uf = ?::int', [$idLoc[0]->eduf_cd_uf]);
			}
			elseif ($idLoc[0]->edmu_cd_municipio != null) {
				$loc = DB::select('SELECT edmu_cd_municipio AS "codigo", 
										  edmu_nm_municipio AS "nome" 
								   FROM spat.ed_municipio 
								   WHERE edmu_cd_municipio = ?::int', [$idLoc[0]->edmu_cd_municipio]);
			}
			array_push($localizacaoProjetos, $loc);
		}
		*/
		
// 		$result = '{
// 				       dadosGerais: '.json_encode($dadosGerais).'
// 					   endereco: '.json_encode($enderecos).'
// 					   contatos: '.json_encode($contatos).'
// 					   vinculos: '.json_encode($vinculos).'
// 					   dirigentes: '.json_encode($dirigentes).'
// 					   recursos: '.json_encode($recursos).'
// 					   conselhos: '.json_encode($conselhos).'
// 					}';
		
		$result = '{
			"bosc_sq_osc": 281141,
			"bosc_nr_identificacao": "1705989000100",
			"dcti_cd_tipo": 1,
			"bosc_nm_osc": "ASSOCIACAO BRASILEIRA TERRA DOS HOMENS.",
			"bosc_nm_fantasia_osc": "TERRA DOS HOMENS",
			"ospr_tx_descricao": "123",
			"ospr_ds_endereco": "AV GENERAL JUSTO 275",
			"ospr_ds_endereco_complemento": null,
			"ospr_nm_bairro": "CENTRO",
			"ospr_nm_municipio": "Rio de Janeiro",
			"ospr_sg_uf": "RJ",
			"ospr_nm_cep": "20021130",
			"ospr_geometry": "010100002042120000B4493437959545C0E9EDCF4543E836C0",
			"ospr_cd_municipio": "3304557",
			"dcsc_cd_alpha_subclasse": "8800-6/00",
			"dcsc_nm_subclasse": "Serviços de assistência social sem alojamento",
			"dcte_ds_tamanho_estabelecimento": "De 10 a 19",
			"dcnj_cd_alpha_natureza_juridica": "399-9",
			"dcnj_nm_natureza_juridica": "Associação Privada",
			"ospr_dt_ano_fundacao": null,
			"ospr_ee_site": null,
			"ospr_fonte_recurso": null,
			"vl_valor_parcerias_total": null,
			"vl_valor_parcerias_federal": null,
			"vl_valor_parcerias_estadual": null,
			"vl_valor_parcerias_municipal": null,
			"im_imagem": null,
			"ee_facebook": "",
			"ee_google": "",
			"ee_linkedin": "",
			"ee_twitter": "",
			"ee_como_participar": null
		}';
		
		return $result;
	}
}
