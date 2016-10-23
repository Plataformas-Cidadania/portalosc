DROP FUNCTION IF EXISTS portal.buscar_osc_autocomplete(param TEXT, limit_result INTEGER, offset_result INTEGER);

CREATE OR REPLACE FUNCTION portal.buscar_osc_autocomplete(param TEXT, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	id_osc INTEGER, 
	tx_nome_osc TEXT
) AS $$ 

BEGIN 
	RETURN QUERY 
		SELECT 
			vw_resultado_busca.id_osc, 
			vw_resultado_busca.tx_nome_osc 
		FROM 
			portal.vw_resultado_busca 
		WHERE 
			vw_resultado_busca.id_osc IN (
				SELECT * FROM portal.buscar_osc(param, limit_result, offset_result)
			); 
END; 
$$ LANGUAGE 'plpgsql';