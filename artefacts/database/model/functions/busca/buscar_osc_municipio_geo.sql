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
			vw_busca_resultado.id_osc, 
			vw_busca_resultado.geo_lat, 
			vw_busca_resultado.geo_lng 
		FROM portal.vw_busca_resultado 
		WHERE vw_busca_resultado.id_osc IN (
			SELECT * FROM portal.buscar_osc_municipio(param)
		); 
END; 
$$ LANGUAGE 'plpgsql';
