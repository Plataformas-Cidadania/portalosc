CREATE OR REPLACE FUNCTION portal.get_osc_publico_beneficiado_projeto(id_request INTEGER) RETURNS TABLE (
	id_projeto INTEGER,
	tx_nome_publico_beneficiado TEXT,
	ft_area_atuacao_outra TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_publico_beneficiado_projeto AS publico_beneficiado
		WHERE publico_beneficiado.id_projeto = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'