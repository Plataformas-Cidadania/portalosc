-- object: portal.vw_osc_participacao_social_conferencia | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_participacao_social_conferencia CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_participacao_social_conferencia
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_participacao_social_conferencia.id_conferencia,
	tb_participacao_social_conferencia.cd_conferencia,
	(SELECT tx_nome_conferencia FROM syst.dc_conferencia WHERE cd_conferencia = tb_participacao_social_conferencia.cd_conferencia) AS tx_nome_conferencia,
	tb_participacao_social_conferencia.ft_conferencia,
	tb_participacao_social_conferencia.dt_ano_realizacao,
	tb_participacao_social_conferencia.ft_ano_realizacao,
	tb_participacao_social_conferencia.cd_forma_participacao_conferencia,
	(SELECT tx_nome_forma_participacao_conferencia FROM syst.dc_forma_participacao_conferencia WHERE cd_forma_participacao_conferencia = tb_participacao_social_conferencia.cd_forma_participacao_conferencia) AS tx_nome_forma_participacao_conferencia,
	tb_participacao_social_conferencia.ft_forma_participacao_conferencia
FROM osc.tb_osc
INNER JOIN osc.tb_participacao_social_conferencia
ON tb_osc.id_osc = tb_participacao_social_conferencia.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_participacao_social_conferencia OWNER TO postgres;
-- ddl-end --