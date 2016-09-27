CREATE OR REPLACE FUNCTION portal.get_osc_certificacao(id_request INTEGER) RETURNS TABLE (
	nm_certificado TEXT,
	dt_inicio_certificado DATE,
	dt_fim_certificado DATE,
	ft_certificado TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_certificacao.nm_certificado TEXT,
			vw_osc_certificacao.dt_inicio_certificado,
			vw_osc_certificacao.dt_fim_certificado,
			vw_osc_certificacao.ft_certificado
		FROM portal.vw_osc_certificacao
		WHERE vw_osc_certificacao.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'