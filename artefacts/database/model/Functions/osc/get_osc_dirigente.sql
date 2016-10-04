CREATE OR REPLACE FUNCTION portal.get_osc_dirigente(id_request INTEGER) RETURNS TABLE (
	id_dirigente INTEGER,
	tx_cargo_dirigente TEXT,
	ft_cargo_dirigente TEXT,
	tx_nome_dirigente TEXT,
	ft_nome_dirigente TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_dirigente.id_dirigente,
			vw_osc_dirigente.tx_cargo_dirigente,
			vw_osc_dirigente.ft_cargo_dirigente,
			vw_osc_dirigente.tx_nome_dirigente,
			vw_osc_dirigente.ft_nome_dirigente
		FROM portal.vw_osc_dirigente
		WHERE vw_osc_dirigente.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'