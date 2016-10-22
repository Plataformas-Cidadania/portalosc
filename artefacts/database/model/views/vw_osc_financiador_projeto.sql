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