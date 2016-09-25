<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class OscController extends Controller{
	private $componentQueries = array(
    	/* Estrutura: nome_componente => [query_sql, is_unique] */
        "area_atuacao_fasfil" => ["SELECT * FROM portal.get_osc_area_atuacao_fasfil(?::INTEGER);", true],
        "area_atuacao_outras" => ["SELECT * FROM portal.get_osc_area_atuacao_outra(?::INTEGER);", true],
        "cabecalho" => ["SELECT * FROM portal.get_osc_cabecalho(?::INTEGER);", true],
    	"certificacao" => ["SELECT * FROM portal.get_osc_certificacao(?::INTEGER);", false],
        "conferencia" => ["SELECT * FROM portal.get_osc_conferencia(?::INTEGER);", false],
        "dados_gerais" => ["SELECT * FROM portal.get_osc_dados_gerais(?::INTEGER);", true],
        "descricao" => ["SELECT * FROM portal.get_osc_descricao(?::INTEGER);", true],
        "dirigente" => ["SELECT * FROM portal.get_osc_dirigente(?::INTEGER);", false],
        "projeto" => ["SELECT * FROM portal.get_osc_projeto(?::INTEGER);", false],
        "recursos" => ["SELECT * FROM portal.get_osc_recursos(?::INTEGER);", true],
        "relacoes_trabalho" => ["SELECT * FROM portal.get_osc_relacoes_trabalho(?::INTEGER);", true]
    );

    public function getOsc($id){
    	$result = array();
    	foreach ($this->componentQueries as $component => $query){
    		echo $component;
    		$query_info = $this->componentQueries[$component];
	    	$query = $query_info[0];
	    	$unique = $query_info[1];

    		$result_query = json_decode($this->executeSelectQuery($query, $unique, [$id]));
    		if($result_query){
                $result = array_merge($result, [$component => $result_query]);
    		}
		}
        return $this->configResponse($result);
    }

    public function getComponentOsc($component, $id){
        if(array_key_exists($component, $this->componentQueries)){
        	$query_info = $this->componentQueries[$component];
	    	$query = $query_info[0];
	    	$unique = $query_info[1];

        	$result = $this->executeSelectQuery($query, $unique, [$id]);
        }
        return $this->configResponse($result);
    }

	public function updateDadosGerais(Request $request, $id)
    {
    	$razao_social = $request->input('tx_razao_social_osc');
    	$nome_fantasia = $request->input('tx_nome_fantasia_osc');
    	$ft_nome_fantasia = $request->input('ft_nome_fantasia_osc');
    	$sigla = $request->input('tx_sigla_osc');
    	$ft_sigla = $request->input('ft_sigla_osc');
    	$atalho = $request->input('tx_url_osc');
    	$ft_atalho = $request->input('ft_url_osc');
    	$dt_fundacao = $request->input('dt_fundacao_osc');
    	$ft_fundacao = $request->input('ft_fundacao_osc');
    	$resumo = $request->input('tx_resumo_osc');
    	$ft_resumo = $request->input('ft_resumo_osc');
    	$id_situacao_imovel = $request->input('id_situacao_imovel_osc');
    	$ft_situacao_imovel = $request->input('ft_situacao_imovel_osc');
    	$link_estatuto = $request->input('tx_link_estatuto_osc');
    	$ft_link_estatuto = $request->input('ft_link_estatuto_osc');

    	DB::update('UPDATE osc.tb_dados_gerais SET tx_razao_social_osc = ?, tx_nome_fantasia_osc = ?,
    			ft_nome_fantasia_osc = ?, tx_sigla_osc = ?, ft_sigla_osc = ?, tx_url_osc = ?, ft_url_osc = ?, dt_fundacao_osc = ?,
    			ft_fundacao_osc = ?, tx_resumo_osc = ?, ft_resumo_osc = ?, id_situacao_imovel_osc = ?,
    			ft_situacao_imovel_osc = ?, tx_link_estatuto_osc = ?, ft_link_estatuto_osc = ? WHERE id_osc = ?::int',
    			[$razao_social, $nome_fantasia, $ft_nome_fantasia, $sigla, $ft_sigla, $atalho, $ft_atalho, $dt_fundacao, $ft_fundacao, $resumo, $ft_resumo, $id_situacao_imovel, $ft_situacao_imovel, $link_estatuto, $ft_link_estatuto, $id]);

    }

    public function updateContatos(Request $request, $id)
    {
    	$telefone = $request->input('tx_telefone');
    	$ft_telefone = $request->input('ft_telefone');
    	$email = $request->input('tx_email');
    	$ft_email = $request->input('ft_email');
    	$site = $request->input('tx_site');
    	$ft_site = $request->input('ft_site');

    	DB::update('UPDATE osc.tb_contatos SET tx_telefone = ?, ft_telefone = ?, tx_email = ?, ft_email = ?,
    			tx_site = ?, ft_site = ? WHERE id_osc = ?::int',
    			[$telefone, $ft_telefone, $email, $ft_email, $site, $ft_site, $id]);

    }

    public function setAreaAtuacaoDeclarada(Request $request)
    {
    	$nome = $request->input('tx_nome_area_atuacao_declarada');
    	$fonte_nome = $request->input('ft_nome_area_atuacao_declarada');

    	DB::insert('INSERT INTO osc.tb_area_atuacao_declarada (tx_nome_area_atuacao_declarada, ft_nome_area_atuacao_declarada) VALUES (?, ?)',
    			[$nome, $fonte_nome]);
    }

    public function updateAreaAtuacaoDeclarada(Request $request, $id)
    {
    	$nome = $request->input('tx_nome_area_atuacao_declarada');
    	$fonte_nome = $request->input('ft_nome_area_atuacao_declarada');

    	DB::update('UPDATE osc.tb_area_atuacao_declarada SET tx_nome_area_atuacao_declarada = ?, ft_nome_area_atuacao_declarada = ?
    			WHERE id_area_atuacao_declarada = ?::int',
    			[$nome, $fonte_nome, $id]);
    }

    public function deleteAreaAtuacaoDeclarada($id)
    {
    	DB::delete('DELETE FROM osc.tb_area_atuacao_declarada WHERE id_area_atuacao_declarada = ?::int', [$id]);
    }

    public function updateDescricao(Request $request, $id)
    {
    	$razao_social = $request->input('tx_razao_social_osc');
    	$como_surgiu = $request->input('tx_como_surgiu');
    	$ft_como_surgiu = $request->input('ft_como_surgiu');
    	$missao = $request->input('tx_missao_osc');
    	$ft_missao = $request->input('ft_missao_osc');
    	$visao = $request->input('tx_visao_osc');
    	$ft_visao = $request->input('ft_visao_osc');
    	$finalidades_estatutarias = $request->input('tx_finalidades_estatutarias');
    	$ft_finalidades_estatutarias = $request->input('ft_finalidades_estatutarias');

    	DB::update('UPDATE osc.tb_dados_gerais SET tx_razao_social_osc = ?, tx_como_surgiu = ?,
    			ft_como_surgiu = ?, tx_missao_osc = ?, ft_missao_osc = ?, tx_visao_osc = ?,
    			ft_visao_osc = ?, tx_finalidades_estatutarias = ?, ft_finalidades_estatutarias = ? WHERE id_osc = ?::int',
    			[$razao_social, $como_surgiu, $ft_como_surgiu, $missao, $ft_missao, $visao, $ft_visao, $finalidades_estatutarias, $ft_finalidades_estatutarias, $id]);

    }

    public function updateVinculos(Request $request, $id)
    {
    	$nr_trabalhadores_voluntarios = $request->input('nr_trabalhadores_voluntarios');
    	$ft_trabalhadores_voluntarios = $request->input('ft_trabalhadores_voluntarios');

    	DB::update('UPDATE osc.tb_vinculos SET nr_trabalhadores_voluntarios = ?, ft_trabalhadores_voluntarios = ? WHERE id_osc = ?::int',
    			[$nr_trabalhadores_voluntarios, $ft_trabalhadores_voluntarios, $id]);
    }

    public function setDirigente(Request $request)
    {
    	$id = $request->input('id_osc');
    	$cargo = $request->input('tx_cargo_dirigente');
    	$fonte_cargo = $request->input('ft_cargo_dirigente');
    	$nome = $request->input('tx_nome_dirigente');
    	$fonte_nome = $request->input('ft_nome_dirigente');

    	DB::insert('INSERT INTO osc.tb_dirigente (id_osc , tx_cargo_dirigente, ft_cargo_dirigente,
    			tx_nome_dirigente, ft_nome_dirigente) VALUES (?, ?, ?, ?, ?)',
    			[$id, $cargo, $fonte_cargo, $nome, $fonte_nome]);
    }

    public function updateDirigente(Request $request, $id)
    {
    	$osc = $request->input('id_osc');
    	$cargo = $request->input('tx_cargo_dirigente');
    	$fonte_cargo = $request->input('ft_cargo_dirigente');
    	$nome = $request->input('tx_nome_dirigente');
    	$fonte_nome = $request->input('ft_nome_dirigente');

    	DB::update('UPDATE osc.tb_dirigente SET id_osc = ?, tx_cargo_dirigente = ?,
    			ft_cargo_dirigente = ?, tx_nome_dirigente = ?, ft_nome_dirigente = ? WHERE id_dirigente = ?::int',
    			[$osc, $cargo, $fonte_cargo, $nome, $fonte_nome, $id]);

    }

    public function deleteDirigente($id)
    {
    	DB::delete('DELETE FROM osc.tb_dirigente WHERE id_dirigente = ?::int', [$id]);
    }

    public function setConselho(Request $request)
    {
    	$osc = $request->input('id_osc');
    	$id_dic_conselho = $request->input('id_dic_conselho');
    	$ft_conselho = $request->input('ft_conselho');
    	$id_tipo_participacao = $request->input('id_tipo_participacao');
    	$ft_tipo_participacao = $request->input('ft_tipo_participacao');
    	$nr_numero_assentos = $request->input('nr_numero_assentos');
    	$ft_numero_assentos = $request->input('ft_numero_assentos');
    	$tx_periodicidade_reuniao = $request->input('tx_periodicidade_reuniao');
    	$ft_periodicidade_reuniao = $request->input('ft_periodicidade_reuniao');

    	DB::insert('INSERT INTO osc.tb_conselho (id_osc, id_dic_conselho, ft_conselho, id_tipo_participacao,
    			ft_tipo_participacao, nr_numero_assentos, ft_numero_assentos, tx_periodicidade_reuniao,
    			ft_periodicidade_reuniao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
    			[$osc, $id_dic_conselho, $ft_conselho, $id_tipo_participacao, $ft_tipo_participacao, $nr_numero_assentos, $ft_numero_assentos, $tx_periodicidade_reuniao, $ft_periodicidade_reuniao]);
    }

    public function updateConselho(Request $request, $id)
    {
    	$osc = $request->input('id_osc');
    	$id_dic_conselho = $request->input('id_dic_conselho');
    	$ft_conselho = $request->input('ft_conselho');
    	$id_tipo_participacao = $request->input('id_tipo_participacao');
    	$ft_tipo_participacao = $request->input('ft_tipo_participacao');
    	$nr_numero_assentos = $request->input('nr_numero_assentos');
    	$ft_numero_assentos = $request->input('ft_numero_assentos');
    	$tx_periodicidade_reuniao = $request->input('tx_periodicidade_reuniao');
    	$ft_periodicidade_reuniao = $request->input('ft_periodicidade_reuniao');

    	DB::update('UPDATE osc.tb_conselho SET id_osc = ?, id_dic_conselho =?, ft_conselho = ?, id_tipo_participacao = ?, ft_tipo_participacao = ?,
        		nr_numero_assentos = ?, ft_numero_assentos = ?, tx_periodicidade_reuniao = ?, ft_periodicidade_reuniao = ?
        		WHERE id_conselho = ?::int', [$osc, $id_dic_conselho, $ft_conselho, $id_tipo_participacao, $ft_tipo_participacao, $nr_numero_assentos, $ft_numero_assentos, $tx_periodicidade_reuniao, $ft_periodicidade_reuniao, $id]);
    }

    public function deleteConselho($id)
    {
    	DB::delete('DELETE FROM osc.tb_conselho WHERE id_conselho = ?::int', [$id]);
    }

    public function setConferencia(Request $request)
    {
    	$osc = $request->input('id_osc');
    	$nome = $request->input('tx_nome_conferencia');
    	$ft_nome = $request->input('ft_nome_conferencia');
    	$dt_data_inicio = $request->input('dt_data_inicio_conferencia');
    	$ft_data_inicio = $request->input('ft_data_inicio_conferencia');
    	$dt_data_fim = $request->input('dt_data_fim_conferencia');
    	$ft_data_fim = $request->input('ft_data_fim_conferencia');

    	DB::insert('INSERT INTO osc.tb_conferencia (id_osc, tx_nome_conferencia, ft_nome_conferencia,
    			dt_data_inicio_conferencia, ft_data_inicio_conferencia, dt_data_fim_conferencia,
    			ft_data_fim_conferencia) VALUES (?, ?, ?, ?, ?, ?, ?)',
    			[$osc, $nome, $ft_nome, $dt_data_inicio, $ft_data_inicio, $dt_data_fim, $ft_data_fim]);
    }

    public function updateConferencia(Request $request, $id)
    {
    	$osc = $request->input('id_osc');
    	$nome = $request->input('tx_nome_conferencia');
    	$ft_nome = $request->input('ft_nome_conferencia');
    	$dt_data_inicio = $request->input('dt_data_inicio_conferencia');
    	$ft_data_inicio = $request->input('ft_data_inicio_conferencia');
    	$dt_data_fim = $request->input('dt_data_fim_conferencia');
    	$ft_data_fim = $request->input('ft_data_fim_conferencia');

    	DB::update('UPDATE osc.tb_conferencia SET id_osc = ?, tx_nome_conferencia = ?, ft_nome_conferencia = ?,
    			dt_data_inicio_conferencia = ?, ft_data_inicio_conferencia = ?, dt_data_fim_conferencia = ?,
    			ft_data_fim_conferencia = ? WHERE id_conferencia = ?::int',
    			[$osc, $nome, $ft_nome, $dt_data_inicio, $ft_data_inicio, $dt_data_fim, $ft_data_fim, $id]);
    }

    public function deleteConferencia($id)
    {
    	DB::delete('DELETE FROM osc.tb_conferencia WHERE id_conferencia = ?::int', [$id]);
    }

    public function setOutraParticipacaoSocial(Request $request)
    {
    	$osc = $request->input('id_osc');
    	$nome = $request->input('tx_nome_outra_participacao_social');
    	$ft_nome = $request->input('ft_nome_outra_participacao_social');
    	$tipo = $request->input('tx_tipo_outra_participacao_social');
    	$ft_tipo = $request->input('ft_tipo_outra_participacao_social');
    	$data = $request->input('dt_data_ingresso_outra_participacao_social');
    	$ft_data = $request->input('ft_data_ingresso_outra_participacao_social');

    	DB::insert('INSERT INTO osc.tb_outra_participacao_social (id_osc, tx_nome_outra_participacao_social, ft_nome_outra_participacao_social,
    			tx_tipo_outra_participacao_social, ft_tipo_outra_participacao_social, dt_data_ingresso_outra_participacao_social,
    			ft_data_ingresso_outra_participacao_social) VALUES (?, ?, ?, ?, ?, ?, ?)',
    			[$osc, $nome, $ft_nome, $tipo, $ft_tipo, $data, $ft_data]);
    }

    public function updateOutraParticipacaoSocial(Request $request, $id)
    {
    	$osc = $request->input('id_osc');
    	$nome = $request->input('tx_nome_outra_participacao_social');
    	$ft_nome = $request->input('ft_nome_outra_participacao_social');
    	$tipo = $request->input('tx_tipo_outra_participacao_social');
    	$ft_tipo = $request->input('ft_tipo_outra_participacao_social');
    	$data = $request->input('dt_data_ingresso_outra_participacao_social');
    	$ft_data = $request->input('ft_data_ingresso_outra_participacao_social');

    	DB::update('UPDATE osc.tb_outra_participacao_social SET id_osc = ?, tx_nome_outra_participacao_social = ?, ft_nome_outra_participacao_social = ?,
    			tx_tipo_outra_participacao_social = ?, ft_tipo_outra_participacao_social = ?, dt_data_ingresso_outra_participacao_social = ?,
    			ft_data_ingresso_outra_participacao_social = ? WHERE id_outra_participacao_social = ?::int',
    			[$osc, $nome, $ft_nome, $tipo, $ft_tipo, $data, $ft_data, $id]);

    }

    public function deleteOutraParticipacaoSocial($id)
    {
    	DB::delete('DELETE FROM osc.tb_outra_participacao_social WHERE id_outra_participacao_social = ?::int', [$id]);
    }

    public function updateLinkRecursos(Request $request, $id)
    {
    	$razao_social = $request->input('tx_razao_social_osc');
    	$link_relatorio_auditoria = $request->input('tx_link_relatorio_auditoria');
    	$ft_link_relatorio_auditoria = $request->input('ft_link_relatorio_auditoria');
    	$link_demonstracao_contabil = $request->input('tx_link_demonstracao_contabil');
    	$ft_link_demonstracao_contabil = $request->input('ft_link_demonstracao_contabil');

    	DB::update('UPDATE osc.tb_dados_gerais SET tx_razao_social_osc = ?, tx_link_relatorio_auditoria = ?, ft_link_relatorio_auditoria = ?,
        tx_link_demonstracao_contabil = ?, ft_link_demonstracao_contabil = ? WHERE id_osc = ?::int',
    			[$razao_social, $link_relatorio_auditoria, $ft_link_relatorio_auditoria, $link_demonstracao_contabil, $ft_link_demonstracao_contabil, $id]);

    }

    public function setConselhoContabil(Request $request)
    {
    	$osc = $request->input('id_osc');
    	$nome = $request->input('tx_nome_conselheiro');
    	$ft_nome = $request->input('ft_nome_conselheiro');
    	$cargo = $request->input('tx_cargo_conselheiro');
    	$ft_cargo = $request->input('ft_cargo_conselheiro');

    	DB::insert('INSERT INTO osc.tb_conselho_contabil (id_osc, tx_nome_conselheiro, ft_nome_conselheiro,
    			tx_cargo_conselheiro, ft_cargo_conselheiro) VALUES (?, ?, ?, ?, ?)',
    			[$osc, $nome, $ft_nome, $cargo, $ft_cargo]);
    }

    public function updateConselhoContabil(Request $request, $id)
    {
    	$osc = $request->input('id_osc');
    	$nome = $request->input('tx_nome_conselheiro');
    	$ft_nome = $request->input('ft_nome_conselheiro');
    	$cargo = $request->input('tx_cargo_conselheiro');
    	$ft_cargo = $request->input('ft_cargo_conselheiro');

    	DB::update('UPDATE osc.tb_conselho_contabil SET id_osc = ?, tx_nome_conselheiro = ?, ft_nome_conselheiro = ?,
    			tx_cargo_conselheiro = ?, ft_cargo_conselheiro = ? WHERE id_conselheiro = ?::int',
    			[$osc, $nome, $ft_nome, $cargo, $ft_cargo, $id]);
    }

    public function deleteConselhoContabil($id)
    {
    	DB::delete('DELETE FROM osc.tb_conselho_contabil WHERE id_conselheiro = ?::int', [$id]);
    }

    public function setProjeto(Request $request)
    {
    	$osc = $request->input('id_osc');
    	$tx_nome = $request->input('tx_nome_projeto');
    	$ft_nome = $request->input('ft_nome_projeto');
    	$id_status = $request->input('id_status_projeto');
    	$ft_status = $request->input('ft_status_projeto');
    	$dt_data_inicio = $request->input('dt_data_inicio_projeto');
    	$ft_data_inicio = $request->input('ft_data_inicio_projeto');
    	$dt_data_fim = $request->input('dt_data_fim_projeto');
    	$ft_data_fim = $request->input('ft_data_fim_projeto');
    	$nr_valor_total = $request->input('nr_valor_total_projeto');
    	$ft_valor_total = $request->input('ft_valor_total_projeto');
    	$tx_link = $request->input('tx_link_projeto');
    	$ft_link = $request->input('ft_link_projeto');
    	$tx_publico_beneficiado = $request->input('tx_publico_beneficiado_projeto');
    	$ft_publico_beneficiado = $request->input('ft_publico_beneficiado_projeto');
    	$id_abrangencia = $request->input('id_abrangencia_projeto');
    	$ft_abrangencia = $request->input('ft_abrangencia_projeto');
    	$tx_descricao = $request->input('tx_descricao_projeto');
    	$ft_descricao = $request->input('ft_descricao_projeto');
    	$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
    	$ft_total_beneficiarios = $request->input('ft_total_beneficiarios');


    	DB::insert('INSERT INTO osc.tb_projeto (id_osc, tx_nome_projeto, ft_nome_projeto, id_status_projeto,
    	ft_status_projeto, dt_data_inicio_projeto, ft_data_inicio_projeto, dt_data_fim_projeto,
    	ft_data_fim_projeto, nr_valor_total_projeto, ft_valor_total_projeto, tx_link_projeto,
    	ft_link_projeto, tx_publico_beneficiado_projeto, ft_publico_beneficiado_projeto,
    	id_abrangencia_projeto, ft_abrangencia_projeto, tx_descricao_projeto, ft_descricao_projeto,
    	nr_total_beneficiarios, ft_total_beneficiarios) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
    			[$osc, $tx_nome, $ft_nome, $id_status, $ft_status, $dt_data_inicio, $ft_data_inicio, $dt_data_fim, $ft_data_fim, $nr_valor_total, $ft_valor_total, $tx_link, $ft_link, $tx_publico_beneficiado, $ft_publico_beneficiado, $id_abrangencia, $ft_abrangencia, $tx_descricao, $ft_descricao, $nr_total_beneficiarios, $ft_total_beneficiarios]);
    }

    public function updateProjeto(Request $request, $id)
    {
    	$osc = $request->input('id_osc');
    	$tx_nome = $request->input('tx_nome_projeto');
    	$ft_nome = $request->input('ft_nome_projeto');
    	$id_status = $request->input('id_status_projeto');
    	$ft_status = $request->input('ft_status_projeto');
    	$dt_data_inicio = $request->input('dt_data_inicio_projeto');
    	$ft_data_inicio = $request->input('ft_data_inicio_projeto');
    	$dt_data_fim = $request->input('dt_data_fim_projeto');
    	$ft_data_fim = $request->input('ft_data_fim_projeto');
    	$nr_valor_total = $request->input('nr_valor_total_projeto');
    	$ft_valor_total = $request->input('ft_valor_total_projeto');
    	$tx_link = $request->input('tx_link_projeto');
    	$ft_link = $request->input('ft_link_projeto');
    	$tx_publico_beneficiado = $request->input('tx_publico_beneficiado_projeto');
    	$ft_publico_beneficiado = $request->input('ft_publico_beneficiado_projeto');
    	$id_abrangencia = $request->input('id_abrangencia_projeto');
    	$ft_abrangencia = $request->input('ft_abrangencia_projeto');
    	$tx_descricao = $request->input('tx_descricao_projeto');
    	$ft_descricao = $request->input('ft_descricao_projeto');
    	$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
    	$ft_total_beneficiarios = $request->input('ft_total_beneficiarios');

    	DB::update('UPDATE osc.tb_projeto SET tx_nome_projeto = ?, ft_nome_projeto = ?, id_status_projeto = ?,
    			ft_status_projeto = ?, dt_data_inicio_projeto = ?, ft_data_inicio_projeto = ?,
    			dt_data_fim_projeto = ?, ft_data_fim_projeto = ?, nr_valor_total_projeto = ?,
    			ft_valor_total_projeto = ?, tx_link_projeto = ?, ft_link_projeto = ?,
    			tx_publico_beneficiado_projeto = ?, ft_publico_beneficiado_projeto = ?, id_abrangencia_projeto = ?,
    			ft_abrangencia_projeto = ?, tx_descricao_projeto = ?, ft_descricao_projeto = ?,
    			nr_total_beneficiarios = ?, ft_total_beneficiarios = ? WHERE id_projeto = ?::int',
    			[$tx_nome, $ft_nome, $id_status, $ft_status, $dt_data_inicio, $ft_data_inicio, $dt_data_fim, $ft_data_fim, $nr_valor_total, $ft_valor_total, $tx_link, $ft_link, $tx_publico_beneficiado, $ft_publico_beneficiado, $id_abrangencia, $ft_abrangencia, $tx_descricao, $ft_descricao, $nr_total_beneficiarios, $ft_total_beneficiarios, $id]);
    }
}
