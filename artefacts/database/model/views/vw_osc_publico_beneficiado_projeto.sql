-- object: portal.vw_osc_publico_beneficiado_projeto | type: VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_publico_beneficiado_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_publico_beneficiado_projeto
AS

SELECT
	tb_publico_beneficiado_projeto.id_projeto,
	tb_publico_beneficiado_projeto.id_publico_beneficiado,
	(SELECT tx_nome_publico_beneficiado FROM osc.tb_publico_beneficiado WHERE id_publico_beneficiado = tb_publico_beneficiado_projeto.id_publico_beneficiado) AS tx_nome_publico_beneficiado,
	tb_publico_beneficiado_projeto.nr_estimativa_pessoas_atendidas,
	tb_publico_beneficiado_projeto.ft_publico_beneficiado_projeto
FROM osc.tb_osc
INNER JOIN osc.tb_publico_beneficiado_projeto
ON tb_publico_beneficiado_projeto.id_projeto IN (SELECT id_projeto FROM osc.tb_projeto WHERE id_osc = tb_osc.id_osc)
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_publico_beneficiado_projeto OWNER TO postgres;
-- ddl-end --