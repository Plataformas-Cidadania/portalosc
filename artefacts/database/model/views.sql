-- object: portal.vw_osc_dados_gerais | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_dados_gerais CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_dados_gerais
AS

SELECT
	osc.id_osc,
	osc.cd_identificador_osc,
	osc.ft_identificador_osc,
	tb_dados_gerais.tx_razao_social_osc,
	tb_dados_gerais.ft_razao_social_osc,
	tb_dados_gerais.tx_nome_fantasia_osc,
	tb_dados_gerais.ft_nome_fantasia_osc,
	tb_dados_gerais.im_logo,
	tb_dados_gerais.ft_logo,
	(SELECT dc_subclasse_atividade_economica.tx_subclasse_atividade_economica FROM syst.dc_subclasse_atividade_economica WHERE dc_subclasse_atividade_economica.cd_subclasse_atividade_economica = tb_dados_gerais.cd_atividade_economica_osc) AS tx_atividade_economica_osc,
	tb_dados_gerais.ft_atividade_economica_osc,
	(SELECT dc_natureza_juridica.tx_natureza_juridica FROM syst.dc_natureza_juridica WHERE dc_natureza_juridica.cd_natureza_juridica = tb_dados_gerais.cd_natureza_juridica_osc) AS tx_natureza_juridica_osc,
	tb_dados_gerais.ft_natureza_juridica_osc,
	tb_dados_gerais.tx_sigla_osc,
	tb_dados_gerais.ft_sigla_osc,
	tb_dados_gerais.tx_url_osc,
	tb_dados_gerais.ft_url_osc,
	tb_dados_gerais.dt_fundacao_osc,
	tb_dados_gerais.ft_fundacao_osc,
	tb_dados_gerais.dt_ano_cadastro_cnpj,
	tb_dados_gerais.ft_ano_cadastro_cnpj,
	tb_dados_gerais.tx_nome_responsavel_legal,
	tb_dados_gerais.ft_nome_responsavel_legal,
	tb_dados_gerais.tx_link_estatuto_osc,
	tb_dados_gerais.ft_link_estatuto_osc,
	tb_dados_gerais.tx_resumo_osc,
	tb_dados_gerais.ft_resumo_osc,
	(SELECT dc_situacao_imovel.tx_nome_situacao_imovel FROM syst.dc_situacao_imovel WHERE dc_situacao_imovel.cd_situacao_imovel = tb_dados_gerais.cd_situacao_imovel_osc) AS tx_nome_situacao_imovel_osc,
	tb_dados_gerais.ft_situacao_imovel_osc,
	tb_localizacao.tx_endereco,
	tb_localizacao.ft_endereco,
	tb_localizacao.nr_localizacao,
	tb_localizacao.ft_localizacao,
	tb_localizacao.tx_endereco_complemento,
	tb_localizacao.ft_endereco_complemento,
	tb_localizacao.tx_bairro,
	tb_localizacao.ft_bairro,
	(SELECT ed_municipio.edmu_nm_municipio FROM spat.ed_municipio WHERE ed_municipio.edmu_cd_municipio = tb_localizacao.cd_municipio) AS tx_municipio,
	tb_localizacao.ft_municipio,
	(SELECT ed_uf.eduf_sg_uf FROM spat.ed_uf WHERE ed_uf.eduf_cd_uf = (SELECT ed_municipio.eduf_cd_uf FROM spat.ed_municipio WHERE ed_municipio.edmu_cd_municipio = tb_localizacao.cd_municipio)::numeric) AS tx_uf,
	tb_localizacao.ft_municipio AS ft_uf,
	tb_localizacao.nr_cep,
	tb_localizacao.ft_cep,
	ST_Y(ST_TRANSFORM(tb_localizacao.geo_localizacao, 4674)) AS geo_lat,
	ST_X(ST_TRANSFORM(tb_localizacao.geo_localizacao, 4674)) AS geo_lng,
	tb_contato.tx_email,
	tb_contato.ft_email,
	tb_contato.tx_site,
	tb_contato.ft_site,
	tb_contato.tx_telefone,
	tb_contato.ft_telefone
