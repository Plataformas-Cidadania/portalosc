CREATE OR REPLACE FUNCTION portal.get_osc_conselho_contabil(id_request INTEGER) RETURNS TABLE (
	id_conselheiro INTEGER,
	tx_nome_conselheiro TEXT,
	ft_nome_conselheiro TEXT,
	tx_cargo_conselheiro TEXT,
	ft_cargo_conselheiro TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_conselho_contabil.id_conselheiro,
			vw_osc_conselho_contabil.tx_nome_conselheiro,
			vw_osc_conselho_contabil.ft_nome_conselheiro,
			vw_osc_conselho_contabil.tx_cargo_conselheiro,
			vw_osc_conselho_contabil.ft_cargo_conselheiro
		FROM portal.vw_osc_conselho_contabil
		WHERE vw_osc_conselho_contabil.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'