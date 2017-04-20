DROP FUNCTION IF EXISTS portal.buscar_osc_por_cnpj(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_por_cnpj(param NUMERIC) RETURNS TABLE(
	id_osc INTEGER, 
	tx_nome_osc TEXT
) AS $$ 

BEGIN
	RETURN QUERY 
		SELECT 
			vw_busca_resultado.id_osc, 
			vw_busca_resultado.tx_nome_osc, 
			vw_busca_resultado.cd_identificador_osc 
		FROM 
			osc.vw_busca_resultado 
		WHERE 
			vw_busca_resultado.cd_identificador_osc = param::NUMERIC; 
END; 
$$ LANGUAGE 'plpgsql';