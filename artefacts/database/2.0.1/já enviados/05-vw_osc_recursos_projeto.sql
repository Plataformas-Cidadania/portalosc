-- object: portal.vw_osc_recursos_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_recursos_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_recursos_projeto
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	sum(tb_projeto.nr_valor_total_projeto) AS nr_valor_total,
	tb_dados_gerais.tx_link_relatorio_auditoria,
	tb_dados_gerais.ft_link_relatorio_auditoria,
	tb_dados_gerais.tx_link_demonstracao_contabil,
	tb_dados_gerais.ft_link_demonstracao_contabil
FROM osc.tb_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
INNER JOIN osc.tb_projeto ON tb_projeto.id_osc = tb_osc.id_osc
WHERE tb_osc.bo_osc_ativa
GROUP BY 
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_dados_gerais.tx_link_relatorio_auditoria,
	tb_dados_gerais.ft_link_relatorio_auditoria,
	tb_dados_gerais.tx_link_demonstracao_contabil,
	tb_dados_gerais.ft_link_demonstracao_contabil;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_recursos_projeto OWNER TO postgres;
-- ddl-end --