CREATE OR REPLACE FUNCTION portal.get_geo_osc_city(idgeo NUMERIC(7, 0)) RETURNS TABLE (
	id_osc INTEGER,
	geo_localizacao GEOMETRY(Point,4674),
	ft_localizacao TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT view.id_osc, view.geo_localizacao, view.ft_localizacao
		FROM portal.vw_geo_osc AS view
		WHERE cd_municipio = idgeo;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'