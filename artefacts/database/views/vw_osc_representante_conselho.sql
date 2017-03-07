-- object: portal.vw_osc_representante_conselho | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_representante_conselho CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_representante_conselho
AS 

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_representante_conselho.id_representante_conselho,
	tb_representante_conselho.id_participacao_social_conselho,
	tb_representante_conselho.tx_nome_representante_conselho,
	tb_representante_conselho.ft_nome_representante_conselho
FROM osc.tb_osc
INNER JOIN osc.tb_representante_conselho ON tb_osc.id_osc = tb_representante_conselho.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_representante_conselho OWNER TO postgres;
-- ddl-end --