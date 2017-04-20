DROP FUNCTION IF EXISTS portal.obter_geo_osc_pais();

CREATE OR REPLACE FUNCTION portal.obter_geo_osc_pais() RETURNS TABLE (
	id_osc INTEGER,
	geo_lat DOUBLE PRECISION,
	geo_lng DOUBLE PRECISION
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_geo_osc.id_osc,
			round(vw_geo_osc.geo_lat::decimal, 6)::double precision,
			round(vw_geo_osc.geo_lng::decimal, 6)::double precision
		FROM osc.vw_geo_osc
		WHERE vw_geo_osc.geo_lat IS NOT NULL AND vw_geo_osc.geo_lng IS NOT NULL;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
