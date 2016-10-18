DROP FUNCTION IF EXISTS portal.obter_geo_osc_municipio(idgeo NUMERIC(7, 0));

CREATE OR REPLACE FUNCTION portal.obter_geo_osc_municipio(idgeo NUMERIC(7, 0)) RETURNS TABLE (
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
$$ LANGUAGE 'plpgsql';
