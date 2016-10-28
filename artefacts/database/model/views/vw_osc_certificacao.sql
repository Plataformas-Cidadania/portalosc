-- object: portal.vw_osc_certificado | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_certificado CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_certificado
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_certificado.id_certificado,
	(SELECT tx_nome_certificado FROM syst.dc_certificado WHERE dc_certificado.cd_certificado = tb_certificado.cd_certificado) AS tx_nome_certificado,
	tb_certificado.dt_inicio_certificado,
	tb_certificado.dt_fim_certificado,
	tb_certificado.ft_certificado
FROM osc.tb_osc
INNER JOIN osc.tb_certificado ON tb_osc.id_osc = tb_certificado.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_certificado OWNER TO postgres;
-- ddl-end --