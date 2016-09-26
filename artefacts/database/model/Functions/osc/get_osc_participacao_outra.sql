CREATE OR REPLACE FUNCTION portal.get_osc_participacao_outra(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	tx_nome_outra_participacao_social TEXT,
	ft_nome_outra_participacao_social TEXT,
	tx_tipo_outra_participacao_social TEXT,
	ft_tipo_outra_participacao_social TEXT,
	dt_data_ingresso_outra_participacao_social DATE,
	ft_data_ingresso_outra_participacao_social TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_participacao_outra AS participacao
		WHERE participacao.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'