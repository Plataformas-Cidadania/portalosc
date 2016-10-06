CREATE OR REPLACE FUNCTION portal.get_osc_area_atuacao_outra(id_request INTEGER) RETURNS TABLE (
	id_area_atuacao_outra INTEGER,
	tx_nome_area_atuacao_declarada TEXT,
	ft_area_declarada TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_area_atuacao_outra.id_area_atuacao_outra,
			vw_osc_area_atuacao_outra.tx_nome_area_atuacao_declarada,
			vw_osc_area_atuacao_outra.ft_area_declarada
		FROM portal.vw_osc_area_atuacao_outra
		WHERE vw_osc_area_atuacao_outra.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'
