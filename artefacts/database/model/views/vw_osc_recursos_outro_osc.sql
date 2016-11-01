-- object: portal.vw_osc_recursos_outro_osc | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_recursos_outro_osc CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_recursos_outro_osc
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_recursos_outro_osc.id_recursos_outro_osc,
	tb_recursos_outro_osc.tx_nome_fonte_recursos_outro_osc,
	tb_recursos_outro_osc.ft_nome_fonte_recursos_outro_osc,
	tb_recursos_outro_osc.dt_ano_recursos_outro_osc,
	tb_recursos_outro_osc.ft_ano_recursos_outro_osc,
	tb_recursos_outro_osc.nr_valor_recursos_outro_osc,
	tb_recursos_outro_osc.ft_valor_recursos_outro_osc
FROM osc.tb_osc
INNER JOIN osc.tb_recursos_outro_osc ON tb_osc.id_osc = tb_recursos_outro_osc.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_recursos_outro_osc OWNER TO postgres;
-- ddl-end --
