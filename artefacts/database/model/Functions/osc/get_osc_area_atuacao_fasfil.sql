CREATE OR REPLACE FUNCTION portal.get_osc_area_atuacao_fasfil(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	tx_nome_macro_area_fasfil TEXT,
	tx_nome_area_fasfil TEXT,
	ft_area_atuacao_fasfil TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_area_atuacao_fasfil AS area_atuacao_fasfil
		WHERE area_atuacao_fasfil.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'