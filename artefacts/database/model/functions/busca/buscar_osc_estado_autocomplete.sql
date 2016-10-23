DROP FUNCTION IF EXISTS portal.buscar_osc_estado_autocomplete(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_estado_autocomplete(param NUMERIC) RETURNS TABLE(
	id_osc INTEGER, 
	tx_nome_osc TEXT
) AS $$ 
DECLARE 
	id_osc_search INTEGER;
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_resultado_busca.id_osc, 
			vw_resultado_busca.tx_nome_osc 
		FROM portal.vw_resultado_busca 
		WHERE vw_resultado_busca.id_osc IN (
			SELECT * FROM portal.buscar_osc_estado(param)
		); 
END; 
$$ LANGUAGE 'plpgsql';
