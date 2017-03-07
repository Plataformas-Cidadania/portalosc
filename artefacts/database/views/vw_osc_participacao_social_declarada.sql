-- object: portal.vw_osc_participacao_social_declarada | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_participacao_social_declarada CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_participacao_social_declarada
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_participacao_social_declarada.id_participacao_social_declarada,
	tb_participacao_social_declarada.tx_nome_participacao_social_declarada,
	tb_participacao_social_declarada.ft_nome_participacao_social_declarada,
	tb_participacao_social_declarada.tx_tipo_participacao_social_declarada,
	tb_participacao_social_declarada.ft_tipo_participacao_social_declarada,
	TO_CHAR(tb_participacao_social_declarada.dt_data_ingresso_participacao_social_declarada, 'DD-MM-YYYY') AS dt_data_ingresso_participacao_social_declarada,
	tb_participacao_social_declarada.ft_data_ingresso_participacao_social_declarada
FROM osc.tb_osc
INNER JOIN osc.tb_participacao_social_declarada ON tb_osc.id_osc = tb_participacao_social_declarada.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_participacao_social_declarada OWNER TO postgres;
-- ddl-end --