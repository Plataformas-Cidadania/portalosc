-- object: portal.vw_osc_fonte_recursos_projeto | type: VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_fonte_recursos_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_fonte_recursos_projeto
AS

SELECT
	tb_fonte_recursos_projeto.id_projeto,
	tb_fonte_recursos_projeto.id_fonte_recursos_projeto,
	tb_fonte_recursos_projeto.cd_origem_fonte_recursos_projeto,
	(SELECT tx_nome_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE cd_origem_fonte_recursos_projeto = tb_fonte_recursos_projeto.cd_origem_fonte_recursos_projeto) AS tx_nome_origem_fonte_recursos_projeto,
	tb_fonte_recursos_projeto.ft_fonte_recursos_projeto
FROM osc.tb_osc
INNER JOIN osc.tb_projeto ON osc.tb_osc.id_osc = osc.tb_projeto.id_osc
INNER JOIN osc.tb_fonte_recursos_projeto ON tb_fonte_recursos_projeto.id_projeto = osc.tb_projeto.id_projeto
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_fonte_recursos_projeto OWNER TO postgres;
-- ddl-end --