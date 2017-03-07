-- object: portal.vw_osc_descricao | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_descricao CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_descricao
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_dados_gerais.tx_historico,
	tb_dados_gerais.ft_historico,
	tb_dados_gerais.tx_missao_osc,
	tb_dados_gerais.ft_missao_osc,
	tb_dados_gerais.tx_visao_osc,
	tb_dados_gerais.ft_visao_osc,
	tb_dados_gerais.tx_finalidades_estatutarias,
	tb_dados_gerais.ft_finalidades_estatutarias,
	tb_dados_gerais.tx_link_estatuto_osc,
	tb_dados_gerais.ft_link_estatuto_osc
FROM osc.tb_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_descricao OWNER TO postgres;
-- ddl-end --