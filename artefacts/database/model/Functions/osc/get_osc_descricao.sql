CREATE OR REPLACE FUNCTION portal.get_osc_descricao(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	tx_como_surgiu TEXT,
	ft_como_surgiu TEXT,
	tx_missao_osc TEXT,
	ft_missao_osc TEXT,
	tx_visao_osc TEXT,
	ft_visao_osc TEXT,
	tx_finalidades_estatutarias TEXT,
	ft_finalidades_estatutarias TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_descricao AS descricao
		WHERE descricao.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'