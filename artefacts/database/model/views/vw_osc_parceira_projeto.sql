-- object: portal.vw_osc_parceira_projeto | type: VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_parceira_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_parceira_projeto
AS

SELECT
	tb_osc_parceira_projeto.id_projeto,
	tb_osc_parceira_projeto.id_osc,
	(SELECT COALESCE(tb_dados_gerais.tx_nome_fantasia_osc, tb_dados_gerais.tx_razao_social_osc) FROM osc.tb_dados_gerais WHERE tb_dados_gerais.id_osc = tb_osc_parceira_projeto.id_osc) AS tx_nome_osc_parceira_projeto,
	tb_osc_parceira_projeto.ft_osc_parceira_projeto
FROM osc.tb_osc
INNER JOIN osc.tb_projeto ON osc.tb_projeto.id_osc = osc.tb_osc.id_osc
INNER JOIN osc.tb_osc_parceira_projeto ON tb_osc_parceira_projeto.id_projeto = osc.tb_projeto.id_projeto
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_parceira_projeto OWNER TO postgres;
-- ddl-end --