FROM osc.tb_osc osc
LEFT JOIN osc.tb_dados_gerais
ON osc.id_osc = tb_dados_gerais.id_osc
LEFT JOIN osc.tb_localizacao
ON osc.id_osc = tb_localizacao.id_osc
LEFT JOIN osc.tb_contato
ON osc.id_osc = tb_contato.id_osc
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_dados_gerais OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_cabecalho | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_cabecalho CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_cabecalho
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	tb_osc.cd_identificador_osc,
	tb_osc.ft_identificador_osc,
	tb_dados_gerais.tx_razao_social_osc,
	tb_dados_gerais.ft_razao_social_osc,
	(SELECT dc_natureza_juridica.tx_natureza_juridica FROM syst.dc_natureza_juridica WHERE dc_natureza_juridica.cd_natureza_juridica = tb_dados_gerais.cd_natureza_juridica_osc) AS tx_natureza_juridica,
	tb_dados_gerais.ft_natureza_juridica_osc,
	tb_dados_gerais.im_logo,
	tb_dados_gerais.ft_logo
FROM osc.tb_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_cabecalho OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_area_atuacao | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_area_atuacao CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_area_atuacao
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	tb_area_atuacao_fasfil.id_area_atuacao_osc,
	(SELECT dc_area_atuacao_fasfil.tx_nome_macro_area FROM syst.dc_area_atuacao_fasfil WHERE dc_area_atuacao_fasfil.cd_area_atuacao_fasfil = tb_area_atuacao_fasfil.cd_area_atuacao_fasfil) AS tx_nome_macro_area_fasfil,
	(SELECT dc_area_atuacao_fasfil.tx_nome_subarea_fasfil FROM syst.dc_area_atuacao_fasfil WHERE dc_area_atuacao_fasfil.cd_area_atuacao_fasfil = tb_area_atuacao_fasfil.cd_area_atuacao_fasfil) AS tx_nome_area_fasfil,
	tb_area_atuacao_fasfil.ft_area_atuacao_fasfil
FROM osc.tb_osc
INNER JOIN osc.tb_area_atuacao_fasfil ON tb_osc.id_osc = tb_area_atuacao_fasfil.id_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_area_atuacao OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_descricao | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_descricao CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_descricao
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	tb_dados_gerais.tx_como_surgiu,
	tb_dados_gerais.ft_como_surgiu,
	tb_dados_gerais.tx_missao_osc,
	tb_dados_gerais.ft_missao_osc,
	tb_dados_gerais.tx_visao_osc,
	tb_dados_gerais.ft_visao_osc,
	tb_dados_gerais.tx_finalidades_estatutarias,
	tb_dados_gerais.ft_finalidades_estatutarias
FROM osc.tb_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_descricao OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_certificacao | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_certificacao CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_certificacao
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	tb_certificado.id_certificado,
	(SELECT tx_nome_certificado FROM syst.dc_certificado WHERE dc_certificado.cd_certificado = tb_certificado.cd_certificado) AS tx_nome_certificado,
	tb_certificado.dt_inicio_certificado,
	tb_certificado.dt_fim_certificado,
	tb_certificado.ft_certificado
FROM osc.tb_osc
INNER JOIN osc.tb_certificado ON tb_osc.id_osc = tb_certificado.id_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_certificacao OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_relacoes_trabalho | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_relacoes_trabalho CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_relacoes_trabalho
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	(tb_vinculo.nr_trabalhadores_vinculo + tb_vinculo.nr_trabalhadores_deficiencia + tb_vinculo.nr_trabalhadores_voluntarios) AS nr_trabalhadores,
	tb_vinculo.nr_trabalhadores_vinculo,
	tb_vinculo.ft_trabalhadores_vinculo,
	tb_vinculo.nr_trabalhadores_deficiencia,
	tb_vinculo.ft_trabalhadores_deficiencia,
	tb_vinculo.nr_trabalhadores_voluntarios,
	tb_vinculo.ft_trabalhadores_voluntarios
