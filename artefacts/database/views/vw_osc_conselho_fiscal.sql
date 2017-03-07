-- object: portal.vw_osc_conselho_fiscal | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_conselho_fiscal CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_conselho_fiscal
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_conselho_fiscal.id_conselheiro,
	tb_conselho_fiscal.tx_nome_conselheiro,
	tb_conselho_fiscal.ft_nome_conselheiro
FROM osc.tb_osc
INNER JOIN osc.tb_conselho_fiscal
ON tb_osc.id_osc = tb_conselho_fiscal.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_conselho_fiscal OWNER TO postgres;
-- ddl-end --