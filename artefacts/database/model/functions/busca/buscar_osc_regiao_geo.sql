DROP FUNCTION IF EXISTS portal.buscar_osc_regiao_geo(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_regiao_geo(param NUMERIC) RETURNS TABLE(
	id_osc INTEGER, 
	geo_lat DOUBLE PRECISION, 
	geo_lng DOUBLE PRECISION
) AS $$

BEGIN
	RETURN QUERY
		SELECT
			vw_geo_osc.id_osc, 
			vw_geo_osc.geo_lat, 
			vw_geo_osc.geo_lng 
		FROM
			portal.vw_geo_osc
		WHERE
			cd_regiao = param;
END;
$$ LANGUAGE 'plpgsql';
