-- object: portal.vw_osc_relacoes_trabalho | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_relacoes_trabalho CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_relacoes_trabalho
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	(tb_relacoes_trabalho.nr_trabalhadores_vinculo + tb_relacoes_trabalho.nr_trabalhadores_deficiencia + tb_relacoes_trabalho.nr_trabalhadores_voluntarios) AS nr_trabalhadores,
	tb_relacoes_trabalho.nr_trabalhadores_vinculo,
	tb_relacoes_trabalho.ft_trabalhadores_vinculo,
	tb_relacoes_trabalho.nr_trabalhadores_deficiencia,
	tb_relacoes_trabalho.ft_trabalhadores_deficiencia,
	tb_relacoes_trabalho.nr_trabalhadores_voluntarios,
	tb_relacoes_trabalho.ft_trabalhadores_voluntarios
FROM osc.tb_osc
INNER JOIN osc.tb_relacoes_trabalho ON tb_osc.id_osc = tb_relacoes_trabalho.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_relacoes_trabalho OWNER TO postgres;
-- ddl-end --