DROP FUNCTION IF EXISTS portal.obter_osc_certificado(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_certificado(param TEXT) RETURNS TABLE (
	id_certificado INTEGER, 
	tx_nome_certificado TEXT, 
	dt_inicio_certificado DATE, 
	dt_fim_certificado DATE, 
	ft_certificado TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_certificado.id_certificado, 
			vw_osc_certificado.tx_nome_certificado, 
			vw_osc_certificado.dt_inicio_certificado, 
			vw_osc_certificado.dt_fim_certificado, 
			vw_osc_certificado.ft_certificado 
		FROM portal.vw_osc_certificado 
		WHERE 
			vw_osc_certificado.id_osc::TEXT = param OR 
			vw_osc_certificado.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
