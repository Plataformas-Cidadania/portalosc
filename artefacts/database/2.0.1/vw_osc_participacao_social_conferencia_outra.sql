-- object: portal.vw_osc_participacao_social_conferencia | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_participacao_social_conferencia_outra CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_participacao_social_conferencia_outra
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_participacao_social_conferencia_outra.id_conferencia_outra,
	tb_participacao_social_conferencia_outra.tx_nome_conferencia,
	tb_participacao_social_conferencia_outra.ft_nome_conferencia,
	TO_CHAR(tb_participacao_social_conferencia_outra.dt_ano_realizacao, 'DD-MM-YYYY') AS dt_ano_realizacao,
	tb_participacao_social_conferencia_outra.ft_ano_realizacao,
	tb_participacao_social_conferencia_outra.cd_forma_participacao_conferencia,
	(SELECT tx_nome_forma_participacao_conferencia FROM syst.dc_forma_participacao_conferencia WHERE cd_forma_participacao_conferencia = tb_participacao_social_conferencia_outra.cd_forma_participacao_conferencia) AS tx_nome_forma_participacao_conferencia,
	tb_participacao_social_conferencia_outra.ft_forma_participacao_conferencia
FROM osc.tb_osc
INNER JOIN osc.tb_participacao_social_conferencia_outra
ON tb_osc.id_osc = tb_participacao_social_conferencia_outra.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_participacao_social_conferencia_outra OWNER TO postgres;
-- ddl-end --