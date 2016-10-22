-- object: portal.vw_osc_cabecalho | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_cabecalho CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_cabecalho
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
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