CREATE OR REPLACE FUNCTION portal.get_osc_area_atuacao_outra_projeto(id_request INTEGER) RETURNS TABLE (
	id_projeto INTEGER,
	tx_nome_area_atuacao_outra TEXT,
	ft_area_atuacao_outra TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_area_atuacao_outra_projeto AS area_atuacao
		WHERE area_atuacao.id_projeto = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'