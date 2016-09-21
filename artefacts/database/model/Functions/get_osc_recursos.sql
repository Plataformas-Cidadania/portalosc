CREATE OR REPLACE FUNCTION portal.get_osc_recursos(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	nr_valor_total DOUBLE PRECISION,
	tx_link_relatorio_auditoria TEXT,
	ft_link_relatorio_auditoria TEXT,
	tx_link_demonstracao_contabil TEXT,
	ft_link_demonstracao_contabil TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_recursos AS recursos
		WHERE recursos.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'