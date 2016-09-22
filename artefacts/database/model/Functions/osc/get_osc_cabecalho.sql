CREATE OR REPLACE FUNCTION portal.get_osc_cabecalho(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	cd_identificador_osc NUMERIC(14, 0),
	ft_identificador_osc TEXT,
	tx_razao_social_osc TEXT,
	ft_razao_social_osc TEXT,
	tx_subclasse_atividade_economica TEXT,
	ft_atividade_economica_osc TEXT,
	tx_natureza_juridica TEXT,
	ft_natureza_juridica_osc TEXT,
	im_logo BYTEA,
	ft_logo TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_cabecalho AS dados_gerais
		WHERE dados_gerais.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'