FROM osc.tb_osc
INNER JOIN osc.tb_vinculo ON tb_osc.id_osc = tb_vinculo.id_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_relacoes_trabalho OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_dirigente | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_dirigente CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_dirigente
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	tb_dirigente.id_dirigente,
	tb_dirigente.tx_cargo_dirigente,
	tb_dirigente.ft_cargo_dirigente,
	tb_dirigente.tx_nome_dirigente,
	tb_dirigente.ft_nome_dirigente
FROM osc.tb_osc
INNER JOIN osc.tb_dirigente ON tb_osc.id_osc = tb_dirigente.id_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_dirigente OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_recursos | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_recursos CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_recursos
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	(SELECT sum(tb_projeto.nr_valor_total_projeto) FROM osc.tb_projeto WHERE tb_projeto.id_osc = tb_osc.id_osc) AS nr_valor_total,
	(SELECT sum(projeto.nr_valor_total_projeto)	FROM osc.tb_projeto AS projeto INNER JOIN osc.tb_fonte_recursos_projeto AS recursos	ON projeto.id_projeto = recursos.id_projeto	WHERE (
		SELECT tx_nome_fonte_recursos
		FROM syst.dc_fonte_recursos
		WHERE cd_fonte_recursos = recursos.cd_fonte_recursos
	) = 'Público Federal') AS nr_valor_federal,
	(SELECT sum(projeto.nr_valor_total_projeto)	FROM osc.tb_projeto AS projeto INNER JOIN osc.tb_fonte_recursos_projeto AS recursos	ON projeto.id_projeto = recursos.id_projeto	WHERE (
		SELECT tx_nome_fonte_recursos
		FROM syst.dc_fonte_recursos
		WHERE cd_fonte_recursos = recursos.cd_fonte_recursos
	) = 'Público Estadual') AS nr_valor_estadual,
	(SELECT sum(projeto.nr_valor_total_projeto)	FROM osc.tb_projeto AS projeto INNER JOIN osc.tb_fonte_recursos_projeto AS recursos	ON projeto.id_projeto = recursos.id_projeto	WHERE (
		SELECT tx_nome_fonte_recursos
		FROM syst.dc_fonte_recursos
		WHERE cd_fonte_recursos = recursos.cd_fonte_recursos
	) = 'Público Municipal') AS nr_valor_municipal,
	(SELECT sum(projeto.nr_valor_total_projeto)	FROM osc.tb_projeto AS projeto INNER JOIN osc.tb_fonte_recursos_projeto AS recursos	ON projeto.id_projeto = recursos.id_projeto	WHERE (
		SELECT tx_nome_fonte_recursos
		FROM syst.dc_fonte_recursos
		WHERE cd_fonte_recursos = recursos.cd_fonte_recursos
	) = 'Privado') AS nr_valor_privado,
	(SELECT sum(projeto.nr_valor_total_projeto)	FROM osc.tb_projeto AS projeto INNER JOIN osc.tb_fonte_recursos_projeto AS recursos	ON projeto.id_projeto = recursos.id_projeto	WHERE (
		SELECT tx_nome_fonte_recursos
		FROM syst.dc_fonte_recursos
		WHERE cd_fonte_recursos = recursos.cd_fonte_recursos
	) = 'Próprio') AS nr_valor_proprio,
	tb_dados_gerais.tx_link_relatorio_auditoria,
	tb_dados_gerais.ft_link_relatorio_auditoria,
	tb_dados_gerais.tx_link_demonstracao_contabil,
	tb_dados_gerais.ft_link_demonstracao_contabil
FROM osc.tb_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_recursos OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_geo_osc | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_geo_osc CASCADE;
CREATE MATERIALIZED VIEW portal.vw_geo_osc
AS

SELECT
	tb_osc.id_osc,
	ST_Y(ST_TRANSFORM(tb_localizacao.geo_localizacao, 4674)) AS geo_lat,
	ST_x(ST_TRANSFORM(tb_localizacao.geo_localizacao, 4674)) AS geo_lng,
	tb_localizacao.ft_geo_localizacao,
	tb_localizacao.cd_municipio,
	tb_localizacao.ft_municipio,
	(SELECT eduf_cd_uf FROM spat.ed_municipio WHERE edmu_cd_municipio = tb_localizacao.cd_municipio) AS cd_estado,
	tb_localizacao.ft_municipio AS ft_estado,
	(SELECT ed_uf.edre_cd_regiao FROM spat.ed_uf WHERE ed_uf.eduf_cd_uf = (SELECT ed_municipio.eduf_cd_uf FROM spat.ed_municipio WHERE ed_municipio.edmu_cd_municipio = tb_localizacao.cd_municipio)) AS cd_regiao,
	tb_localizacao.ft_municipio AS ft_regiao
