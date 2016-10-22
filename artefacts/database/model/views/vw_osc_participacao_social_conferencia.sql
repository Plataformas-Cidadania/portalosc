-- object: portal.vw_osc_participacao_social_conferencia | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_participacao_social_conferencia CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_participacao_social_conferencia
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_participacao_social_conferencia.id_conferencia,
	tb_participacao_social_conferencia.tx_nome_conferencia,
	tb_participacao_social_conferencia.ft_nome_conferencia,
	tb_participacao_social_conferencia.dt_data_inicio_conferencia,
	tb_participacao_social_conferencia.ft_data_inicio_conferencia,
	tb_participacao_social_conferencia.dt_data_fim_conferencia,
	tb_participacao_social_conferencia.ft_data_fim_conferencia
FROM osc.tb_osc
INNER JOIN osc.tb_participacao_social_conferencia
ON tb_osc.id_osc = tb_participacao_social_conferencia.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_participacao_social_conferencia OWNER TO postgres;
-- ddl-end --