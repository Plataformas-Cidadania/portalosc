CREATE OR REPLACE FUNCTION portal.get_osc_conferencia(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	tx_nome_conferencia TEXT,
	ft_nome_conferencia TEXT,
	dt_data_inicio_conferencia DATE,
	ft_data_inicio_conferencia TEXT,
	dt_data_fim_conferencia DATE,
	ft_data_fim_conferencia TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_conferencia AS conferencia
		WHERE conferencia.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'