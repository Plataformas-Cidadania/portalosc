-- object: portal.vw_osc_governanca | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_governanca CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_governanca
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_governanca.id_dirigente,
	tb_governanca.tx_cargo_dirigente,
	tb_governanca.ft_cargo_dirigente,
	tb_governanca.tx_nome_dirigente,
	tb_governanca.ft_nome_dirigente
FROM osc.tb_osc
INNER JOIN osc.tb_governanca ON tb_osc.id_osc = tb_governanca.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_governanca OWNER TO postgres;
-- ddl-end --