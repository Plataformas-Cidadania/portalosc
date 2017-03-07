-- object: portal.vw_osc_recursos_osc | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_recursos_osc CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_recursos_osc
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_recursos_osc.id_recursos_osc,
	tb_recursos_osc.cd_fonte_recursos_osc,
	(SELECT tx_nome_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE cd_origem_fonte_recursos_osc = (SELECT cd_origem_fonte_recursos_osc FROM syst.dc_fonte_recursos_osc WHERE cd_fonte_recursos_osc = tb_recursos_osc.cd_fonte_recursos_osc)) AS tx_nome_origem_fonte_recursos_osc,
	(SELECT tx_nome_fonte_recursos_osc FROM syst.dc_fonte_recursos_osc WHERE cd_fonte_recursos_osc = tb_recursos_osc.cd_fonte_recursos_osc) AS tx_nome_fonte_recursos_osc,
	tb_recursos_osc.ft_fonte_recursos_osc,
	SUBSTRING(tb_recursos_osc.dt_ano_recursos_osc::TEXT from 1 for 4) AS dt_ano_recursos_osc,
	tb_recursos_osc.ft_ano_recursos_osc,
	tb_recursos_osc.nr_valor_recursos_osc,
	tb_recursos_osc.ft_valor_recursos_osc
FROM osc.tb_osc
INNER JOIN osc.tb_recursos_osc ON tb_osc.id_osc = tb_recursos_osc.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_recursos_osc OWNER TO postgres;
-- ddl-end --