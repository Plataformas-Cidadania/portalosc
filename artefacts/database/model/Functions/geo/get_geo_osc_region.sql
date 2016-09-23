CREATE OR REPLACE FUNCTION portal.get_geo_osc_country(idgeo SMALLINT) RETURNS TABLE (
	id_osc INTEGER,
	geo_localizacao GEOMETRY(Point,4674),
	ft_localizacao TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT view.id_osc, view.geo_localizacao, view.ft_localizacao
		FROM portal.vw_geo_osc AS view
		WHERE cd_regiao = idgeo;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'