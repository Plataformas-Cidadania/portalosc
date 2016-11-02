BEGIN;

	\ir views/vw_busca_osc.sql;
	\ir views/vw_busca_osc_geo.sql;
	\ir views/vw_busca_resultado.sql;
	
	\ir views/vw_geo_osc.sql;
	
	\ir views/vw_osc_area_atuacao.sql;
	\ir views/vw_osc_area_atuacao_outra.sql;
	\ir views/vw_osc_area_atuacao_outra_projeto.sql;
	\ir views/vw_osc_cabecalho.sql;
	\ir views/vw_osc_certificado.sql;
	\ir views/vw_osc_conselho_fiscal.sql;
	\ir views/vw_osc_dados_gerais.sql;
	\ir views/vw_osc_descricao.sql;
	\ir views/vw_osc_financiador_projeto.sql;
	\ir views/vw_osc_fonte_recursos_projeto.sql;
	\ir views/vw_osc_governanca.sql;
	\ir views/vw_osc_localizacao_projeto.sql;
	\ir views/vw_osc_parceira_projeto.sql;
	\ir views/vw_osc_participacao_social_conferencia.sql;
	\ir views/vw_osc_participacao_social_conferencia_outra.sql;
	\ir views/vw_osc_participacao_social_conselho.sql;
	\ir views/vw_osc_participacao_social_declarada.sql;
	\ir views/vw_osc_participacao_social_outra.sql;
	\ir views/vw_osc_projeto.sql;
	\ir views/vw_osc_publico_beneficiado_projeto.sql;
	\ir views/vw_osc_recursos_osc.sql;
	\ir views/vw_osc_recursos_outro_osc.sql;
	\ir views/vw_osc_recursos_projeto.sql;
	\ir views/vw_osc_relacoes_trabalho.sql;
	\ir views/vw_osc_relacoes_trabalho_outra.sql;
	\ir views/vw_osc_representante_conselho.sql;
	
	\ir views/vw_spat_estado.sql;
	\ir views/vw_spat_municipio.sql;
	\ir views/vw_spat_regiao.sql;

COMMIT;
