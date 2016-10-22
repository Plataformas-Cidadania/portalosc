-- object: portal.vw_osc_utilidade_publica_estadual | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_utilidade_publica_estadual CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_utilidade_publica_estadual
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_utilidade_publica_estadual.dt_data_validade,
	tb_utilidade_publica_estadual.ft_utilidade_publica_estadual
FROM osc.tb_osc
INNER JOIN osc.tb_utilidade_publica_estadual ON tb_osc.id_osc = tb_utilidade_publica_estadual.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_utilidade_publica_estadual OWNER TO postgres;
-- ddl-end --