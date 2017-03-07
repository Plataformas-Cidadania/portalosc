-- object: portal.vw_osc_relacoes_trabalho_outra | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_relacoes_trabalho_outra CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_relacoes_trabalho_outra
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_relacoes_trabalho_outra.nr_trabalhadores,
	tb_relacoes_trabalho_outra.ft_trabalhadores,
	tb_relacoes_trabalho_outra.tx_tipo_relacao_trabalho,
	tb_relacoes_trabalho_outra.ft_tipo_relacao_trabalho
FROM osc.tb_osc
INNER JOIN osc.tb_relacoes_trabalho_outra ON tb_osc.id_osc = tb_relacoes_trabalho_outra.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_relacoes_trabalho_outra OWNER TO postgres;
-- ddl-end --