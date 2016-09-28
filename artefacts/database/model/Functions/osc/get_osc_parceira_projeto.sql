CREATE OR REPLACE FUNCTION portal.get_osc_parceira_projeto(id_request INTEGER) RETURNS TABLE (
	tx_nome_osc_parceira_projeto TEXT,
	ft_osc_parceira_projeto TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_parceira_projeto.tx_nome_osc_parceira_projeto,
			vw_osc_parceira_projeto.ft_osc_parceira_projeto
		FROM portal.vw_osc_parceira_projeto
		WHERE vw_osc_parceira_projeto.id_projeto = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'