CREATE OR REPLACE FUNCTION portal.get_osc_participacao_social_outra(id_request INTEGER) RETURNS TABLE (
	id_outra_participacao_social INTEGER,
	tx_nome_outra_participacao_social TEXT,
	ft_nome_outra_participacao_social TEXT,
	tx_tipo_outra_participacao_social TEXT,
	ft_tipo_outra_participacao_social TEXT,
	dt_data_ingresso_outra_participacao_social DATE,
	ft_data_ingresso_outra_participacao_social TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_participacao_social_outra.id_outra_participacao_social,
			vw_osc_participacao_social_outra.tx_nome_outra_participacao_social,
			vw_osc_participacao_social_outra.ft_nome_outra_participacao_social,
			vw_osc_participacao_social_outra.tx_tipo_outra_participacao_social,
			vw_osc_participacao_social_outra.ft_tipo_outra_participacao_social,
			vw_osc_participacao_social_outra.dt_data_ingresso_outra_participacao_social,
			vw_osc_participacao_social_outra.ft_data_ingresso_outra_participacao_social
		FROM portal.vw_osc_participacao_social_outra
		WHERE vw_osc_participacao_social_outra.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'