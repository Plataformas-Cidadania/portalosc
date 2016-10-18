DROP FUNCTION IF EXISTS portal.obter_geo_osc_estado(idgeo SMALLINT);

CREATE OR REPLACE FUNCTION portal.obter_geo_osc_estado(idgeo SMALLINT) RETURNS TABLE (
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
		WHERE vw_geo_osc.cd_estado = idgeo;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
