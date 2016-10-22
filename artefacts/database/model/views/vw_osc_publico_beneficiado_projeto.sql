-- object: portal.vw_osc_publico_beneficiado_projeto | type: VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_publico_beneficiado_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_publico_beneficiado_projeto
AS

SELECT
	publico_beneficiado.id_projeto,
	publico_beneficiado.id_publico_beneficiado,
	(SELECT tb_publico_beneficiado.tx_nome_publico_beneficiado FROM osc.tb_publico_beneficiado WHERE tb_publico_beneficiado.id_publico_beneficiado = publico_beneficiado.id_publico_beneficiado) AS tx_nome_publico_beneficiado,
	publico_beneficiado.ft_publico_beneficiado_projeto
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_publico_beneficiado_projeto AS publico_beneficiado
ON publico_beneficiado.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_publico_beneficiado_projeto OWNER TO postgres;
-- ddl-end --