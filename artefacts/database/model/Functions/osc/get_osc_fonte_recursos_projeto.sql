CREATE OR REPLACE FUNCTION portal.get_osc_fonte_recursos_projeto(id_request INTEGER) RETURNS TABLE (
	id_fonte_recursos_projeto INTEGER,
	tx_nome_fonte_recursos_projeto TEXT,
	ft_fonte_recursos_projeto TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_fonte_recursos_projeto.id_fonte_recursos_projeto,
			vw_osc_fonte_recursos_projeto.tx_nome_fonte_recursos_projeto,
			vw_osc_fonte_recursos_projeto.ft_fonte_recursos_projeto
		FROM portal.vw_osc_fonte_recursos_projeto
		WHERE vw_osc_fonte_recursos_projeto.id_projeto = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'