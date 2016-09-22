CREATE OR REPLACE FUNCTION portal.get_osc_projeto(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	tx_nome_projeto TEXT,
	ft_nome_projeto TEXT,
	tx_nome_status_projeto TEXT,
	ft_status_projeto TEXT,
	dt_data_inicio_projeto DATE,
	ft_data_inicio_projeto TEXT,
	dt_data_fim_projeto DATE,
	ft_data_fim_projeto TEXT,
	tx_link_projeto TEXT,
	ft_link_projeto TEXT,
	nr_total_beneficiarios SMALLINT,
	ft_total_beneficiarios TEXT,
	nr_valor_total_projeto DOUBLE PRECISION,
	ft_valor_total_projeto TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_projeto AS projeto
		WHERE projeto.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'