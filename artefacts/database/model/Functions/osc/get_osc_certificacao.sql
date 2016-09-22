CREATE OR REPLACE FUNCTION portal.get_osc_certificacao(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	nm_certificado TEXT,
	dt_inicio_certificado DATE,
	dt_fim_certificado DATE,
	ft_certificado TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_certificacao AS certificacao
		WHERE certificacao.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'