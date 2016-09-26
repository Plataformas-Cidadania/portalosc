CREATE OR REPLACE FUNCTION portal.get_osc_parceira_projeto(id_request INTEGER) RETURNS TABLE (
	id_projeto INTEGER,
	id_osc INTEGER,
	tx_nome_osc_parceira_projeto TEXT,
	ft_osc_parceira_projeto TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_parceira_projeto AS parceira
		WHERE parceira.id_projeto = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'