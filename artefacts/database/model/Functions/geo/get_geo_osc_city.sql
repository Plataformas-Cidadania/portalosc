CREATE OR REPLACE FUNCTION portal.get_geo_osc_city(idgeo NUMERIC(7, 0)) RETURNS TABLE (
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
		FROM portal.vw_geo_osc
		WHERE vw_geo_osc.cd_municipio = idgeo;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'