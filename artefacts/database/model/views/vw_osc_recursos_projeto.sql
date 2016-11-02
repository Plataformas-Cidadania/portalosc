-- object: portal.vw_osc_recursos_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_recursos_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_recursos_projeto
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	(SELECT sum(tb_projeto.nr_valor_total_projeto) FROM osc.tb_projeto WHERE tb_projeto.id_osc = tb_osc.id_osc) AS nr_valor_total,
	(SELECT sum(projeto.nr_valor_total_projeto)	FROM osc.tb_projeto AS projeto INNER JOIN osc.tb_fonte_recursos_projeto AS recursos	ON projeto.id_projeto = recursos.id_projeto	WHERE (
		SELECT tx_nome_fonte_recursos_projeto
		FROM syst.dc_fonte_recursos_projeto
		WHERE cd_fonte_recursos_projeto = recursos.cd_fonte_recursos_projeto
	) = 'Público Federal') AS nr_valor_federal,
	(SELECT sum(projeto.nr_valor_total_projeto)	FROM osc.tb_projeto AS projeto INNER JOIN osc.tb_fonte_recursos_projeto AS recursos	ON projeto.id_projeto = recursos.id_projeto	WHERE (
		SELECT tx_nome_fonte_recursos_projeto
		FROM syst.dc_fonte_recursos_projeto
		WHERE cd_fonte_recursos_projeto = recursos.cd_fonte_recursos_projeto
	) = 'Público Estadual') AS nr_valor_estadual,
	(SELECT sum(projeto.nr_valor_total_projeto)	FROM osc.tb_projeto AS projeto INNER JOIN osc.tb_fonte_recursos_projeto AS recursos	ON projeto.id_projeto = recursos.id_projeto	WHERE (
		SELECT tx_nome_fonte_recursos_projeto
		FROM syst.dc_fonte_recursos_projeto
		WHERE cd_fonte_recursos_projeto = recursos.cd_fonte_recursos_projeto
	) = 'Público Municipal') AS nr_valor_municipal,
	(SELECT sum(projeto.nr_valor_total_projeto)	FROM osc.tb_projeto AS projeto INNER JOIN osc.tb_fonte_recursos_projeto AS recursos	ON projeto.id_projeto = recursos.id_projeto	WHERE (
		SELECT tx_nome_fonte_recursos_projeto
		FROM syst.dc_fonte_recursos_projeto
		WHERE cd_fonte_recursos_projeto = recursos.cd_fonte_recursos_projeto
	) = 'Privado') AS nr_valor_privado,
	(SELECT sum(projeto.nr_valor_total_projeto)	FROM osc.tb_projeto AS projeto INNER JOIN osc.tb_fonte_recursos_projeto AS recursos	ON projeto.id_projeto = recursos.id_projeto	WHERE (
		SELECT tx_nome_fonte_recursos_projeto
		FROM syst.dc_fonte_recursos_projeto
		WHERE cd_fonte_recursos_projeto = recursos.cd_fonte_recursos_projeto
	) = 'Próprio') AS nr_valor_proprio,
	tb_dados_gerais.tx_link_relatorio_auditoria,
	tb_dados_gerais.ft_link_relatorio_auditoria,
	tb_dados_gerais.tx_link_demonstracao_contabil,
	tb_dados_gerais.ft_link_demonstracao_contabil
FROM osc.tb_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_recursos_projeto OWNER TO postgres;
-- ddl-end --