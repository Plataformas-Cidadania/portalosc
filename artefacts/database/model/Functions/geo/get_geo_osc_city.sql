CREATE OR REPLACE FUNCTION portal.get_geo_osc_city(idgeo NUMERIC(7, 0)) RETURNS TABLE (
	id_osc INTEGER,
	geo_localizacao GEOMETRY(Point,4674)
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_geo_osc.id_osc,
			vw_geo_osc.geo_localizacao
		FROM portal.vw_geo_osc
		WHERE vw_geo_osc.cd_municipio = idgeo;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'