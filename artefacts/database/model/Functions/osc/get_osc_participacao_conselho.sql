CREATE OR REPLACE FUNCTION portal.get_osc_participacao_conselho(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	nm_conselho CHARACTER VARYING(100),
	ft_conselho TEXT,
	nr_numero_assentos INTEGER,
	ft_numero_assentos TEXT,
	tx_periodicidade_reuniao TEXT,
	ft_periodicidade_reuniao TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_participacao_conselho AS conselho
		WHERE conselho.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'