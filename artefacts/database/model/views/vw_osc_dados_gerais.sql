-- object: portal.vw_osc_dados_gerais | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_dados_gerais CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_dados_gerais
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_osc.ft_apelido_osc,
	LPAD(CAST(tb_osc.cd_identificador_osc AS VARCHAR), 14, '0') AS cd_identificador_osc,
	tb_osc.ft_identificador_osc,
	tb_dados_gerais.tx_razao_social_osc,
	tb_dados_gerais.ft_razao_social_osc,
	tb_dados_gerais.tx_nome_fantasia_osc,
	tb_dados_gerais.ft_nome_fantasia_osc,
	COALESCE(tb_dados_gerais.tx_nome_fantasia_osc, tb_dados_gerais.tx_razao_social_osc) AS tx_nome_osc,
	'data:image/png;base64,' || tb_dados_gerais.im_logo AS im_logo,
	tb_dados_gerais.ft_logo,
	tb_dados_gerais.cd_subclasse_atividade_economica_osc AS cd_atividade_economica_osc,
	(SELECT tx_nome_subclasse_atividade_economica FROM syst.dc_subclasse_atividade_economica WHERE cd_subclasse_atividade_economica = tb_dados_gerais.cd_subclasse_atividade_economica_osc) AS tx_nome_atividade_economica_osc,
	tb_dados_gerais.ft_subclasse_atividade_economica_osc AS ft_atividade_economica_osc,
	tb_dados_gerais.cd_natureza_juridica_osc,
	(SELECT tx_nome_natureza_juridica FROM syst.dc_natureza_juridica WHERE cd_natureza_juridica = tb_dados_gerais.cd_natureza_juridica_osc) AS tx_nome_natureza_juridica_osc,
	tb_dados_gerais.ft_natureza_juridica_osc,
	tb_dados_gerais.tx_sigla_osc,
	tb_dados_gerais.ft_sigla_osc,
	TO_CHAR(tb_dados_gerais.dt_fundacao_osc, 'DD-MM-YYYY') AS dt_fundacao_osc,
	tb_dados_gerais.ft_fundacao_osc,
	TO_CHAR(tb_dados_gerais.dt_ano_cadastro_cnpj, 'DD-MM-YYYY') AS dt_ano_cadastro_cnpj,
	tb_dados_gerais.ft_ano_cadastro_cnpj,
	tb_dados_gerais.tx_nome_responsavel_legal,
	tb_dados_gerais.ft_nome_responsavel_legal,
	tb_dados_gerais.tx_resumo_osc,
	tb_dados_gerais.ft_resumo_osc,
	tb_dados_gerais.cd_situacao_imovel_osc,
	(SELECT tx_nome_situacao_imovel FROM syst.dc_situacao_imovel WHERE cd_situacao_imovel = tb_dados_gerais.cd_situacao_imovel_osc) AS tx_nome_situacao_imovel_osc,
	tb_dados_gerais.ft_situacao_imovel_osc,
	tb_dados_gerais.tx_link_estatuto_osc,
	tb_dados_gerais.ft_link_estatuto_osc,
	tb_localizacao.tx_endereco,
	tb_localizacao.ft_endereco,
	tb_localizacao.nr_localizacao,
	tb_localizacao.ft_localizacao,
	tb_localizacao.tx_endereco_complemento,
	tb_localizacao.ft_endereco_complemento,
	tb_localizacao.tx_bairro,
	tb_localizacao.ft_bairro,
	tb_localizacao.cd_municipio,
	(SELECT edmu_nm_municipio FROM spat.ed_municipio WHERE edmu_cd_municipio = tb_localizacao.cd_municipio) AS tx_nome_municipio,
	tb_localizacao.ft_municipio,
	SUBSTR(tb_localizacao.cd_municipio::TEXT, 0, 3)::NUMERIC(2, 0) AS cd_uf,
	(SELECT eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf = SUBSTR(tb_localizacao.cd_municipio::TEXT, 0, 3)::NUMERIC(2, 0)) AS tx_sigla_uf,
	(SELECT eduf_nm_uf FROM spat.ed_uf WHERE eduf_cd_uf = SUBSTR(tb_localizacao.cd_municipio::TEXT, 0, 3)::NUMERIC(2, 0)) AS tx_nome_uf,
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
FROM osc.tb_osc
LEFT JOIN osc.tb_dados_gerais
ON tb_osc.id_osc = tb_dados_gerais.id_osc
LEFT JOIN osc.tb_localizacao
ON tb_osc.id_osc = tb_localizacao.id_osc
LEFT JOIN osc.tb_contato
ON tb_osc.id_osc = tb_contato.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_dados_gerais OWNER TO postgres;
-- ddl-end --