FROM osc.tb_osc
INNER JOIN osc.tb_localizacao ON tb_osc.id_osc = tb_localizacao.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_geo_osc OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_spat_regiao | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_spat_regiao CASCADE;
CREATE MATERIALIZED VIEW portal.vw_spat_regiao
AS

SELECT
	ed_regiao.edre_cd_regiao,
	ed_regiao.edre_nm_regiao,
	UNACCENT(ed_regiao.edre_nm_regiao) AS edre_nm_regiao_adjusted,
    setweight(to_tsvector('portuguese_unaccent', coalesce(ed_regiao.edre_nm_regiao, '')), 'A') AS document
FROM spat.ed_regiao;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_spat_regiao OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_spat_estado | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_spat_estado CASCADE;
CREATE MATERIALIZED VIEW portal.vw_spat_estado
AS

SELECT
	ed_uf.eduf_cd_uf,
	ed_uf.eduf_nm_uf,
	UNACCENT(ed_uf.eduf_nm_uf) AS eduf_nm_uf_adjusted,
	ed_uf.eduf_sg_uf,
    setweight(to_tsvector('portuguese_unaccent', coalesce(ed_uf.eduf_nm_uf, '')), 'A') ||
	setweight(to_tsvector('portuguese_unaccent', coalesce(ed_uf.eduf_sg_uf, '')), 'B')
	AS document
FROM spat.ed_uf;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_spat_estado OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_spat_municipio | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_spat_municipio CASCADE;
CREATE MATERIALIZED VIEW portal.vw_spat_municipio
AS

SELECT
	ed_municipio.edmu_cd_municipio,
	ed_municipio.edmu_nm_municipio,
	UNACCENT(ed_municipio.edmu_nm_municipio) AS edmu_nm_municipio_adjusted,
	(SELECT ed_uf.eduf_sg_uf FROM spat.ed_uf WHERE ed_uf.eduf_cd_uf = ed_municipio.eduf_cd_uf) AS eduf_sg_uf,
    setweight(to_tsvector('portuguese_unaccent', coalesce(ed_municipio.edmu_nm_municipio, '')), 'A') AS document
FROM spat.ed_municipio;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_spat_municipio OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_projeto
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	projeto.id_projeto,
	projeto.tx_identificador_projeto_externo,
	projeto.ft_identificador_projeto_externo,
	projeto.tx_nome_projeto,
	projeto.ft_nome_projeto,
	(SELECT dc_status_projeto.tx_nome_status_projeto FROM syst.dc_status_projeto WHERE dc_status_projeto.cd_status_projeto = projeto.cd_status_projeto) AS tx_nome_status_projeto,
	projeto.ft_status_projeto,
	projeto.dt_data_inicio_projeto,
	projeto.ft_data_inicio_projeto,
	projeto.dt_data_fim_projeto,
	projeto.ft_data_fim_projeto,
	projeto.tx_link_projeto,
	projeto.ft_link_projeto,
	projeto.nr_total_beneficiarios,
	projeto.ft_total_beneficiarios,
	projeto.nr_valor_total_projeto,
	projeto.ft_valor_total_projeto,
	projeto.nr_valor_captado_projeto,
	projeto.ft_valor_captado_projeto,
	projeto.tx_metodologia_monitoramento,
	projeto.ft_metodologia_monitoramento,
	projeto.tx_descricao_projeto,
	projeto.ft_descricao_projeto,
	(SELECT dc_abrangencia_projeto.tx_nome_abrangencia_projeto FROM syst.dc_abrangencia_projeto WHERE dc_abrangencia_projeto.cd_abrangencia_projeto = projeto.cd_abrangencia_projeto) AS tx_nome_abrangencia_projeto,
	projeto.ft_abrangencia_projeto,
	(SELECT dc_zona_atuacao_projeto.tx_nome_zona_atuacao FROM syst.dc_zona_atuacao_projeto WHERE dc_zona_atuacao_projeto.cd_zona_atuacao_projeto = projeto.cd_zona_atuacao_projeto) AS tx_nome_zona_atuacao,
	projeto.ft_zona_atuacao_projeto
