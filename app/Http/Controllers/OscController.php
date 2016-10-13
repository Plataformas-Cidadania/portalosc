<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Dao\OscDao;
use Illuminate\Http\Request;
use DB;

class OscController extends Controller
{
	private $dao;

	public function __construct() {
		$this->dao = new OscDao();
	}

    public function getComponentOsc($component, $id)
	{
		$resultDao = $this->dao->getComponentOsc($component, $id);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function getOsc($id)
	{
    	$resultDao = array();
		$resultDao = $this->dao->getOsc($id);
		$this->configResponse($resultDao);
        return $this->response();
    }

	public function updateDadosGerais(Request $request, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_dados_gerais WHERE id_osc = ?::int',[$id]);

    	foreach($json as $key => $value){
	    	$nome_fantasia = $request->input('tx_nome_fantasia_osc');
			if($json[$key]->tx_nome_fantasia_osc != $nome_fantasia) $ft_nome_fantasia = "Usuario";
			else $ft_nome_fantasia = $request->input('ft_nome_fantasia_osc');
	    	$sigla = $request->input('tx_sigla_osc');
			if($json[$key]->tx_sigla_osc != $sigla) $ft_sigla = "Usuario";
			else $ft_sigla = $request->input('ft_sigla_osc');
	    	$atalho = $request->input('tx_url_osc');
			if($json[$key]->tx_url_osc != $atalho) $ft_atalho = "Usuario";
			else $ft_atalho = $request->input('ft_url_osc');
	    	$dt_fundacao = $request->input('dt_fundacao_osc');
			if($json[$key]->dt_fundacao_osc != $dt_fundacao) $ft_fundacao = "Usuario";
			else $ft_fundacao = $request->input('ft_fundacao_osc');
	    	$resumo = $request->input('tx_resumo_osc');
			if($json[$key]->tx_resumo_osc != $resumo) $ft_resumo = "Usuario";
			else $ft_resumo = $request->input('ft_resumo_osc');
	    	$cd_situacao_imovel = $request->input('cd_situacao_imovel_osc');
	    	if($json[$key]->cd_situacao_imovel_osc != $cd_situacao_imovel) $ft_situacao_imovel = "Usuario";
	    	else $ft_situacao_imovel = $request->input('ft_situacao_imovel_osc');
	    	$link_estatuto = $request->input('tx_link_estatuto_osc');
			if($json[$key]->tx_link_estatuto_osc != $link_estatuto) $ft_link_estatuto = "Usuario";
			else $ft_link_estatuto = $request->input('ft_link_estatuto_osc');
    	}

    	DB::update('UPDATE osc.tb_dados_gerais SET tx_nome_fantasia_osc = ?,
    			ft_nome_fantasia_osc = ?, tx_sigla_osc = ?, ft_sigla_osc = ?, tx_url_osc = ?, ft_url_osc = ?, dt_fundacao_osc = ?,
    			ft_fundacao_osc = ?, tx_resumo_osc = ?, ft_resumo_osc = ?, cd_situacao_imovel_osc = ?,
    			ft_situacao_imovel_osc = ?, tx_link_estatuto_osc = ?, ft_link_estatuto_osc = ? WHERE id_osc = ?::int',
    			[$nome_fantasia, $ft_nome_fantasia, $sigla, $ft_sigla, $atalho, $ft_atalho, $dt_fundacao, $ft_fundacao, $resumo, $ft_resumo, $cd_situacao_imovel, $ft_situacao_imovel, $link_estatuto, $ft_link_estatuto, $id]);

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
		$telefone = $request->input('tx_telefone');
		if($telefone != null) $ft_telefone = "Usuario";
		else $ft_telefone = $request->input('ft_telefone');
    	$email = $request->input('tx_email');
		if($email != null) $ft_email = "Usuario";
		else $ft_email = $request->input('ft_email');
    	$site = $request->input('tx_site');
		if($site != null) $ft_site = "Usuario";
		else $ft_site = $request->input('ft_site');

		DB::insert('INSERT INTO osc.tb_contato (id_osc, tx_telefone, ft_telefone, tx_email, ft_email,
    			tx_site, ft_site) VALUES (?, ?, ?, ?, ?, ?, ?)',
					[$id, $telefone, $ft_telefone, $email, $ft_email, $site, $ft_site]);
	}

    public function updateContatos(Request $request, $id)
    {
		$json = DB::select('SELECT * FROM osc.tb_contato WHERE id_osc = ?::int',[$id]);

		foreach($json as $key => $value){
	    	$telefone = $request->input('tx_telefone');
			if($json[$key]->tx_telefone != $telefone) $ft_telefone = "Usuario";
			else $ft_telefone = $request->input('ft_telefone');
	    	$email = $request->input('tx_email');
			if($json[$key]->tx_email != $email) $ft_email = "Usuario";
			else $ft_email = $request->input('ft_email');
	    	$site = $request->input('tx_site');
			if($json[$key]->tx_site != $site) $ft_site = "Usuario";
			else $ft_site = $request->input('ft_site');
		}

    	DB::update('UPDATE osc.tb_contato SET tx_telefone = ?, ft_telefone = ?, tx_email = ?, ft_email = ?,
    			tx_site = ?, ft_site = ? WHERE id_osc = ?::int',
    			[$telefone, $ft_telefone, $email, $ft_email, $site, $ft_site, $id]);

    }

