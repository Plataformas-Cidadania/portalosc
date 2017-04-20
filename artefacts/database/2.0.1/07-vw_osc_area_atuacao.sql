-- object: portal.vw_osc_area_atuacao | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_area_atuacao CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_area_atuacao
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_area_atuacao.cd_area_atuacao,
	tx_nome_area_atuacao AS tx_nome_area_atuacao,
	tb_area_atuacao.tx_nome_outra AS tx_nome_area_atuacao_outra,
	tb_area_atuacao.cd_subarea_atuacao,
	tx_nome_subarea_atuacao AS tx_nome_subarea_atuacao,
	tb_area_atuacao.tx_nome_outra AS tx_nome_subarea_atuacao_outra,
	tb_area_atuacao.ft_area_atuacao,
	tb_area_atuacao.bo_oficial
FROM osc.tb_osc
INNER JOIN osc.tb_area_atuacao ON tb_osc.id_osc = tb_area_atuacao.id_osc
INNER JOIN syst.dc_area_atuacao ON syst.dc_area_atuacao.cd_area_atuacao = osc.tb_area_atuacao.cd_area_atuacao
INNER JOIN syst.dc_subarea_atuacao ON syst.dc_subarea_atuacao.cd_subarea_atuacao = osc.tb_area_atuacao.cd_subarea_atuacao
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_area_atuacao OWNER TO postgres;
-- ddl-end --