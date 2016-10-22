-- object: portal.vw_osc_fonte_recursos_projeto | type: VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_fonte_recursos_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_fonte_recursos_projeto
AS

SELECT
	fonte_recurso.id_projeto,
	fonte_recurso.id_fonte_recursos_projeto,
	(SELECT dc_fonte_recursos.tx_nome_fonte_recursos FROM syst.dc_fonte_recursos WHERE dc_fonte_recursos.cd_fonte_recursos = fonte_recurso.cd_fonte_recursos) AS tx_nome_fonte_recursos,
	fonte_recurso.ft_fonte_recursos_projeto
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_fonte_recursos_projeto AS fonte_recurso
ON fonte_recurso.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_fonte_recursos_projeto OWNER TO postgres;
-- ddl-end --