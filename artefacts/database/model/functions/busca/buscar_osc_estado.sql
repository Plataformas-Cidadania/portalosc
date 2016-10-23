DROP FUNCTION IF EXISTS portal.buscar_osc_estado(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_estado(param NUMERIC) RETURNS TABLE(
	id_osc INTEGER
) AS $$ 

DECLARE 
	id_osc_search INTEGER; 

BEGIN 
	RETURN QUERY 
		SELECT 
			vw_busca_osc_geo.id_osc 
		FROM 
			portal.vw_busca_osc_geo 
		WHERE 
			vw_busca_osc_geo.cd_estado = param::NUMERIC(2, 0); 
END; 
$$ LANGUAGE 'plpgsql';
