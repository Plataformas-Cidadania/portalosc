-- object: portal.vw_osc_participacao_social_outra | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_participacao_social_outra CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_participacao_social_outra
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_participacao_social_outra.id_outra_participacao_social,
	tb_participacao_social_outra.tx_nome_outra_participacao_social,
	tb_participacao_social_outra.ft_nome_outra_participacao_social,
	tb_participacao_social_outra.tx_tipo_outra_participacao_social,
	tb_participacao_social_outra.ft_tipo_outra_participacao_social,
	tb_participacao_social_outra.dt_data_ingresso_outra_participacao_social,
	tb_participacao_social_outra.ft_data_ingresso_outra_participacao_social
FROM osc.tb_osc
INNER JOIN osc.tb_participacao_social_outra ON tb_osc.id_osc = tb_participacao_social_outra.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_participacao_social_outra OWNER TO postgres;
-- ddl-end --