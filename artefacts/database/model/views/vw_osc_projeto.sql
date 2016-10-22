-- object: portal.vw_osc_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_projeto
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	projeto.id_projeto,
	projeto.tx_identificador_projeto_externo,
	projeto.ft_identificador_projeto_externo,
	projeto.tx_nome_projeto,
	projeto.ft_nome_projeto,
	(SELECT dc_status_projeto.tx_nome_status_projeto FROM syst.dc_status_projeto WHERE dc_status_projeto.cd_status_projeto = projeto.cd_status_projeto) AS tx_nome_status_projeto,
	projeto.ft_status_projeto,
	projeto.dt_data_inicio_projeto,
	projeto.ft_data_inicio_projeto,
	projeto.dt_data_fim_projeto,
	projeto.ft_data_fim_projeto,
	projeto.tx_link_projeto,
	projeto.ft_link_projeto,
	projeto.nr_total_beneficiarios,
	projeto.ft_total_beneficiarios,
	projeto.nr_valor_total_projeto,
	projeto.ft_valor_total_projeto,
	projeto.nr_valor_captado_projeto,
	projeto.ft_valor_captado_projeto,
	projeto.tx_metodologia_monitoramento,
	projeto.ft_metodologia_monitoramento,
	projeto.tx_descricao_projeto,
	projeto.ft_descricao_projeto,
	(SELECT dc_abrangencia_projeto.tx_nome_abrangencia_projeto FROM syst.dc_abrangencia_projeto WHERE dc_abrangencia_projeto.cd_abrangencia_projeto = projeto.cd_abrangencia_projeto) AS tx_nome_abrangencia_projeto,
	projeto.ft_abrangencia_projeto,
	(SELECT dc_zona_atuacao_projeto.tx_nome_zona_atuacao FROM syst.dc_zona_atuacao_projeto WHERE dc_zona_atuacao_projeto.cd_zona_atuacao_projeto = projeto.cd_zona_atuacao_projeto) AS tx_nome_zona_atuacao,
	projeto.ft_zona_atuacao_projeto
FROM osc.tb_osc
JOIN osc.tb_projeto projeto ON tb_osc.id_osc = projeto.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_projeto OWNER TO postgres;
-- ddl-end --