FROM osc.tb_osc 
LEFT JOIN osc.tb_dados_gerais 
ON tb_osc.id_osc = tb_dados_gerais.id_osc 
JOIN osc.tb_projeto projeto ON tb_osc.id_osc = projeto.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_projeto OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_area_atuacao_outra_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_area_atuacao_outra_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_area_atuacao_outra_projeto
AS

SELECT
	area_atuacao.id_projeto,
	area_atuacao.id_area_atuacao_outra_projeto,
	(SELECT tb_area_atuacao_declarada.tx_nome_area_atuacao_declarada FROM osc.tb_area_atuacao_declarada WHERE tb_area_atuacao_declarada.id_area_atuacao_declarada = area_atuacao.id_area_atuacao_outra) AS tx_nome_area_atuacao_outra,
	area_atuacao.ft_area_atuacao_outra
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_area_atuacao_outra_projeto AS area_atuacao
ON area_atuacao.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_area_atuacao_outra_projeto OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_fonte_recursos_projeto | type: VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_fonte_recursos_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_fonte_recursos_projeto
AS

SELECT
	fonte_recurso.id_projeto,
	fonte_recurso.id_fonte_recursos_projeto,
	(SELECT dc_fonte_recursos.tx_nome_fonte_recursos FROM syst.dc_fonte_recursos WHERE dc_fonte_recursos.cd_fonte_recursos = fonte_recurso.cd_fonte_recursos) AS tx_nome_fonte_recursos,
	fonte_recurso.ft_fonte_recursos_projeto
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_fonte_recursos_projeto AS fonte_recurso
ON fonte_recurso.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_fonte_recursos_projeto OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_parceira_projeto | type: VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_parceira_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_parceira_projeto
AS

SELECT
	parceira.id_osc,
	parceira.id_projeto,
	parceira.ft_osc_parceira_projeto,
	(SELECT COALESCE(tb_dados_gerais.tx_nome_fantasia_osc, tb_dados_gerais.tx_razao_social_osc) FROM osc.tb_dados_gerais WHERE tb_dados_gerais.id_osc = parceira.id_osc) AS tx_nome_osc_parceira_projeto
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_osc_parceira_projeto AS parceira
ON parceira.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_parceira_projeto OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_publico_beneficiado_projeto | type: VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_publico_beneficiado_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_publico_beneficiado_projeto
AS

SELECT
	publico_beneficiado.id_projeto,
	publico_beneficiado.id_publico_beneficiado,
	(SELECT tb_publico_beneficiado.tx_nome_publico_beneficiado FROM osc.tb_publico_beneficiado WHERE tb_publico_beneficiado.id_publico_beneficiado = publico_beneficiado.id_publico_beneficiado) AS tx_nome_publico_beneficiado,
	publico_beneficiado.ft_publico_beneficiado_projeto
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_publico_beneficiado_projeto AS publico_beneficiado
ON publico_beneficiado.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_publico_beneficiado_projeto OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_financiador_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_financiador_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_financiador_projeto
AS

SELECT
	financiador.id_projeto,
	financiador.id_financiador_projeto,
	financiador.tx_nome_financiador,
	financiador.ft_nome_financiador
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_financiador_projeto AS financiador
ON financiador.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_financiador_projeto OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_localizacao_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_localizacao_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_localizacao_projeto
AS

SELECT
	localizacao.id_projeto,
	localizacao.id_regiao_localizacao_projeto,
	localizacao.tx_nome_regiao_localizacao_projeto,
	localizacao.ft_nome_regiao_localizacao_projeto
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_localizacao_projeto AS localizacao
ON localizacao.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_localizacao_projeto OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_conselho_contabil | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_conselho_contabil CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_conselho_contabil
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	tb_conselho_contabil.id_conselheiro,
	tb_conselho_contabil.tx_nome_conselheiro,
	tb_conselho_contabil.ft_nome_conselheiro,
	tb_conselho_contabil.tx_cargo_conselheiro,
	tb_conselho_contabil.ft_cargo_conselheiro
