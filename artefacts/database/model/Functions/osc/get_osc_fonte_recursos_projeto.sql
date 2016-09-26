CREATE OR REPLACE FUNCTION portal.get_osc_fonte_recursos_projeto(id_request INTEGER) RETURNS TABLE (
	id_projeto INTEGER,
	tx_nome_fonte_recursos_projeto TEXT,
	ft_fonte_recursos_projeto TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_fonte_recursos_projeto AS fonte_recursos
		WHERE fonte_recursos.id_projeto = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'