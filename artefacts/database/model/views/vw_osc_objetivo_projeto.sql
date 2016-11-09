-- object: portal.vw_osc_objetivo_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_objetivo_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_objetivo_projeto
AS

SELECT
	tb_objetivo_projeto.id_projeto,
	tb_objetivo_projeto.id_objetivo_projeto,
	(SELECT cd_objetivo_projeto FROM syst.dc_objetivo_projeto WHERE cd_objetivo_projeto = (SELECT cd_objetivo_projeto FROM syst.dc_meta_projeto WHERE cd_meta_projeto = tb_objetivo_projeto.cd_meta_projeto)) AS cd_objetivo_projeto,
	(SELECT tx_nome_objetivo_projeto FROM syst.dc_objetivo_projeto WHERE cd_objetivo_projeto = (SELECT cd_objetivo_projeto FROM syst.dc_meta_projeto WHERE cd_meta_projeto = tb_objetivo_projeto.cd_meta_projeto)) AS tx_nome_objetivo_projeto,
	tb_objetivo_projeto.cd_meta_projeto,
	(SELECT tx_nome_meta_projeto FROM syst.dc_meta_projeto WHERE cd_meta_projeto = tb_objetivo_projeto.cd_meta_projeto) AS tx_nome_meta_projeto,
	tb_objetivo_projeto.ft_objetivo_projeto 
FROM osc.tb_osc
INNER JOIN osc.tb_projeto ON osc.tb_projeto.id_osc = osc.tb_osc.id_osc
INNER JOIN osc.tb_objetivo_projeto ON tb_objetivo_projeto.id_projeto = osc.tb_projeto.id_projeto
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_objetivo_projeto OWNER TO postgres;
-- ddl-end --