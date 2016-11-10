DROP FUNCTION IF EXISTS portal.obter_geo_osc_pais();

CREATE OR REPLACE FUNCTION portal.obter_geo_osc_pais() RETURNS TABLE (
	id_osc INTEGER,
	geo_lat DOUBLE PRECISION,
	geo_lng DOUBLE PRECISION
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			portal.vw_geo_osc.id_osc,
			portal.vw_geo_osc.geo_lat,
			portal.vw_geo_osc.geo_lng
		FROM portal.vw_geo_osc
		WHERE portal.vw_geo_osc.geo_lat IS NOT NULL AND portal.vw_geo_osc.geo_lng IS NOT NULL;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