FROM osc.tb_osc
LEFT JOIN osc.tb_dados_gerais
ON tb_osc.id_osc = tb_dados_gerais.id_osc
INNER JOIN osc.tb_conselho_contabil
ON tb_osc.id_osc = tb_conselho_contabil.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_conselho_contabil OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_participacao_social_conferencia | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_participacao_social_conferencia CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_participacao_social_conferencia
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	tb_participacao_social_conferencia.id_conferencia,
	tb_participacao_social_conferencia.tx_nome_conferencia,
	tb_participacao_social_conferencia.ft_nome_conferencia,
	tb_participacao_social_conferencia.dt_data_inicio_conferencia,
	tb_participacao_social_conferencia.ft_data_inicio_conferencia,
	tb_participacao_social_conferencia.dt_data_fim_conferencia,
	tb_participacao_social_conferencia.ft_data_fim_conferencia
FROM osc.tb_osc
LEFT JOIN osc.tb_dados_gerais
ON tb_osc.id_osc = tb_dados_gerais.id_osc
INNER JOIN osc.tb_participacao_social_conferencia
ON tb_osc.id_osc = tb_participacao_social_conferencia.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_participacao_social_conferencia OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_participacao_social_conselho | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_participacao_social_conselho CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_participacao_social_conselho
AS 

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	tb_participacao_social_conselho.id_conselho,
	(SELECT tx_nome_conselho FROM syst.dc_conselho WHERE cd_conselho = tb_participacao_social_conselho.cd_conselho) AS tx_nome_conselho,
	tb_participacao_social_conselho.ft_conselho,
	tb_participacao_social_conselho.nr_numero_assentos,
	tb_participacao_social_conselho.ft_numero_assentos,
	tb_participacao_social_conselho.tx_periodicidade_reuniao,
	tb_participacao_social_conselho.ft_periodicidade_reuniao,
	tb_participacao_social_conselho.cd_tipo_participacao,
	(SELECT nm_tipo_participacao FROM syst.dc_tipo_participacao WHERE dc_tipo_participacao.cd_tipo_participacao = tb_participacao_social_conselho.cd_tipo_participacao) AS nm_tipo_participacao,
	tb_participacao_social_conselho.ft_tipo_participacao
FROM osc.tb_osc
LEFT JOIN osc.tb_dados_gerais
ON tb_osc.id_osc = tb_dados_gerais.id_osc
INNER JOIN osc.tb_participacao_social_conselho ON tb_osc.id_osc = tb_participacao_social_conselho.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_participacao_social_conselho OWNER TO postgres;
-- ddl-end --

-- object: portal.vw_osc_participacao_social_outra | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_participacao_social_outra CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_participacao_social_outra
AS

SELECT
	tb_osc.id_osc,
	tb_dados_gerais.tx_url_osc,
	tb_participacao_social_outra.id_outra_participacao_social,
	tb_participacao_social_outra.tx_nome_outra_participacao_social,
	tb_participacao_social_outra.ft_nome_outra_participacao_social,
	tb_participacao_social_outra.tx_tipo_outra_participacao_social,
	tb_participacao_social_outra.ft_tipo_outra_participacao_social,
	tb_participacao_social_outra.dt_data_ingresso_outra_participacao_social,
	tb_participacao_social_outra.ft_data_ingresso_outra_participacao_social
FROM osc.tb_osc
LEFT JOIN osc.tb_dados_gerais
ON tb_osc.id_osc = tb_dados_gerais.id_osc
INNER JOIN osc.tb_participacao_social_outra ON tb_osc.id_osc = tb_participacao_social_outra.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_participacao_social_outra OWNER TO postgres;
-- ddl-end --

