DROP FUNCTION IF EXISTS portal.obter_osc_certificado(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_certificado(param TEXT) RETURNS TABLE (
	id_certificado INTEGER, 
	cd_certificado INTEGER, 
	tx_nome_certificado TEXT, 
	dt_inicio_certificado TEXT, 
	dt_fim_certificado TEXT, 
	ft_certificado TEXT, 
	bo_oficial BOOLEAN
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_certificado.id_certificado, 
			vw_osc_certificado.cd_certificado, 
			vw_osc_certificado.tx_nome_certificado, 
			vw_osc_certificado.dt_inicio_certificado, 
			vw_osc_certificado.dt_fim_certificado, 
			vw_osc_certificado.ft_certificado, 
			vw_osc_certificado.bo_oficial 
		FROM portal.vw_osc_certificado 
		WHERE 
			vw_osc_certificado.id_osc::TEXT = param OR 
			vw_osc_certificado.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
