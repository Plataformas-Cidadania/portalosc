CREATE OR REPLACE FUNCTION portal.get_geo_osc_country() RETURNS TABLE (
	id_osc INTEGER,
	geo_localizacao GEOMETRY(Point,4674)
) AS $$
BEGIN
	RETURN QUERY
		SELECT view.id_osc, view.geo_localizacao
		FROM portal.vw_geo_osc AS view;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'