-- object: portal.vw_osc_area_atuacao_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_area_atuacao_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_area_atuacao_projeto
AS

SELECT
	tb_area_atuacao_projeto.id_projeto,
	tb_area_atuacao_projeto.cd_subarea_atuacao AS cd_area_atuacao_projeto,
	(SELECT tx_nome_subarea_atuacao FROM syst.dc_subarea_atuacao WHERE dc_subarea_atuacao.cd_subarea_atuacao = tb_area_atuacao_projeto.cd_subarea_atuacao) AS tx_nome_area_atuacao_projeto,
	tb_area_atuacao_projeto.ft_area_atuacao_projeto
FROM osc.tb_osc
INNER JOIN osc.tb_projeto ON tb_projeto.id_osc = tb_osc.id_osc
INNER JOIN osc.tb_area_atuacao_projeto ON tb_area_atuacao_projeto.id_projeto = osc.tb_projeto.id_projeto
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_area_atuacao_projeto OWNER TO postgres;
-- ddl-end --