DROP MATERIALIZED VIEW IF EXISTS portal.vw_busca_osc CASCADE;
CREATE MATERIALIZED VIEW portal.vw_busca_osc AS 
SELECT 
	tb_osc.id_osc, 
	tb_osc.cd_identificador_osc, 
	tb_dados_gerais.tx_razao_social_osc, 
	tb_dados_gerais.tx_nome_fantasia_osc, 
    setweight(to_tsvector('portuguese_unaccent', coalesce(tb_osc.cd_identificador_osc::TEXT, '')), 'A') || 
    setweight(to_tsvector('portuguese_unaccent', coalesce(tb_dados_gerais.tx_razao_social_osc::TEXT, '')), 'B') || 
	setweight(to_tsvector('portuguese_unaccent', coalesce(tb_dados_gerais.tx_nome_fantasia_osc::TEXT, '')), 'C') AS document 
FROM osc.tb_osc 
LEFT JOIN osc.tb_dados_gerais 
ON tb_osc.id_osc = tb_dados_gerais.id_osc 
WHERE tb_osc.bo_osc_ativa = true;

DROP MATERIALIZED VIEW IF EXISTS portal.vw_busca_osc_geo CASCADE;
CREATE MATERIALIZED VIEW portal.vw_busca_osc_geo AS 
SELECT 
	tb_osc.id_osc, 
	tb_localizacao.cd_municipio, 
	SUBSTR(tb_localizacao.cd_municipio::TEXT, 0, 3)::NUMERIC(2, 0) AS cd_estado, 
	SUBSTR(tb_localizacao.cd_municipio::TEXT, 0, 2)::NUMERIC(1, 0) AS cd_regiao 
FROM osc.tb_osc 
LEFT JOIN osc.tb_localizacao 
ON tb_osc.id_osc = tb_localizacao.id_osc 
WHERE tb_osc.bo_osc_ativa = true;

DROP MATERIALIZED VIEW IF EXISTS portal.vw_resultado_busca CASCADE;
CREATE MATERIALIZED VIEW portal.vw_resultado_busca AS 
SELECT 
	tb_osc.id_osc, 
	coalesce(tb_dados_gerais.tx_nome_fantasia_osc, tb_dados_gerais.tx_razao_social_osc) AS tx_nome_osc, 
	tb_osc.cd_identificador_osc, 
	(SELECT dc_natureza_juridica.tx_natureza_juridica FROM syst.dc_natureza_juridica WHERE dc_natureza_juridica.cd_natureza_juridica = tb_dados_gerais.cd_natureza_juridica_osc) AS tx_natureza_juridica_osc, 
	(
		rtrim(
			replace(
				COALESCE(tb_localizacao.tx_endereco::TEXT, '|') || ', ' || 
				COALESCE(tb_localizacao.nr_localizacao::TEXT, '|') || ', ' || 
				COALESCE(tb_localizacao.tx_endereco_complemento::TEXT, '|') || ', ' || 
				COALESCE(tb_localizacao.tx_bairro::TEXT, '|') || ', ' || 
				COALESCE((SELECT ed_municipio.edmu_nm_municipio AS tx_municipio FROM spat.ed_municipio WHERE ed_municipio.edmu_cd_municipio = tb_localizacao.cd_municipio)::TEXT, '|') || ', ' || 
				COALESCE((SELECT ed_uf.eduf_sg_uf AS tx_uf FROM spat.ed_uf WHERE ed_uf.eduf_cd_uf = (SUBSTR(tb_localizacao.cd_municipio::TEXT, 0, 2)::NUMERIC))::TEXT, '|') || ', ' || 
				COALESCE(tb_localizacao.nr_cep::TEXT, '|'), '|, ', ''
			), ', |'
		)
	) AS tx_endereco_osc, 
	ST_Y(ST_TRANSFORM(tb_localizacao.geo_localizacao, 4674)) AS geo_lat, 
	ST_X(ST_TRANSFORM(tb_localizacao.geo_localizacao, 4674)) AS geo_lng 
FROM osc.tb_osc 
LEFT JOIN osc.tb_dados_gerais 
ON tb_osc.id_osc = tb_dados_gerais.id_osc 
LEFT JOIN osc.tb_localizacao 
ON tb_osc.id_osc = tb_localizacao.id_osc 
WHERE tb_osc.bo_osc_ativa = true;
