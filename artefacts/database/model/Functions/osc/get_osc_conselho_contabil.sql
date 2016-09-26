CREATE OR REPLACE FUNCTION portal.get_osc_conselho_contabil(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	id_conselheiro INTEGER,
	tx_nome_conselheiro TEXT,
	ft_nome_conselheiro TEXT,
	tx_cargo_conselheiro TEXT,
	ft_cargo_conselheiro TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_conselho_contabil AS conselho_contabil
		WHERE conselho_contabil.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'