DROP FUNCTION IF EXISTS portal.buscar_osc_municipio_geo(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_municipio_geo(param NUMERIC) RETURNS TABLE(
	id_osc INTEGER, 
	geo_lat DOUBLE PRECISION, 
	geo_lng DOUBLE PRECISION
) AS $$ 

DECLARE 
	id_osc_search INTEGER; 

BEGIN 
	RETURN QUERY 
		SELECT 
			vw_resultado_busca.id_osc, 
			vw_resultado_busca.geo_lat, 
			vw_resultado_busca.geo_lng 
		FROM portal.vw_resultado_busca 
		WHERE vw_resultado_busca.id_osc IN (
			SELECT * FROM portal.buscar_osc_municipio(param)
		); 
END; 
$$ LANGUAGE 'plpgsql';