    public function setAreaAtuacaoFasfil(Request $request)
    {
    	$id_osc = $request->input('id_osc');
    	$cd_area_atuacao = $request->input('cd_area_atuacao_fasfil');
    	if($cd_area_atuacao != null) $ft_area_atuacao = "Usuario";
    	else $ft_area_atuacao = $request->input('ft_area_atuacao_fasfil');
     	
     	DB::insert('INSERT INTO osc.tb_area_atuacao_fasfil (id_osc, cd_area_atuacao_fasfil, ft_area_atuacao_fasfil) VALUES (?, ?, ?)',
     			[$id_osc, $cd_area_atuacao, $ft_area_atuacao]);
    }
    
    public function updateAreaAtuacaoFasfil(Request $request, $id)
    {
		$json = DB::select('SELECT * FROM osc.tb_area_atuacao_fasfil WHERE id_osc = ?::int',[$id]);
		
		$id_area_atuacao_osc = $request->input('id_area_atuacao_osc');
		
		foreach($json as $key => $value){
			if($json[$key]->id_area_atuacao_osc == $id_area_atuacao_osc){
				$cd_area_atuacao = $request->input('cd_area_atuacao_fasfil');
				if($json[$key]->cd_area_atuacao_fasfil != $cd_area_atuacao) $ft_area_atuacao = "Usuario";
		    	else $ft_area_atuacao = $request->input('ft_area_atuacao_fasfil');
			}
		}
    
    	DB::update('UPDATE osc.tb_area_atuacao_fasfil SET id_osc = ?, cd_area_atuacao_fasfil = ?, ft_area_atuacao_fasfil = ?
    	    		WHERE id_area_atuacao_osc = ?::int',
    	     		[$id, $cd_area_atuacao, $ft_area_atuacao, $id_area_atuacao_osc]);
    }

    public function deleteAreaAtuacaoFasfil($id)
    {
     	DB::delete('DELETE FROM osc.tb_area_atuacao_fasfil WHERE id_area_atuacao_osc = ?::int', [$id]);
    }

    public function updateDescricao(Request $request, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_dados_gerais WHERE id_osc = ?::int',[$id]);

    	foreach($json as $key => $value){
	    	$como_surgiu = $request->input('tx_como_surgiu');
	    	if($json[$key]->tx_como_surgiu != $como_surgiu) $ft_como_surgiu = "Usuario";
	    	else $ft_como_surgiu = $request->input('ft_como_surgiu');
	    	$missao = $request->input('tx_missao_osc');
	    	if($json[$key]->tx_missao_osc != $missao) $ft_missao = "Usuario";
	    	else $ft_missao = $request->input('ft_missao_osc');
	    	$visao = $request->input('tx_visao_osc');
	    	if($json[$key]->tx_visao_osc != $visao) $ft_visao = "Usuario";
	    	else $ft_visao = $request->input('ft_visao_osc');
	    	$finalidades_estatutarias = $request->input('tx_finalidades_estatutarias');
	    	if($json[$key]->tx_finalidades_estatutarias != $finalidades_estatutarias) $ft_finalidades_estatutarias = "Usuario";
	    	else $ft_finalidades_estatutarias = $request->input('ft_finalidades_estatutarias');
    	}

    	DB::update('UPDATE osc.tb_dados_gerais SET tx_como_surgiu = ?,
    			ft_como_surgiu = ?, tx_missao_osc = ?, ft_missao_osc = ?, tx_visao_osc = ?,
    			ft_visao_osc = ?, tx_finalidades_estatutarias = ?, ft_finalidades_estatutarias = ? WHERE id_osc = ?::int',
    			[$como_surgiu, $ft_como_surgiu, $missao, $ft_missao, $visao, $ft_visao, $finalidades_estatutarias, $ft_finalidades_estatutarias, $id]);

    }

    public function vinculos(Request $request, $id)
    {
    	$result = DB::select('SELECT * FROM osc.tb_vinculo WHERE id_osc = ?::int',[$id]);
    	if($result != null)
    		$this->updateVinculos($request, $id);
    	else
    		$this->setVinculos($request, $id);
    }
    
    public function setVinculos(Request $request, $id)
    {
       	$nr_trabalhadores_voluntarios = $request->input('nr_trabalhadores_voluntarios');
    	if($nr_trabalhadores_voluntarios != null) $ft_trabalhadores_voluntarios = "Usuario";
    	else $ft_trabalhadores_voluntarios = $request->input('ft_trabalhadores_voluntarios');
    
    	DB::insert('INSERT INTO osc.tb_vinculo (id_osc, nr_trabalhadores_voluntarios, ft_trabalhadores_voluntarios) 
    			VALUES (?, ?, ?)',
    			[$id, $nr_trabalhadores_voluntarios, $ft_trabalhadores_voluntarios]);
    }

