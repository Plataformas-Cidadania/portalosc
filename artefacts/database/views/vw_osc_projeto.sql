-- object: portal.vw_osc_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_projeto
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_projeto.id_projeto,
	tb_projeto.tx_identificador_projeto_externo,
	tb_projeto.ft_identificador_projeto_externo,
	tb_projeto.tx_nome_projeto,
	tb_projeto.ft_nome_projeto,
	tb_projeto.cd_status_projeto,
	(SELECT tx_nome_status_projeto FROM syst.dc_status_projeto WHERE cd_status_projeto = tb_projeto.cd_status_projeto) AS tx_nome_status_projeto,
	tb_projeto.ft_status_projeto,
	TO_CHAR(tb_projeto.dt_data_inicio_projeto, 'DD-MM-YYYY') AS dt_data_inicio_projeto,
	tb_projeto.ft_data_inicio_projeto,
	TO_CHAR(tb_projeto.dt_data_fim_projeto, 'DD-MM-YYYY') AS dt_data_fim_projeto,
	tb_projeto.ft_data_fim_projeto,
	tb_projeto.tx_link_projeto,
	tb_projeto.ft_link_projeto,
	tb_projeto.nr_total_beneficiarios,
	tb_projeto.ft_total_beneficiarios,
	TRIM(TO_CHAR(tb_projeto.nr_valor_total_projeto,'99999999999999999D99')) AS nr_valor_total_projeto,
	tb_projeto.ft_valor_total_projeto,
	TRIM(TO_CHAR(tb_projeto.nr_valor_captado_projeto,'99999999999999999D99')) AS nr_valor_captado_projeto,
	tb_projeto.ft_valor_captado_projeto,
	tb_projeto.tx_metodologia_monitoramento,
	tb_projeto.ft_metodologia_monitoramento,
	tb_projeto.tx_descricao_projeto,
	tb_projeto.ft_descricao_projeto,
	tb_projeto.cd_abrangencia_projeto,
	(SELECT tx_nome_abrangencia_projeto FROM syst.dc_abrangencia_projeto WHERE cd_abrangencia_projeto = tb_projeto.cd_abrangencia_projeto) AS tx_nome_abrangencia_projeto,
	tb_projeto.ft_abrangencia_projeto,
	tb_projeto.cd_zona_atuacao_projeto,
	(SELECT tx_nome_zona_atuacao FROM syst.dc_zona_atuacao_projeto WHERE cd_zona_atuacao_projeto = tb_projeto.cd_zona_atuacao_projeto) AS tx_nome_zona_atuacao,
	tb_projeto.ft_zona_atuacao_projeto
FROM osc.tb_osc
JOIN osc.tb_projeto ON tb_osc.id_osc = tb_projeto.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_projeto OWNER TO postgres;
-- ddl-end --