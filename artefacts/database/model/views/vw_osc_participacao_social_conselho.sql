-- object: portal.vw_osc_participacao_social_conselho | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_participacao_social_conselho CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_participacao_social_conselho
AS 

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_participacao_social_conselho.id_conselho,
	(SELECT tx_nome_conselho FROM syst.dc_conselho WHERE cd_conselho = tb_participacao_social_conselho.cd_conselho) AS tx_nome_conselho,
	tb_participacao_social_conselho.ft_conselho AS ft_nome_conselho,
	(SELECT tx_nome_tipo_participacao FROM syst.dc_tipo_participacao WHERE dc_tipo_participacao.cd_tipo_participacao = tb_participacao_social_conselho.cd_tipo_participacao) AS tx_nome_tipo_participacao,
	tb_participacao_social_conselho.ft_tipo_participacao AS ft_nome_tipo_participacao,
	tb_participacao_social_conselho.tx_periodicidade_reuniao,
	tb_participacao_social_conselho.ft_periodicidade_reuniao,
	tb_participacao_social_conselho.dt_data_inicio_conselho,
	tb_participacao_social_conselho.ft_data_inicio_conselho,
	tb_participacao_social_conselho.dt_data_fim_conselho,
	tb_participacao_social_conselho.ft_data_fim_conselho
FROM osc.tb_osc
INNER JOIN osc.tb_participacao_social_conselho ON tb_osc.id_osc = tb_participacao_social_conselho.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_participacao_social_conselho OWNER TO postgres;
-- ddl-end --