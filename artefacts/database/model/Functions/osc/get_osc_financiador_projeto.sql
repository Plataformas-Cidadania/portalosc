CREATE OR REPLACE FUNCTION portal.get_osc_financiador_projeto(id_request INTEGER) RETURNS TABLE (
	id_projeto INTEGER,
	tx_nome_financiador TEXT,
	ft_nome_financiador TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_financiador_projeto AS financiador
		WHERE financiador.id_projeto = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'