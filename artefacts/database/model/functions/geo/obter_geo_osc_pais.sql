DROP FUNCTION IF EXISTS portal.obter_geo_osc_pais();

CREATE OR REPLACE FUNCTION portal.obter_geo_osc_pais() RETURNS TABLE (
	id_osc INTEGER,
	geo_lat DOUBLE PRECISION,
	geo_lng DOUBLE PRECISION
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			id_osc,
			geo_lat,
			geo_lng
		FROM portal.vw_geo_osc
		WHERE geo_lat IS NOT NULL AND geo_lng IS NOT NULL;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
