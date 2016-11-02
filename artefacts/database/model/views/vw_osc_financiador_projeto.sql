-- object: portal.vw_osc_financiador_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_financiador_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_financiador_projeto
AS

SELECT
	tb_financiador_projeto.id_projeto,
	tb_financiador_projeto.id_financiador_projeto,
	tb_financiador_projeto.tx_nome_financiador,
	tb_financiador_projeto.ft_nome_financiador
FROM osc.tb_osc
INNER JOIN osc.tb_financiador_projeto
ON tb_financiador_projeto.id_projeto IN (SELECT id_projeto FROM osc.tb_projeto WHERE id_osc = tb_osc.id_osc)
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_financiador_projeto OWNER TO postgres;
-- ddl-end --