CREATE OR REPLACE FUNCTION portal.get_osc_area_atuacao_outra_projeto(id_request INTEGER) RETURNS TABLE (
	tx_nome_area_atuacao_outra TEXT,
	ft_area_atuacao_outra TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_area_atuacao_outra_projeto.tx_nome_area_atuacao_outra,
			vw_osc_area_atuacao_outra_projeto.ft_area_atuacao_outra
		FROM portal.vw_osc_area_atuacao_outra_projeto
		WHERE vw_osc_area_atuacao_outra_projeto.id_projeto = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'