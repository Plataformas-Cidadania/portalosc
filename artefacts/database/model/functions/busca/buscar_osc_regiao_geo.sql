DROP FUNCTION IF EXISTS portal.buscar_osc_regiao_geo(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_regiao_geo(param NUMERIC) RETURNS TABLE(
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
		FROM
			portal.vw_geo_osc
		WHERE
			cd_regiao = param AND vw_geo_osc.geo_lat IS NOT NULL AND vw_geo_osc.geo_lng IS NOT NULL;
END;
$$ LANGUAGE 'plpgsql';
