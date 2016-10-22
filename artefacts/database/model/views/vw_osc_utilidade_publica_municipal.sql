-- object: portal.vw_osc_utilidade_publica_municipal | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_utilidade_publica_municipal CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_utilidade_publica_municipal
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_utilidade_publica_municipal.dt_data_validade,
	tb_utilidade_publica_municipal.ft_utilidade_publica_municipal
FROM osc.tb_osc
INNER JOIN osc.tb_utilidade_publica_municipal ON tb_osc.id_osc = tb_utilidade_publica_municipal.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_utilidade_publica_municipal OWNER TO postgres;
-- ddl-end --