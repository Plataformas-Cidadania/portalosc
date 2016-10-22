-- object: portal.vw_osc_area_atuacao | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_area_atuacao CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_area_atuacao
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_area_atuacao.id_area_atuacao,
	(SELECT dc_area_atuacao.tx_nome_area_atuacao FROM syst.dc_area_atuacao WHERE dc_area_atuacao.cd_area_atuacao = tb_area_atuacao.cd_area_atuacao) AS tx_nome_area_atuacao,
	(SELECT dc_subarea_atuacao.tx_nome_subarea_atuacao FROM syst.dc_subarea_atuacao WHERE dc_subarea_atuacao.cd_subarea_atuacao = tb_area_atuacao.cd_subarea_atuacao) AS tx_nome_subarea_atuacao,
	tb_area_atuacao.ft_area_atuacao,
	(SELECT dc_subclasse_atividade_economica.tx_nome_subclasse_atividade_economica FROM syst.dc_subclasse_atividade_economica WHERE dc_subclasse_atividade_economica.cd_subclasse_atividade_economica = tb_dados_gerais.cd_subclasse_atividade_economica_osc) AS tx_nome_atividade_economica,
	tb_dados_gerais.ft_subclasse_atividade_economica_osc AS ft_atividade_economica
FROM osc.tb_osc
INNER JOIN osc.tb_area_atuacao ON tb_osc.id_osc = tb_area_atuacao.id_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_area_atuacao OWNER TO postgres;
-- ddl-end --