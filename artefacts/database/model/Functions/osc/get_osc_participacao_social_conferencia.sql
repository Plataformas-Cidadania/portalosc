CREATE OR REPLACE FUNCTION portal.get_osc_participacao_social_conferencia(id_request INTEGER) RETURNS TABLE (
	id_conferencia INTEGER,
	tx_nome_conferencia TEXT,
	ft_nome_conferencia TEXT,
	dt_data_inicio_conferencia DATE,
	ft_data_inicio_conferencia TEXT,
	dt_data_fim_conferencia DATE,
	ft_data_fim_conferencia TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_participacao_social_conferencia.id_conferencia,
			vw_osc_participacao_social_conferencia.tx_nome_conferencia,
			vw_osc_participacao_social_conferencia.ft_nome_conferencia,
			vw_osc_participacao_social_conferencia.dt_data_inicio_conferencia,
			vw_osc_participacao_social_conferencia.ft_data_inicio_conferencia,
			vw_osc_participacao_social_conferencia.dt_data_fim_conferencia,
			vw_osc_participacao_social_conferencia.ft_data_fim_conferencia
		FROM portal.vw_osc_participacao_social_conferencia
		WHERE vw_osc_participacao_social_conferencia.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'
