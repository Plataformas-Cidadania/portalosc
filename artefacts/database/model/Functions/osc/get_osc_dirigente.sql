CREATE OR REPLACE FUNCTION portal.get_osc_dirigente(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	tx_cargo_dirigente TEXT,
	ft_cargo_dirigente TEXT,
	tx_nome_dirigente TEXT,
	ft_nome_dirigente TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_dirigente AS dirigente
		WHERE dirigente.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'