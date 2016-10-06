CREATE OR REPLACE FUNCTION portal.get_osc_recursos(id_request INTEGER) RETURNS TABLE (
	nr_valor_total DOUBLE PRECISION,
	nr_valor_federal DOUBLE PRECISION,
	nr_valor_estadual DOUBLE PRECISION,
	nr_valor_municipal DOUBLE PRECISION,
	nr_valor_privado DOUBLE PRECISION,
	nr_valor_proprio DOUBLE PRECISION,
	tx_link_relatorio_auditoria TEXT,
	ft_link_relatorio_auditoria TEXT,
	tx_link_demonstracao_contabil TEXT,
	ft_link_demonstracao_contabil TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_recursos.nr_valor_total,
			vw_osc_recursos.nr_valor_federal,
			vw_osc_recursos.nr_valor_estadual,
			vw_osc_recursos.nr_valor_municipal,
			vw_osc_recursos.nr_valor_privado,
			vw_osc_recursos.nr_valor_proprio,
			vw_osc_recursos.tx_link_relatorio_auditoria,
			vw_osc_recursos.ft_link_relatorio_auditoria,
			vw_osc_recursos.tx_link_demonstracao_contabil,
			vw_osc_recursos.ft_link_demonstracao_contabil
		FROM portal.vw_osc_recursos
		WHERE vw_osc_recursos.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'
