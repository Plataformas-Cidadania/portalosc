CREATE OR REPLACE FUNCTION portal.get_osc_localizacao_projeto(id_request INTEGER) RETURNS TABLE (
	id_projeto INTEGER,
	id_regiao_localizacao_projeto INTEGER,
	tx_nome_regiao_localizacao_projeto TEXT,
	ft_nome_regiao_localizacao_projeto TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_localizacao_projeto AS localizacao
		WHERE localizacao.id_projeto = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'