DROP FUNCTION portal.obter_osc_certificacao(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_certificacao(param TEXT) RETURNS TABLE (
	id_certificado INTEGER, 
	tx_nome_certificado TEXT, 
	dt_inicio_certificado DATE, 
	dt_fim_certificado DATE, 
	ft_certificado TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_certificacao.id_certificado, 
			vw_osc_certificacao.tx_nome_certificado, 
			vw_osc_certificacao.dt_inicio_certificado, 
			vw_osc_certificacao.dt_fim_certificado, 
			vw_osc_certificacao.ft_certificado 
		FROM portal.vw_osc_certificacao 
		WHERE 
			vw_osc_certificacao.id_osc::TEXT = param OR 
			vw_osc_certificacao.tx_url_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