    public function updateVinculos(Request $request, $id)
    {   	
    	$json = DB::select('SELECT * FROM osc.tb_vinculo WHERE id_osc = ?::int',[$id]);
    	
    	foreach($json as $key => $value){
	    	$nr_trabalhadores_voluntarios = $request->input('nr_trabalhadores_voluntarios');
	    	if($json[$key]->nr_trabalhadores_voluntarios != $nr_trabalhadores_voluntarios) $ft_trabalhadores_voluntarios = "Usuario";
	    	else $ft_trabalhadores_voluntarios = $request->input('ft_trabalhadores_voluntarios');
    	}

    	DB::update('UPDATE osc.tb_vinculo SET nr_trabalhadores_voluntarios = ?, ft_trabalhadores_voluntarios = ? WHERE id_osc = ?::int',
    			[$nr_trabalhadores_voluntarios, $ft_trabalhadores_voluntarios, $id]);

    }

    public function setDirigente(Request $request)
    {
    	$id = $request->input('id_osc');
    	$cargo = $request->input('tx_cargo_dirigente');
    	if($cargo != null) $fonte_cargo = "Usuario";
    	else $fonte_cargo = $request->input('ft_cargo_dirigente');
    	$nome = $request->input('tx_nome_dirigente');
    	if($nome != null) $fonte_nome = "Usuario";
    	else $fonte_nome = $request->input('ft_nome_dirigente');
    	
    	DB::insert('INSERT INTO osc.tb_dirigente (id_osc , tx_cargo_dirigente, ft_cargo_dirigente,
    			tx_nome_dirigente, ft_nome_dirigente) VALUES (?, ?, ?, ?, ?)',
    			[$id, $cargo, $fonte_cargo, $nome, $fonte_nome]);
    }

    public function updateDirigente(Request $request, $id)
    {
    	$id_dirigente = $request->input('id_dirigente');
    	
    	$json = DB::select('SELECT * FROM osc.tb_dirigente WHERE id_dirigente = ?::int',[$id_dirigente]);
    	 
    	foreach($json as $key => $value){
    		if($json[$key]->id_dirigente == $id_dirigente){
    			$cargo = $request->input('tx_cargo_dirigente');
    			if($json[$key]->tx_cargo_dirigente != $cargo) $fonte_cargo = "Usuario";
    			else $fonte_cargo = $request->input('ft_cargo_dirigente');
    			$nome = $request->input('tx_nome_dirigente');
    			if($json[$key]->tx_nome_dirigente != $nome) $fonte_nome = "Usuario";
    			else $fonte_nome = $request->input('ft_nome_dirigente');
    		}
    	}

    	DB::update('UPDATE osc.tb_dirigente SET id_osc = ?, tx_cargo_dirigente = ?,
    			ft_cargo_dirigente = ?, tx_nome_dirigente = ?, ft_nome_dirigente = ? WHERE id_dirigente = ?::int',
    			[$id, $cargo, $fonte_cargo, $nome, $fonte_nome, $id_dirigente]);

    }

    public function deleteDirigente($id)
    {
    	DB::delete('DELETE FROM osc.tb_dirigente WHERE id_dirigente = ?::int', [$id]);
    }

    public function setParticipacaoSocialConselho(Request $request)
    {
    	$osc = $request->input('id_osc');
    	$cd_conselho = $request->input('cd_conselho');
    	if($cd_conselho != null) $ft_conselho = "Usuario";
    	else $ft_conselho = $request->input('ft_conselho');
    	$cd_tipo_participacao = $request->input('cd_tipo_participacao');
    	if($cd_tipo_participacao != null) $ft_tipo_participacao = "Usuario";
    	else $ft_tipo_participacao = $request->input('ft_tipo_participacao');
    	$nr_numero_assentos = $request->input('nr_numero_assentos');
    	if($nr_numero_assentos != null) $ft_numero_assentos = "Usuario";
    	else $ft_numero_assentos = $request->input('ft_numero_assentos');
    	$tx_periodicidade_reuniao = $request->input('tx_periodicidade_reuniao');
    	if($tx_periodicidade_reuniao != null) $ft_periodicidade_reuniao = "Usuario";
    	else $ft_periodicidade_reuniao = $request->input('ft_periodicidade_reuniao');

    	DB::insert('INSERT INTO osc.tb_participacao_social_conselho (id_osc, cd_conselho, ft_conselho, cd_tipo_participacao,
    			ft_tipo_participacao, nr_numero_assentos, ft_numero_assentos, tx_periodicidade_reuniao,
    			ft_periodicidade_reuniao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
    			[$osc, $cd_conselho, $ft_conselho, $cd_tipo_participacao, $ft_tipo_participacao, $nr_numero_assentos, $ft_numero_assentos, $tx_periodicidade_reuniao, $ft_periodicidade_reuniao]);
    }
	
    public function updateParticipacaoSocialConselho(Request $request, $id)
    {
    	$id_conselho = $request->input('id_conselho');
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conselho WHERE id_conselho = ?::int',[$id_conselho]);
    	
    	foreach($json as $key => $value){
    		if($json[$key]->id_conselho == $id_conselho){
    			$cd_conselho = $request->input('cd_conselho');
    			if($json[$key]->cd_conselho != $cd_conselho) $ft_conselho = "Usuario";
    			else $ft_conselho = $request->input('ft_conselho');
    			$cd_tipo_participacao = $request->input('cd_tipo_participacao');
    			if($json[$key]->cd_tipo_participacao != $cd_tipo_participacao) $ft_tipo_participacao = "Usuario";
    			else $ft_tipo_participacao = $request->input('ft_tipo_participacao');
    			$nr_numero_assentos = $request->input('nr_numero_assentos');
    			if($json[$key]->nr_numero_assentos != $nr_numero_assentos) $ft_numero_assentos = "Usuario";
    			else $ft_numero_assentos = $request->input('ft_numero_assentos');
    			$tx_periodicidade_reuniao = $request->input('tx_periodicidade_reuniao');
    			if($json[$key]->tx_periodicidade_reuniao != $tx_periodicidade_reuniao) $ft_periodicidade_reuniao = "Usuario";
    			else $ft_periodicidade_reuniao = $request->input('ft_periodicidade_reuniao');
    		}
    	}
    	    	 
    	DB::update('UPDATE osc.tb_participacao_social_conselho SET id_osc = ?, cd_conselho =?, ft_conselho = ?, cd_tipo_participacao = ?, ft_tipo_participacao = ?,
        		nr_numero_assentos = ?, ft_numero_assentos = ?, tx_periodicidade_reuniao = ?, ft_periodicidade_reuniao = ?
        		WHERE id_conselho = ?::int', [$id, $cd_conselho, $ft_conselho, $cd_tipo_participacao, $ft_tipo_participacao, $nr_numero_assentos, $ft_numero_assentos, $tx_periodicidade_reuniao, $ft_periodicidade_reuniao, $id_conselho]);
    }
    
    public function deleteParticipacaoSocialConselho($id)
    {
    	DB::delete('DELETE FROM osc.tb_participacao_social_conselho WHERE id_conselho = ?::int', [$id]);
    }

    public function setParticipacaoSocialConferencia(Request $request)
    {
    	$osc = $request->input('id_osc');
    	$nome = $request->input('tx_nome_conferencia');
    	if($nome != null) $ft_nome = "Usuario";
    	else $ft_nome = $request->input('ft_nome_conferencia');
    	$dt_data_inicio = $request->input('dt_data_inicio_conferencia');
    	if($dt_data_inicio != null) $ft_data_inicio = "Usuario";
    	else $ft_data_inicio = $request->input('ft_data_inicio_conferencia');
    	$dt_data_fim = $request->input('dt_data_fim_conferencia');
    	if($dt_data_fim != null) $ft_data_fim = "Usuario";
    	else $ft_data_fim = $request->input('ft_data_fim_conferencia');

    	DB::insert('INSERT INTO osc.tb_participacao_social_conferencia (id_osc, tx_nome_conferencia, ft_nome_conferencia,
    			dt_data_inicio_conferencia, ft_data_inicio_conferencia, dt_data_fim_conferencia,
    			ft_data_fim_conferencia) VALUES (?, ?, ?, ?, ?, ?, ?)',
    			[$osc, $nome, $ft_nome, $dt_data_inicio, $ft_data_inicio, $dt_data_fim, $ft_data_fim]);
    }

    public function updateParticipacaoSocialConferencia(Request $request, $id)
    {
    	$id_conferencia = $request->input('id_conferencia');
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_conferencia WHERE id_conferencia = ?::int',[$id_conferencia]);

    	foreach($json as $key => $value){
    		if($json[$key]->id_conferencia == $id_conferencia){
    			$nome = $request->input('tx_nome_conferencia');
    			if($json[$key]->tx_nome_conferencia != $nome) $ft_nome = "Usuario";
    			else $ft_nome = $request->input('ft_nome_conferencia');
    			$dt_data_inicio = $request->input('dt_data_inicio_conferencia');
    			if($json[$key]->dt_data_inicio_conferencia != $dt_data_inicio) $ft_data_inicio = "Usuario";
    			else $ft_data_inicio = $request->input('ft_data_inicio_conferencia');
    			$dt_data_fim = $request->input('dt_data_fim_conferencia');
    			if($json[$key]->dt_data_fim_conferencia != $dt_data_fim) $ft_data_fim = "Usuario";
    			else $ft_data_fim = $request->input('ft_data_fim_conferencia');
    		}
    	}

    	DB::update('UPDATE osc.tb_participacao_social_conferencia SET id_osc = ?, tx_nome_conferencia = ?, ft_nome_conferencia = ?,
    			dt_data_inicio_conferencia = ?, ft_data_inicio_conferencia = ?, dt_data_fim_conferencia = ?,
    			ft_data_fim_conferencia = ? WHERE id_conferencia = ?::int',
    			[$id, $nome, $ft_nome, $dt_data_inicio, $ft_data_inicio, $dt_data_fim, $ft_data_fim, $id_conferencia]);
    }

    public function deleteParticipacaoSocialConferencia($id)
    {
    	DB::delete('DELETE FROM osc.tb_participacao_social_conferencia WHERE id_conferencia = ?::int', [$id]);
    }

    public function setOutraParticipacaoSocial(Request $request)
    {
    	$osc = $request->input('id_osc');
    	$nome = $request->input('tx_nome_outra_participacao_social');
    	if($nome != null) $ft_nome = "Usuario";
    	else $ft_nome = $request->input('ft_nome_outra_participacao_social');
    	$tipo = $request->input('tx_tipo_outra_participacao_social');
    	if($tipo != null) $ft_tipo = "Usuario";
    	else $ft_tipo = $request->input('ft_tipo_outra_participacao_social');
    	$data = $request->input('dt_data_ingresso_outra_participacao_social');
    	if($data != null) $ft_data = "Usuario";
    	else $ft_data = $request->input('ft_data_ingresso_outra_participacao_social');


    	DB::insert('INSERT INTO osc.tb_participacao_social_outra (id_osc, tx_nome_outra_participacao_social, ft_nome_outra_participacao_social,
    			tx_tipo_outra_participacao_social, ft_tipo_outra_participacao_social, dt_data_ingresso_outra_participacao_social,
    			ft_data_ingresso_outra_participacao_social) VALUES (?, ?, ?, ?, ?, ?, ?)',
    			[$osc, $nome, $ft_nome, $tipo, $ft_tipo, $data, $ft_data]);
    }

    public function updateOutraParticipacaoSocial(Request $request, $id)
    {
    	$id_outra = $request->input('id_outra_participacao_social');
    	$json = DB::select('SELECT * FROM osc.tb_participacao_social_outra WHERE id_outra_participacao_social = ?::int',[$id_outra]);
    	
    	foreach($json as $key => $value){
    		if($json[$key]->id_outra_participacao_social == $id_outra){
    			$nome = $request->input('tx_nome_outra_participacao_social');
    			if($json[$key]->tx_nome_outra_participacao_social != $nome) $ft_nome = "Usuario";
    			else $ft_nome = $request->input('ft_nome_outra_participacao_social');
    			$tipo = $request->input('tx_tipo_outra_participacao_social');
    			if($json[$key]->tx_tipo_outra_participacao_social != $tipo) $ft_tipo = "Usuario";
    			else $ft_tipo = $request->input('ft_tipo_outra_participacao_social');
    			$data = $request->input('dt_data_ingresso_outra_participacao_social');
    			if($json[$key]->dt_data_ingresso_outra_participacao_social != $data) $ft_data = "Usuario";
    			else $ft_data = $request->input('ft_data_ingresso_outra_participacao_social');
    		}
    	}

    	DB::update('UPDATE osc.tb_participacao_social_outra SET id_osc = ?, tx_nome_outra_participacao_social = ?, ft_nome_outra_participacao_social = ?,
    			tx_tipo_outra_participacao_social = ?, ft_tipo_outra_participacao_social = ?, dt_data_ingresso_outra_participacao_social = ?,
    			ft_data_ingresso_outra_participacao_social = ? WHERE id_outra_participacao_social = ?::int',
    			[$id, $nome, $ft_nome, $tipo, $ft_tipo, $data, $ft_data, $id_outra]);

    }

    public function deleteOutraParticipacaoSocial($id)
    {
    	DB::delete('DELETE FROM osc.tb_participacao_social_outra WHERE id_outra_participacao_social = ?::int', [$id]);
    }

    public function updateLinkRecursos(Request $request, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_dados_gerais WHERE id_osc = ?::int',[$id]);

    	foreach($json as $key => $value){
	    	$link_relatorio_auditoria = $request->input('tx_link_relatorio_auditoria');
	    	if($json[$key]->tx_link_relatorio_auditoria != $link_relatorio_auditoria) $ft_link_relatorio_auditoria = "Usuario";
	    	else $ft_link_relatorio_auditoria = $request->input('ft_link_relatorio_auditoria');
	    	$link_demonstracao_contabil = $request->input('tx_link_demonstracao_contabil');
	    	if($json[$key]->tx_link_demonstracao_contabil != $link_demonstracao_contabil) $ft_link_demonstracao_contabil = "Usuario";
	    	else $ft_link_demonstracao_contabil = $request->input('ft_link_demonstracao_contabil');
    	}

    	DB::update('UPDATE osc.tb_dados_gerais SET tx_link_relatorio_auditoria = ?, ft_link_relatorio_auditoria = ?,
        tx_link_demonstracao_contabil = ?, ft_link_demonstracao_contabil = ? WHERE id_osc = ?::int',
    			[$link_relatorio_auditoria, $ft_link_relatorio_auditoria, $link_demonstracao_contabil, $ft_link_demonstracao_contabil, $id]);

    }

    public function setConselhoContabil(Request $request)
    {
    	$osc = $request->input('id_osc');
    	$nome = $request->input('tx_nome_conselheiro');
    	if($nome != null) $ft_nome = "Usuario";
    	else $ft_nome = $request->input('ft_nome_conselheiro');
    	$cargo = $request->input('tx_cargo_conselheiro');
    	if($cargo != null) $ft_cargo = "Usuario";
    	else $ft_cargo = $request->input('ft_cargo_conselheiro');

    	DB::insert('INSERT INTO osc.tb_conselho_contabil (id_osc, tx_nome_conselheiro, ft_nome_conselheiro,
    			tx_cargo_conselheiro, ft_cargo_conselheiro) VALUES (?, ?, ?, ?, ?)',
    			[$osc, $nome, $ft_nome, $cargo, $ft_cargo]);
    }

    public function updateConselhoContabil(Request $request, $id)
    {
    	$id_conselheiro = $request->input('id_conselheiro');
    	
    	$json = DB::select('SELECT * FROM osc.tb_conselho_contabil WHERE id_conselheiro = ?::int',[$id_conselheiro]);

    	foreach($json as $key => $value){
    		if($json[$key]->id_conselheiro == $id_conselheiro){
    			$nome = $request->input('tx_nome_conselheiro');
    			if($json[$key]->tx_nome_conselheiro != $nome) $ft_nome = "Usuario";
    			else $ft_nome = $request->input('ft_nome_conselheiro');
    			$cargo = $request->input('tx_cargo_conselheiro');
    			if($json[$key]->tx_cargo_conselheiro != $cargo) $ft_cargo = "Usuario";
    			else $ft_cargo = $request->input('ft_cargo_conselheiro');
    		}
    	}

    	DB::update('UPDATE osc.tb_conselho_contabil SET id_osc = ?, tx_nome_conselheiro = ?, ft_nome_conselheiro = ?,
    			tx_cargo_conselheiro = ?, ft_cargo_conselheiro = ? WHERE id_conselheiro = ?::int',
    			[$id, $nome, $ft_nome, $cargo, $ft_cargo, $id_conselheiro]);
    }

    public function deleteConselhoContabil($id)
    {
    	DB::delete('DELETE FROM osc.tb_conselho_contabil WHERE id_conselheiro = ?::int', [$id]);
    }

    public function setProjeto(Request $request)
    {
    	$osc = $request->input('id_osc');
    	$tx_nome = $request->input('tx_nome_projeto');
    	if($tx_nome != null) $ft_nome = "Usuario";
    	else $ft_nome = $request->input('ft_nome_projeto');
    	$cd_status = $request->input('cd_status_projeto');
    	if($cd_status != null) $ft_status = "Usuario";
    	else $ft_status = $request->input('ft_status_projeto');
    	$dt_data_inicio = $request->input('dt_data_inicio_projeto');
    	if($dt_data_inicio != null) $ft_data_inicio = "Usuario";
    	else $ft_data_inicio = $request->input('ft_data_inicio_projeto');
    	$dt_data_fim = $request->input('dt_data_fim_projeto');
    	if($dt_data_fim != null) $ft_data_fim = "Usuario";
    	else $ft_data_fim = $request->input('ft_data_fim_projeto');
    	$nr_valor_total = $request->input('nr_valor_total_projeto');
    	if($nr_valor_total != null) $ft_valor_total = "Usuario";
    	else $ft_valor_total = $request->input('ft_valor_total_projeto');
    	$tx_link = $request->input('tx_link_projeto');
    	if($tx_link != null) $ft_link = "Usuario";
    	else $ft_link = $request->input('ft_link_projeto');
    	$cd_abrangencia = $request->input('cd_abrangencia_projeto');
    	if($cd_abrangencia != null) $ft_abrangencia = "Usuario";
    	else $ft_abrangencia = $request->input('ft_abrangencia_projeto');
    	$tx_descricao = $request->input('tx_descricao_projeto');
    	if($tx_descricao != null) $ft_descricao = "Usuario";
    	else $ft_descricao = $request->input('ft_descricao_projeto');
    	$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
    	if($nr_total_beneficiarios != null) $ft_total_beneficiarios = "Usuario";
    	else $ft_total_beneficiarios = $request->input('ft_total_beneficiarios');


    	DB::insert('INSERT INTO osc.tb_projeto (id_osc, tx_nome_projeto, ft_nome_projeto, cd_status_projeto,
    	ft_status_projeto, dt_data_inicio_projeto, ft_data_inicio_projeto, dt_data_fim_projeto,
    	ft_data_fim_projeto, nr_valor_total_projeto, ft_valor_total_projeto, tx_link_projeto,
    	ft_link_projeto, cd_abrangencia_projeto, ft_abrangencia_projeto, tx_descricao_projeto, ft_descricao_projeto,
    	nr_total_beneficiarios, ft_total_beneficiarios) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
    			[$osc, $tx_nome, $ft_nome, $cd_status, $ft_status, $dt_data_inicio, $ft_data_inicio, $dt_data_fim, $ft_data_fim, $nr_valor_total, $ft_valor_total, $tx_link, $ft_link, $cd_abrangencia, $ft_abrangencia, $tx_descricao, $ft_descricao, $nr_total_beneficiarios, $ft_total_beneficiarios]);
    }
    
    public function updateProjeto(Request $request, $id)
    {
    	$json = DB::select('SELECT * FROM osc.tb_projeto WHERE id_osc = ?::int',[$id]);
    	
    	$id_projeto = $request->input('id_projeto');
    	foreach($json as $key => $value){
    		if($json[$key]->id_projeto == $id_projeto){
    			$tx_nome = $request->input('tx_nome_projeto');
    			if($json[$key]->tx_nome_projeto != $tx_nome) $ft_nome = "Usuario";
    			else $ft_nome = $request->input('ft_nome_projeto');
    			$cd_status = $request->input('cd_status_projeto');
    			if($json[$key]->cd_status_projeto != $cd_status) $ft_status = "Usuario";
    			else $ft_status = $request->input('ft_status_projeto');
    			$dt_data_inicio = $request->input('dt_data_inicio_projeto');
    			if($json[$key]->dt_data_inicio_projeto != $dt_data_inicio) $ft_data_inicio = "Usuario";
    			else $ft_data_inicio = $request->input('ft_data_inicio_projeto');
    			$dt_data_fim = $request->input('dt_data_fim_projeto');
    			if($json[$key]->dt_data_fim_projeto != $dt_data_fim) $ft_data_fim = "Usuario";
    			else $ft_data_fim = $request->input('ft_data_fim_projeto');
    			$nr_valor_total = $request->input('nr_valor_total_projeto');
    			if($json[$key]->nr_valor_total_projeto != $nr_valor_total) $ft_valor_total = "Usuario";
    			else $ft_valor_total = $request->input('ft_valor_total_projeto');
    			$tx_link = $request->input('tx_link_projeto');
    			if($json[$key]->tx_link_projeto != $tx_link) $ft_link = "Usuario";
    			else $ft_link = $request->input('ft_link_projeto');
    			$cd_abrangencia = $request->input('cd_abrangencia_projeto');
    			if($json[$key]->cd_abrangencia_projeto != $cd_abrangencia) $ft_abrangencia = "Usuario";
    			else $ft_abrangencia = $request->input('ft_abrangencia_projeto');
    			$tx_descricao = $request->input('tx_descricao_projeto');
    			if($json[$key]->tx_descricao_projeto != $tx_descricao) $ft_descricao = "Usuario";
    			else $ft_descricao = $request->input('ft_descricao_projeto');
    			$nr_total_beneficiarios = $request->input('nr_total_beneficiarios');
    			if($json[$key]->nr_total_beneficiarios != $nr_total_beneficiarios) $ft_total_beneficiarios = "Usuario";
    			else $ft_total_beneficiarios = $request->input('ft_total_beneficiarios');
    		}
    	}
    
    	DB::update('UPDATE osc.tb_projeto SET id_osc = ?, tx_nome_projeto = ?, ft_nome_projeto = ?, cd_status_projeto = ?,
    			ft_status_projeto = ?, dt_data_inicio_projeto = ?, ft_data_inicio_projeto = ?,
    			dt_data_fim_projeto = ?, ft_data_fim_projeto = ?, nr_valor_total_projeto = ?,
    			ft_valor_total_projeto = ?, tx_link_projeto = ?, ft_link_projeto = ?,
    			cd_abrangencia_projeto = ?, ft_abrangencia_projeto = ?, tx_descricao_projeto = ?, ft_descricao_projeto = ?,
    			nr_total_beneficiarios = ?, ft_total_beneficiarios = ? WHERE id_projeto = ?::int',
    			[$id, $tx_nome, $ft_nome, $cd_status, $ft_status, $dt_data_inicio, $ft_data_inicio, $dt_data_fim, $ft_data_fim,
    					$nr_valor_total, $ft_valor_total, $tx_link, $ft_link, $cd_abrangencia, $ft_abrangencia, $tx_descricao, $ft_descricao, $nr_total_beneficiarios, $ft_total_beneficiarios, $id_projeto]);
    }
    
    public function setPublicoBeneficiado(Request $request)
    {
    	$nome_publico_beneficiado = $request->input('tx_nome_publico_beneficiado');
    	if($nome_publico_beneficiado != null) $ft_publico_beneficiado = "Usuario";
    	else $ft_publico_beneficiado = $request->input('ft_publico_beneficiado');

    	DB::insert('INSERT INTO osc.tb_publico_beneficiado (tx_nome_publico_beneficiado, ft_publico_beneficiado)
    			VALUES (?, ?)',
    			[$nome_publico_beneficiado, $ft_publico_beneficiado]);
    	$id = DB::connection()->getPdo()->lastInsertId();
    	
    	return $id;
    }
    
    public function updatePublicoBeneficiado(Request $request, $id_publico)
    {	    
	    $json = DB::select('SELECT * FROM osc.tb_publico_beneficiado WHERE id_publico_beneficiado = ?::int',[$id_publico]);
	    
	    foreach($json as $key => $value){
	    	if($json[$key]->id_publico_beneficiado == $id_publico){
	    		$nome_publico_beneficiado = $request->input('tx_nome_publico_beneficiado');
	    		if($json[$key]->tx_nome_publico_beneficiado != $nome_publico_beneficiado) $ft_publico_beneficiado = "Usuario";
	    		else $ft_publico_beneficiado = $request->input('ft_publico_beneficiado');
	    	}
	    }
	    
	    DB::update('UPDATE osc.tb_publico_beneficiado SET tx_nome_publico_beneficiado = ?, ft_publico_beneficiado = ?
	   			WHERE id_publico_beneficiado = ?::int',
	    		[$nome_publico_beneficiado, $ft_publico_beneficiado, $id_publico]);
    }

    public function deletePublicoBeneficiado($id, $id_projeto)
    {
    	DB::delete('DELETE FROM osc.tb_publico_beneficiado_projeto WHERE id_publico_beneficiado = ? AND id_projeto = ?::int', [$id, $id_projeto]);
    	
    	DB::delete('DELETE FROM osc.tb_publico_beneficiado WHERE id_publico_beneficiado = ?::int', [$id]);
    }
    
    public function setPublicoBeneficiadoProjeto(Request $request)
    {
        $id_projeto = $request->input('id_projeto');
        $id_publico_beneficiado = $this->setPublicoBeneficiado($request);
        if($id_publico_beneficiado != null) $ft_publico_beneficiado_projeto = "Usuario";
        else $ft_publico_beneficiado_projeto = $request->input('ft_publico_beneficiado_projeto');
    
        DB::insert('INSERT INTO osc.tb_publico_beneficiado_projeto (id_projeto, id_publico_beneficiado, ft_publico_beneficiado_projeto)
        			VALUES (?, ?, ?)',
        			[$id_projeto, $id_publico_beneficiado, $ft_publico_beneficiado_projeto]);
    }
    
    public function setAreaAutoDeclaradaProjeto(Request $request)
    {
    	$id_projeto = $request->input('id_projeto');
    	$id_area_atuacao_outra = $request->input('id_area_atuacao_outra');
    	if($id_area_atuacao_outra != null) $ft_area_atuacao_outra = "Usuario";
    	else $ft_area_atuacao_outra = $request->input('ft_area_atuacao_outra');
    
    	DB::insert('INSERT INTO osc.tb_area_atuacao_outra_projeto (id_projeto, id_area_atuacao_outra, ft_area_atuacao_outra)
    			VALUES (?, ?, ?)',
    			[$id_projeto, $id_area_atuacao_outra, $ft_area_atuacao_outra]);
    }
    
    public function updateAreaAutoDeclaradaProjeto(Request $request, $id_area)
    {    
    	$json = DB::select('SELECT * FROM osc.tb_area_atuacao_outra_projeto WHERE id_area_atuacao_outra_projeto = ?::int',[$id_area]);
       	
       	foreach($json as $key => $value){
       		if($json[$key]->id_area_atuacao_outra_projeto == $id_area){
       			$id_projeto = $request->input('id_projeto');
       			$id_area_atuacao_outra = $request->input('id_area_atuacao_outra');
       			if($json[$key]->id_area_atuacao_outra != $id_area_atuacao_outra) $ft_area_atuacao_outra = "Usuario";
       			else $ft_area_atuacao_outra = $request->input('ft_area_atuacao_outra');
       		}
       	}
    
        DB::update('UPDATE osc.tb_area_atuacao_outra_projeto SET id_projeto = ?, id_area_atuacao_outra = ?, ft_area_atuacao_outra = ?
        		WHERE id_area_atuacao_outra_projeto = ?::int',
    		   		[$id_projeto, $id_area_atuacao_outra, $ft_area_atuacao_outra, $id_area]);
    }
    
    public function deleteAreaAutoDeclaradaProjeto($id)
    {
    	DB::delete('DELETE FROM osc.tb_area_atuacao_outra_projeto WHERE id_area_atuacao_outra_projeto = ?::int', [$id]);
    }
  
    public function setLocalizacaoProjeto(Request $request)
    {
    	$id_projeto = $request->input('id_projeto');
    	$id_regiao_localizacao_projeto = $request->input('id_regiao_localizacao_projeto');
    	if($id_regiao_localizacao_projeto != null) $ft_regiao_localizacao_projeto = "Usuario";
    	else $ft_regiao_localizacao_projeto = $request->input('ft_regiao_localizacao_projeto');
    	$tx_nome_regiao_localizacao_projeto = $request->input('tx_nome_regiao_localizacao_projeto');
    	if($tx_nome_regiao_localizacao_projeto != null) $ft_nome_regiao_localizacao_projeto = "Usuario";
    	else $ft_nome_regiao_localizacao_projeto = $request->input('ft_nome_regiao_localizacao_projeto');
    	
    	DB::insert('INSERT INTO osc.tb_localizacao_projeto (id_projeto, id_regiao_localizacao_projeto, 
    			ft_regiao_localizacao_projeto, tx_nome_regiao_localizacao_projeto, ft_nome_regiao_localizacao_projeto)
    			VALUES (?, ?, ?, ?, ?)',
    			[$id_projeto, $id_regiao_localizacao_projeto, $ft_regiao_localizacao_projeto, $tx_nome_regiao_localizacao_projeto, $ft_nome_regiao_localizacao_projeto]);
    }
    
    public function deleteLocalizacaoProjeto($id)
    {
    	DB::delete('DELETE FROM osc.tb_localizacao_projeto WHERE id_localizacao_projeto = ?::int', [$id]);
    }
    
    public function setParceiraProjeto(Request $request)
    {
    	$id_projeto = $request->input('id_projeto');
    	$id_osc = $request->input('id_osc');
    	if($id_osc != null) $ft_osc_parceira_projeto = "Usuario";
    	else $ft_osc_parceira_projeto = $request->input('ft_osc_parceira_projeto');
    
    	DB::insert('INSERT INTO osc.tb_osc_parceira_projeto (id_projeto, id_osc, ft_osc_parceira_projeto)
    			VALUES (?, ?, ?)',
    			[$id_projeto, $id_osc, $ft_osc_parceira_projeto]);
    }
    
    public function deleteParceiraProjeto($id)
    {
    	DB::delete('DELETE FROM osc.tb_osc_parceira_projeto WHERE id_osc = ?::int', [$id]);
    }
    
}
