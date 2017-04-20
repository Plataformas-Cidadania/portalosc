DROP FUNCTION IF EXISTS portal.obter_geo_osc(idosc INTEGER);

CREATE OR REPLACE FUNCTION portal.obter_geo_osc(idosc INTEGER) RETURNS TABLE (
	geo_lat DOUBLE PRECISION,
	geo_lng DOUBLE PRECISION
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_geo_osc.geo_lat,
			vw_geo_osc.geo_lng
		FROM osc.vw_geo_osc
		WHERE vw_geo_osc.id_osc = idosc;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'
