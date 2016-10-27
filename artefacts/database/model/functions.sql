BEGIN;

	\ir functions/busca/buscar_osc.sql;
	\ir functions/busca/buscar_osc_autocomplete.sql;
	\ir functions/busca/buscar_osc_geo.sql;
	\ir functions/busca/buscar_osc_lista.sql;
	\ir functions/busca/buscar_osc_municipio.sql;
	\ir functions/busca/buscar_osc_municipio_autocomplete.sql;
	\ir functions/busca/buscar_osc_municipio_geo.sql;
	\ir functions/busca/buscar_osc_municipio_lista.sql;
	\ir functions/busca/buscar_osc_estado.sql;
	\ir functions/busca/buscar_osc_estado_autocomplete.sql;
	\ir functions/busca/buscar_osc_estado_geo.sql;
	\ir functions/busca/buscar_osc_estado_lista.sql;
	\ir functions/busca/buscar_osc_regiao.sql;
	\ir functions/busca/buscar_osc_regiao_autocomplete.sql;
	\ir functions/busca/buscar_osc_regiao_geo.sql;
	\ir functions/busca/buscar_osc_regiao_lista.sql;

	\ir functions/geo/obter_geo_osc.sql;
	\ir functions/geo/obter_geo_osc_municipio.sql;
	\ir functions/geo/obter_geo_osc_estado.sql;
	\ir functions/geo/obter_geo_osc_regiao.sql;
	\ir functions/geo/obter_geo_osc_pais.sql;

	\ir functions/menu/obter_menu_municipio.sql;
	\ir functions/menu/obter_menu_estado.sql;
	\ir functions/menu/obter_menu_regiao.sql;

	\ir functions/osc/obter_osc_area_atuacao.sql;
	\ir functions/osc/obter_osc_area_atuacao_outra.sql;
	\ir functions/osc/obter_osc_area_atuacao_outra_projeto.sql;
	\ir functions/osc/obter_osc_cabecalho.sql;
	\ir functions/osc/obter_osc_certificacao.sql;
	\ir functions/osc/obter_osc_conselho_fiscal.sql;
	\ir functions/osc/obter_osc_dados_gerais.sql;
	\ir functions/osc/obter_osc_descricao.sql;
	\ir functions/osc/obter_osc_financiador_projeto.sql;
	\ir functions/osc/obter_osc_fonte_recursos_projeto.sql;
	\ir functions/osc/obter_osc_governanca.sql;
	\ir functions/osc/obter_osc_localizacao_projeto.sql;
	\ir functions/osc/obter_osc_parceira_projeto.sql;
	\ir functions/osc/obter_osc_participacao_social_conferencia.sql;
	\ir functions/osc/obter_osc_participacao_social_conselho.sql;
	\ir functions/osc/obter_osc_participacao_social_outra.sql;
	\ir functions/osc/obter_osc_projeto.sql;
	\ir functions/osc/obter_osc_publico_beneficiado_projeto.sql;
	\ir functions/osc/obter_osc_recursos.sql;
	\ir functions/osc/obter_osc_relacoes_trabalho.sql;
	\ir functions/osc/obter_osc_relacoes_trabalho_outra.sql;
	\ir functions/osc/atualizar_apelido.sql;
	\ir functions/osc/atualizar_contato.sql;
	\ir functions/osc/atualizar_dados_gerais.sql;
	\ir functions/osc/inserir_contato.sql;

	\ir functions/usuario/excluir_token_representante.sql;
	\ir functions/usuario/inserir_token_representante.sql;
	\ir functions/usuario/ativar_representante.sql;
	\ir functions/usuario/atualizar_representacao.sql;
	\ir functions/usuario/atualizar_representante.sql;
	\ir functions/usuario/atualizar_senha.sql;
	\ir functions/usuario/criar_representante.sql;
	\ir functions/usuario/logar_representante.sql;
	\ir functions/usuario/obter_representacao.sql;
	\ir functions/usuario/obter_representante.sql;
	\ir functions/usuario/obter_token_representante.sql;

	\ir functions/edital/inserir_edital.sql;
	\ir functions/edital/obter_editais_ativos.sql;
	\ir functions/edital/obter_editais_encerrados.sql;

COMMIT;
