-- object: portal.vw_osc_area_atuacao | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_area_atuacao CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_area_atuacao
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_area_atuacao.id_area_atuacao,
	tb_area_atuacao.cd_area_atuacao,
	(SELECT tx_nome_area_atuacao FROM syst.dc_area_atuacao WHERE cd_area_atuacao = tb_area_atuacao.cd_area_atuacao) AS tx_nome_area_atuacao,
	tb_area_atuacao.cd_subarea_atuacao,
	(SELECT tx_nome_subarea_atuacao FROM syst.dc_subarea_atuacao WHERE cd_subarea_atuacao = tb_area_atuacao.cd_subarea_atuacao) AS tx_nome_subarea_atuacao,
	tb_area_atuacao.ft_area_atuacao
FROM osc.tb_osc
INNER JOIN osc.tb_area_atuacao ON tb_osc.id_osc = tb_area_atuacao.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_area_atuacao OWNER TO postgres;
-- ddl-end --