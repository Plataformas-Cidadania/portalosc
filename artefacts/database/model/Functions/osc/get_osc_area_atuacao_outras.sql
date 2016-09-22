CREATE OR REPLACE FUNCTION portal.get_osc_area_atuacao_outra(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	tx_nome_area_atuacao_declarada TEXT,
	ft_area_declarada TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_area_atuacao_outra AS area_atuacao_outra
		WHERE area_atuacao_outra.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'