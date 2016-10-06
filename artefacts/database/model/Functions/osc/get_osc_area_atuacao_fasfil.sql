CREATE OR REPLACE FUNCTION portal.get_osc_area_atuacao_fasfil(id_request INTEGER) RETURNS TABLE (
	id_area_atuacao_osc INTEGER,
	tx_nome_macro_area_fasfil TEXT,
	tx_nome_area_fasfil TEXT,
	ft_area_atuacao_fasfil TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_area_atuacao_fasfil.id_area_atuacao_osc,
			vw_osc_area_atuacao_fasfil.tx_nome_macro_area_fasfil,
			vw_osc_area_atuacao_fasfil.tx_nome_area_fasfil,
			vw_osc_area_atuacao_fasfil.ft_area_atuacao_fasfil
		FROM portal.vw_osc_area_atuacao_fasfil
		WHERE vw_osc_area_atuacao_fasfil.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'
